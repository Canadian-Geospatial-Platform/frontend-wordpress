<?php

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if (!class_exists('WP_Importer')) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if (file_exists($class_wp_importer)) {
        require $class_wp_importer;
    }

}

/**
 * Importer class for managing the import process of a WXR file
 *
 * @package WordPress
 * @subpackage Importer
 */

if (class_exists('WP_Importer')) {

    class Pauple_WP_Importer extends WP_Importer
    {

        public $max_wxr_version = 1.2; // max. supported WXR version
        public $errors = [
            'critical' => [],
            'warning' => [],
            'notice' => [],
        ];

        public $id; // WXR attachment ID

        // information to import from WXR file
        public $version;
        public $authors = array();
        public $posts = array();
        public $terms = array();
        public $categories = array();
        public $tags = array();
        public $base_url = '';

        // mappings from old information to new
        public $processed_authors = array();
        public $author_mapping = array();
        public $processed_terms = array();
        public $processed_posts = array();
        public $post_orphans = array();

        public $imported_entries = array(
            'articles' => array(),
            'pages' => array(),
            'faqs' => array(),
            'attachments' => array(),
            'topics' => array(),
            'faq_topics' => array(),
            'tags' => array(),
            'up_tags' => array(),
            'add_tags' => array(),
        );

        public $fetch_attachments = false;
        public $url_remap = array();
        public $featured_images = array();

        /**
         * The main controller for the actual import stage.
         *
         * @param string $file Path to the WXR file for importing
         */

        public function import($data)
        {
            add_filter('import_post_meta_key', array($this, 'is_valid_meta_key'));
            add_filter('http_request_timeout', array(&$this, 'bump_request_timeout'));

            $this->import_start($data);

            $this->get_author_mapping();

            wp_suspend_cache_invalidation(true);
            $this->process_categories();
            $this->process_tags();
            $this->process_terms();
            $this->process_posts();
            wp_suspend_cache_invalidation(false);

            // update incorrect/missing information in the DB
            $this->backfill_parents();
            $this->backfill_attachment_urls();
            $this->remap_featured_images();

            $this->import_end();

            return ['result' => $this->imported_entries, 'error' => $this->errors];
        }

        /**
         * Parses the WXR file and prepares us for the task of processing parsed data
         *
         * @param string $file Path to the WXR file for importing
         */
        public function import_start($data)
        {

            $import_data = $data;

            $this->version = $import_data['version'];
            $this->get_authors_from_import($import_data);
            $this->posts = $import_data['posts'];
            $this->terms = $import_data['terms'];
            $this->categories = $import_data['categories'];
            $this->tags = $import_data['tags'];
            $this->base_url = esc_url($import_data['base_url']);

            wp_defer_term_counting(true);
            wp_defer_comment_counting(true);
        }

        /**
         * Performs post-import cleanup of files and the cache
         */
        public function import_end()
        {
            wp_import_cleanup($this->id);

            wp_cache_flush();
            foreach (get_taxonomies() as $tax) {
                delete_option("{$tax}_children");
                _get_term_hierarchy($tax);
            }

            wp_defer_term_counting(false);
            wp_defer_comment_counting(false);

            array_push($this->errors['notice'], [
                'message' => __('All done.', 'pauple-helpie') . ' ' . __('Have fun!', 'pauple-helpie'),
            ]);

            $this->remap_builder_pages();
            $this->set_topic_images();
        }

        // TODO
        /**
         *  As IDs in Elementor page builder are irrelevant, we need to remap them manually
         */
        public function remap_builder_pages()
        {

        }

        // TODO
        /**
         * Set topic images for Modern demo
         */
        public function set_topic_images()
        {
        }

        /**
         * Retrieve authors from parsed WXR data
         *
         * Uses the provided author information from WXR 1.1 files
         * or extracts info from each post for WXR 1.0 files
         *
         * @param array $import_data Data returned by a WXR parser
         */
        public function get_authors_from_import($import_data)
        {
            if (!empty($import_data['authors'])) {
                $this->authors = $import_data['authors'];
                // no author information, grab it from the posts
            } else {
                foreach ($import_data['posts'] as $post) {
                    $login = sanitize_user($post['post_author'], true);
                    if (empty($login)) {
                        array_push($this->errors['notice'], [
                            'message' => sprintf(__('Failed to import author %s. Their posts will be attributed to the current user.', 'pauple-helpie'), esc_html($post['post_author'])),
                        ]);
                        continue;
                    }

                    if (!isset($this->authors[$login])) {
                        $this->authors[$login] = array(
                            'author_login' => $login,
                            'author_display_name' => $post['post_author'],
                        );
                    }

                }
            }
        }

        public function get_author_mapping()
        {
            if (!isset($_POST['imported_authors'])) {
                return;
            }

            $create_users = false;

            foreach ((array) $_POST['imported_authors'] as $i => $old_login) {
                // Multisite adds strtolower to sanitize_user. Need to sanitize here to stop breakage in process_posts.
                $santized_old_login = sanitize_user($old_login, true);
                $old_id = isset($this->authors[$old_login]['author_id']) ? intval($this->authors[$old_login]['author_id']) : false;

                if (!empty($_POST['user_map'][$i])) {
                    $user = get_userdata(intval($_POST['user_map'][$i]));
                    if (isset($user->ID)) {
                        if ($old_id) {
                            $this->processed_authors[$old_id] = $user->ID;
                        }

                        $this->author_mapping[$santized_old_login] = $user->ID;
                    }
                } else if ($create_users) {
                    if (!empty($_POST['user_new'][$i])) {
                        $user_id = wp_create_user($_POST['user_new'][$i], wp_generate_password());
                    } else if ($this->version != '1.0') {
                        $user_data = array(
                            'user_login' => $old_login,
                            'user_pass' => wp_generate_password(),
                            'user_email' => isset($this->authors[$old_login]['author_email']) ? $this->authors[$old_login]['author_email'] : '',
                            'display_name' => $this->authors[$old_login]['author_display_name'],
                            'first_name' => isset($this->authors[$old_login]['author_first_name']) ? $this->authors[$old_login]['author_first_name'] : '',
                            'last_name' => isset($this->authors[$old_login]['author_last_name']) ? $this->authors[$old_login]['author_last_name'] : '',
                        );
                        $user_id = wp_insert_user($user_data);
                    }

                    if (!is_wp_error($user_id)) {
                        if ($old_id) {
                            $this->processed_authors[$old_id] = $user_id;
                        }

                        $this->author_mapping[$santized_old_login] = $user_id;
                    } else {
                        array_push($this->errors['warning'], [
                            'error' => $user_id->get_error_message(),
                            'message' => sprintf(__('Failed to create new user for %s. Their posts will be attributed to the current user.', 'pauple-helpie'), esc_html($this->authors[$old_login]['author_display_name'])),
                        ]);
                    }
                }

                // failsafe: if the user_id was invalid, default to the current user
                if (!isset($this->author_mapping[$santized_old_login])) {
                    if ($old_id) {
                        $this->processed_authors[$old_id] = (int) get_current_user_id();
                    }

                    $this->author_mapping[$santized_old_login] = (int) get_current_user_id();
                }
            }
        }

        /**
         * Create new categories based on import information
         *
         * Doesn't create a new category if its slug already exists
         */
        public function process_categories()
        {

            if (empty($this->categories)) {
                return;
            }

            foreach ($this->categories as $cat) {
                // if the category already exists leave it alone
                $term_id = term_exists($cat['category_nicename'], 'category');
                if ($term_id) {
                    if (is_array($term_id)) {
                        $term_id = $term_id['term_id'];
                    }

                    if (isset($cat['term_id'])) {
                        $this->processed_terms[intval($cat['term_id'])] = (int) $term_id;
                    }

                    continue;
                }

                $category_parent = empty($cat['category_parent']) ? 0 : category_exists($cat['category_parent']);
                $category_description = isset($cat['category_description']) ? $cat['category_description'] : '';
                $catarr = array(
                    'category_nicename' => $cat['category_nicename'],
                    'category_parent' => $category_parent,
                    'cat_name' => $cat['cat_name'],
                    'category_description' => $category_description,
                );
                $catarr = wp_slash($catarr);

                $id = wp_insert_category($catarr);
                if (!is_wp_error($id)) {
                    if (isset($cat['term_id'])) {
                        $this->processed_terms[intval($cat['term_id'])] = $id;
                    }

                } else {
                    array_push($this->errors['warning'], [
                        'error' => $id->get_error_message(),
                        'message' => sprintf(__('Failed to import category %s', 'pauple-helpie'), esc_html($cat['category_nicename'])),
                    ]);
                    continue;
                }

                $this->process_termmeta($cat, $id['term_id']);
            }

            unset($this->categories);
        }

        /**
         * Create new post tags based on import information
         *
         * Doesn't create a tag if its slug already exists
         */
        public function process_tags()
        {

            if (empty($this->tags)) {
                return;
            }

            foreach ($this->tags as $tag) {
                // if the tag already exists leave it alone
                $term_id = term_exists($tag['tag_slug'], 'post_tag');
                if ($term_id) {
                    if (is_array($term_id)) {
                        $term_id = $term_id['term_id'];
                    }

                    if (isset($tag['term_id'])) {
                        $this->processed_terms[intval($tag['term_id'])] = (int) $term_id;
                    }

                    continue;
                }

                $tag = wp_slash($tag);
                $tag_desc = isset($tag['tag_description']) ? $tag['tag_description'] : '';
                $tagarr = array('slug' => $tag['tag_slug'], 'description' => $tag_desc);

                $id = wp_insert_term($tag['tag_name'], 'post_tag', $tagarr);
                if (!is_wp_error($id)) {
                    if (isset($tag['term_id'])) {
                        $this->processed_terms[intval($tag['term_id'])] = $id['term_id'];
                    }

                } else {
                    array_push($this->errors['warning'], [
                        'error' => $id->get_error_message(),
                        'message' => sprintf(__('Failed to import post tag %s', 'pauple-helpie'), esc_html($tag['tag_name'])),
                    ]);
                    continue;
                }

                $this->process_termmeta($tag, $id['term_id']);
            }

            unset($this->tags);
        }

        /**
         * Create new terms based on import information
         *
         * Doesn't create a term its slug already exists
         */
        public function process_terms()
        {

            if (empty($this->terms)) {
                return;
            }

            foreach ($this->terms as $term) {

                if (isset($this->terms_mapping[$term['term_taxonomy']])) {
                    $term['term_taxonomy'] = $this->terms_mapping[$term['term_taxonomy']];
                }

                // if the term already exists in the correct taxonomy leave it alone
                $term_id = term_exists($term['slug'], $term['term_taxonomy']);

                // CASE 1: term already exists
                if ($term_id) {
                    if (is_array($term_id)) {
                        $term_id = $term_id['term_id'];
                    }

                    if (isset($term['term_id'])) {
                        $this->processed_terms[intval($term['term_id'])] = (int) $term_id;

                        switch ($term['term_taxonomy']) {
                            case 'helpdesk_category':
                                array_push($this->imported_entries['topics'], (int) $term_id);
                                break;

                            case 'helpie_tag':
                                array_push($this->imported_entries['tags'], (int) $term_id);
                                break;

                            case 'helpie_up_tag':
                                array_push($this->imported_entries['up_tags'], (int) $term_id);
                                break;

                            case 'helpie_add_tag':
                                array_push($this->imported_entries['add_tags'], (int) $term_id);
                                break;

                            case 'helpie_faq_category':
                                array_push($this->imported_entries['faq_topics'], (int) $term_id);
                                break;

                            default:
                                break;
                        }

                        array_push($this->errors['notice'], [
                            'message' => sprintf(__('Term &#8220;%s&#8221; already exists.', 'pauple-helpie'), esc_html($term['term_name'])),
                        ]);
                    }
                    continue;
                }

                // CASE 2: new term, create
                if (empty($term['term_parent'])) {
                    $parent = 0;
                } else {
                    $parent = term_exists($term['term_parent'], $term['term_taxonomy']);
                    if (is_array($parent)) {
                        $parent = $parent['term_id'];
                    }
                }

                $term = wp_slash($term);
                $description = isset($term['term_description']) ? $term['term_description'] : '';
                $termarr = array('slug' => $term['slug'], 'description' => $description, 'parent' => intval($parent));

                $id = wp_insert_term($term['term_name'], $term['term_taxonomy'], $termarr);

                if (!is_wp_error($id)) {
                    if (isset($term['term_id'])) {
                        $this->processed_terms[intval($term['term_id'])] = $id['term_id'];
                    }

                    switch ($term['term_taxonomy']) {
                        case 'helpdesk_category':
                            array_push($this->imported_entries['topics'], (int) $id['term_id']);
                            break;

                        case 'helpie_tag':
                            array_push($this->imported_entries['tags'], (int) $id['term_id']);
                            break;

                        case 'helpie_up_tag':
                            array_push($this->imported_entries['up_tags'], (int) $id['term_id']);
                            break;

                        case 'helpie_add_tag':
                            array_push($this->imported_entries['add_tags'], (int) $id['term_id']);
                            break;

                        case 'helpie_faq_category':
                            array_push($this->imported_entries['faq_topics'], (int) $id['term_id']);
                            break;

                        default:
                            break;
                    }

                } else {
                    array_push($this->errors['warning'], [
                        'error' => $id->get_error_message(),
                        'message' => sprintf(__('Failed to import %s %s', 'pauple-helpie'), esc_html($term['term_taxonomy']), esc_html($term['term_name'])),
                    ]);
                    continue;
                }

                $this->process_termmeta($term, $id['term_id']);
            }

            unset($this->terms);
        }

        /**
         * Add metadata to imported term.
         *
         * @since 0.6.2
         *
         * @param array $term    Term data from WXR import.
         * @param int   $term_id ID of the newly created term.
         */
        protected function process_termmeta($term, $term_id)
        {
            if (!isset($term['termmeta'])) {
                $term['termmeta'] = array();
            }

            if (empty($term['termmeta'])) {
                return;
            }

            foreach ($term['termmeta'] as $meta) {

                $key = $meta['key'];
                if (!$key) {
                    continue;
                }

                // Export gets meta straight from the DB so could have a serialized string
                $value = maybe_unserialize($meta['value']);

                add_term_meta($term_id, $key, $value);
            }
        }

        /**
         * Create new posts based on import information
         *
         * Posts marked as having a parent which doesn't exist will become top level items.
         * Doesn't create a new post if: the post type doesn't exist, the given post ID
         * is already noted as imported or a post with the same title and date already exists.
         * Note that new/updated terms, comments and meta are imported for the last of the above.
         */
        public function process_posts()
        {
            foreach ($this->posts as $post) {

                // remap kb posts
                if (isset($this->posts_mapping[$post['post_type']])) {
                    $post['post_type'] = $this->posts_mapping[$post['post_type']];
                }

                if (!post_type_exists($post['post_type'])) {
                    array_push($this->errors['notice'], [
                        'message' => sprintf(
                            __('Failed to import &#8220;%s&#8221;: Invalid post type %s', 'pauple-helpie'),
                            esc_html($post['post_title']),
                            esc_html($post['post_type'])
                        ),
                    ]);
                    continue;
                }

                if (isset($this->processed_posts[$post['post_id']]) && !empty($post['post_id'])) {
                    continue;
                }

                if ($post['status'] == 'auto-draft') {
                    continue;
                }

                if ('nav_menu_item' == $post['post_type']) {
                    $this->process_menu_item($post);
                    continue;
                }

                $post_type_object = get_post_type_object($post['post_type']);

                // returns ID if exists
                $post_exists = post_exists($post['post_title'], '', $post['post_date']);

                if ($post_exists && get_post_type($post_exists) == $post['post_type']) {
                    array_push($this->errors['notice'], [
                        'message' => sprintf(__('%s &#8220;%s&#8221; already exists.', 'pauple-helpie'), $post_type_object->labels->singular_name, esc_html($post['post_title'])),
                    ]);
                    $comment_post_ID = $post_id = $post_exists;
                    $this->processed_posts[intval($post['post_id'])] = intval($post_exists);
                } else {
                    $post_parent = (int) $post['post_parent'];
                    if ($post_parent) {
                        // if we already know the parent, map it to the new local ID
                        if (isset($this->processed_posts[$post_parent])) {
                            $post_parent = $this->processed_posts[$post_parent];
                            // otherwise record the parent for later
                        } else {
                            $this->post_orphans[intval($post['post_id'])] = $post_parent;
                            $post_parent = 0;
                        }
                    }

                    // map the post author
                    $author = sanitize_user($post['post_author'], true);
                    if (isset($this->author_mapping[$author])) {
                        $author = $this->author_mapping[$author];
                    } else {
                        $author = (int) get_current_user_id();
                    }

                    $postdata = array(
                        'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
                        'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
                        'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
                        'post_status' => $post['status'], 'post_name' => $post['post_name'],
                        'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
                        'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
                        'post_type' => $post['post_type'], 'post_password' => $post['post_password'],
                    );

                    $original_post_ID = $post['post_id'];
                    $postdata = wp_slash($postdata);

                    if ('attachment' == $postdata['post_type']) {
                        $remote_url = !empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];

                        // try to use _wp_attached file for upload folder placement to ensure the same location as the export site
                        // e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
                        $postdata['upload_date'] = $post['post_date'];
                        if (isset($post['postmeta'])) {
                            foreach ($post['postmeta'] as $meta) {
                                if ($meta['key'] == '_wp_attached_file') {
                                    if (preg_match('%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches)) {
                                        $postdata['upload_date'] = $matches[0];
                                    }

                                    break;
                                }
                            }
                        }

                        $comment_post_ID = $post_id = $this->process_attachment($postdata, $remote_url);
                    } else {
                        $comment_post_ID = $post_id = wp_insert_post($postdata, true);
                    }

                    if (is_wp_error($post_id)) {
                        array_push($this->errors['warning'], [
                            'error' => $post_id->get_error_message(),
                            'message' => sprintf(__('Failed to import %s &#8220;%s&#8221;', 'pauple-helpie'), $post_type_object->labels->singular_name, esc_html($term['term_name'])),
                        ]);
                        continue;
                    }

                    if ($post['is_sticky'] == 1) {
                        stick_post($post_id);
                    }

                }

                // map pre-import ID to local ID
                $this->processed_posts[intval($post['post_id'])] = (int) $post_id;
                $key = 'none';

                switch ($post['post_type']) {
                    case 'pauple_helpie':
                        $key = 'articles';
                        break;

                    case 'helpie_faq':
                        $key = 'faqs';
                        break;

                    case 'page':
                        $key = 'pages';
                        break;

                    case 'attachment':
                        $key = 'attachments';
                        break;

                    default:
                        break;
                }

                array_push($this->imported_entries[$key], (int) $post_id);

                if (!isset($post['terms'])) {
                    $post['terms'] = array();
                }

                // add categories, tags and other terms
                if (!empty($post['terms'])) {
                    $terms_to_set = array();
                    foreach ($post['terms'] as $term) {
                        // back compat with WXR 1.0 map 'tag' to 'post_tag'
                        $taxonomy = ('tag' == $term['domain']) ? 'post_tag' : $term['domain'];

                        if (isset($this->terms_mapping[$taxonomy])) {
                            $taxonomy = $this->terms_mapping[$taxonomy];
                        }

                        $term_exists = term_exists($term['slug'], $taxonomy);
                        $term_id = is_array($term_exists) ? $term_exists['term_id'] : $term_exists;
                        if (!$term_id) {
                            $t = wp_insert_term($term['name'], $taxonomy, array('slug' => $term['slug']));

                            if (!is_wp_error($t)) {
                                $term_id = $t['term_id'];
                            } else {
                                array_push($this->errors['warning'], [
                                    'error' => $t->get_error_message(),
                                    'message' => sprintf(__('Failed to import %s %s', 'pauple-helpie'), esc_html($taxonomy), esc_html($term['name'])),
                                ]);
                                continue;
                            }
                        }
                        $terms_to_set[$taxonomy][] = intval($term_id);
                    }

                    foreach ($terms_to_set as $tax => $ids) {
                        $tt_ids = wp_set_post_terms($post_id, $ids, $tax);
                    }
                    unset($post['terms'], $terms_to_set);
                }

                if (!isset($post['comments'])) {
                    $post['comments'] = array();
                }

                $post['comments'] = apply_filters('wp_import_post_comments', $post['comments'], $post_id, $post);

                // add/update comments
                if (!empty($post['comments'])) {
                    $num_comments = 0;
                    $inserted_comments = array();
                    foreach ($post['comments'] as $comment) {
                        $comment_id = $comment['comment_id'];
                        $newcomments[$comment_id]['comment_post_ID'] = $comment_post_ID;
                        $newcomments[$comment_id]['comment_author'] = $comment['comment_author'];
                        $newcomments[$comment_id]['comment_author_email'] = $comment['comment_author_email'];
                        $newcomments[$comment_id]['comment_author_IP'] = $comment['comment_author_IP'];
                        $newcomments[$comment_id]['comment_author_url'] = $comment['comment_author_url'];
                        $newcomments[$comment_id]['comment_date'] = $comment['comment_date'];
                        $newcomments[$comment_id]['comment_date_gmt'] = $comment['comment_date_gmt'];
                        $newcomments[$comment_id]['comment_content'] = $comment['comment_content'];
                        $newcomments[$comment_id]['comment_approved'] = $comment['comment_approved'];
                        $newcomments[$comment_id]['comment_type'] = $comment['comment_type'];
                        $newcomments[$comment_id]['comment_parent'] = $comment['comment_parent'];
                        $newcomments[$comment_id]['commentmeta'] = isset($comment['commentmeta']) ? $comment['commentmeta'] : array();
                        if (isset($this->processed_authors[$comment['comment_user_id']])) {
                            $newcomments[$comment_id]['user_id'] = $this->processed_authors[$comment['comment_user_id']];
                        }

                    }
                    ksort($newcomments);

                    foreach ($newcomments as $key => $comment) {
                        // if this is a new post we can skip the comment_exists() check
                        if (!$post_exists || !comment_exists($comment['comment_author'], $comment['comment_date'])) {
                            if (isset($inserted_comments[$comment['comment_parent']])) {
                                $comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
                            }

                            $comment = wp_slash($comment);
                            $comment = wp_filter_comment($comment);

                            $inserted_comments[$key] = wp_insert_comment($comment);

                            foreach ($comment['commentmeta'] as $meta) {
                                $value = maybe_unserialize($meta['value']);
                                add_comment_meta($inserted_comments[$key], $meta['key'], $value);
                            }

                            $num_comments++;
                        }
                    }
                    unset($newcomments, $inserted_comments, $post['comments']);
                }

                if (!isset($post['postmeta'])) {
                    $post['postmeta'] = array();
                }

                // add/update post meta
                if (!empty($post['postmeta'])) {
                    foreach ($post['postmeta'] as $meta) {
                        $key = $meta['key'];
                        $value = false;

                        if ('_edit_last' == $key) {
                            if (isset($this->processed_authors[intval($meta['value'])])) {
                                $value = $this->processed_authors[intval($meta['value'])];
                            } else {
                                $key = false;
                            }

                        }

                        if ($key) {
                            // export gets meta straight from the DB so could have a serialized string
                            if (!$value) {
                                $value = maybe_unserialize($meta['value']);
                            }

                            add_post_meta($post_id, $key, $value);

                            // if the post has a featured image, take note of this in case of remap
                            if ('_thumbnail_id' == $key) {
                                $this->featured_images[$post_id] = (int) $value;
                            }

                        }
                    }
                }
            }

            unset($this->posts);
        }

        /**
         * If fetching attachments is enabled then attempt to create a new attachment
         *
         * @param array $post Attachment post details from WXR
         * @param string $url URL to fetch attachment from
         * @return int|WP_Error Post ID on success, WP_Error otherwise
         */
        public function process_attachment($post, $url)
        {
            // if the URL is absolute, but does not contain address, then upload it assuming base_site_url
            if (preg_match('|^/[\w\W]+$|', $url)) {
                $url = rtrim($this->base_url, '/') . $url;
            }

            $upload = $this->fetch_remote_file($url, $post);
            if (is_wp_error($upload)) {
                return $upload;
            }

            if ($info = wp_check_filetype($upload['file'])) {
                $post['post_mime_type'] = $info['type'];
            } else {
                array_push($this->errors['critical'], [
                    'error' => 'attachment_processing_error',
                    'message' => __('Invalid file type', 'pauple-helpie'),
                ]);
                return;
            }

            $post['guid'] = $upload['url'];

            // as per wp-admin/includes/upload.php
            $post_id = wp_insert_attachment($post, $upload['file']);
            wp_update_attachment_metadata($post_id, wp_generate_attachment_metadata($post_id, $upload['file']));

            // remap resized image URLs, works by stripping the extension and remapping the URL stub.
            if (preg_match('!^image/!', $info['type'])) {
                $parts = pathinfo($url);
                $name = basename($parts['basename'], ".{$parts['extension']}"); // PATHINFO_FILENAME in PHP 5.2

                $parts_new = pathinfo($upload['url']);
                $name_new = basename($parts_new['basename'], ".{$parts_new['extension']}");

                $this->url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
            }

            return $post_id;
        }

        /**
         * Attempt to download a remote file attachment
         *
         * @param string $url URL of item to fetch
         * @param array $post Attachment details
         * @return array|WP_Error Local file location details on success, WP_Error otherwise
         */
        public function fetch_remote_file($url, $post)
        {
            // extract the file name and extension from the url
            $file_name = basename($url);

            // get placeholder file in the upload dir with a unique, sanitized filename
            $upload = wp_upload_bits($file_name, 0, '', $post['upload_date']);
            if ($upload['error']) {
                array_push($this->errors['critical'], [
                    'error' => 'upload_dir_error',
                    'message' => $upload['error'],
                ]);
                return;
            }

            // fetch the remote url and write it to the placeholder file
            $remote_response = wp_safe_remote_get($url, array(
                'timeout' => 300,
                'stream' => true,
                'filename' => $upload['file'],
            ));

            $headers = wp_remote_retrieve_headers($remote_response);

            // request failed
            if (!$headers) {
                @unlink($upload['file']);
                array_push($this->errors['critical'], [
                    'error' => 'import_file_error',
                    'message' => __('Remote server did not respond', 'pauple-helpie'),
                ]);
                return;
            }

            $remote_response_code = wp_remote_retrieve_response_code($remote_response);

            // make sure the fetch was successful
            if ($remote_response_code != '200') {
                @unlink($upload['file']);
                array_push($this->errors['critical'], [
                    'error' => 'import_file_error',
                    'message' => sprintf(__('Remote server returned error response %1$d %2$s', 'pauple-helpie'), esc_html($remote_response_code), get_status_header_desc($remote_response_code)),
                ]);
                return;
            }

            $filesize = filesize($upload['file']);

            if (isset($headers['content-length']) && $filesize != $headers['content-length']) {
                @unlink($upload['file']);
                array_push($this->errors['critical'], [
                    'error' => 'import_file_error',
                    'message' => __('Remote file is incorrect size', 'pauple-helpie'),
                ]);
                return;
            }

            if (0 == $filesize) {
                @unlink($upload['file']);
                array_push($this->errors['critical'], [
                    'error' => 'import_file_error',
                    'message' => __('Zero size file downloaded', 'pauple-helpie'),
                ]);
            }

            $max_size = 0;
            if (!empty($max_size) && $filesize > $max_size) {
                @unlink($upload['file']);
                array_push($this->errors['critical'], [
                    'error' => 'import_file_error',
                    'message' => sprintf(__('Remote file is too large, limit is %s', 'pauple-helpie'), size_format($max_size)),
                ]);
                return;
            }

            // keep track of the old and new urls so we can substitute them later
            $this->url_remap[$url] = $upload['url'];
            $this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
            // keep track of the destination if the remote url is redirected somewhere else
            if (isset($headers['x-final-location']) && $headers['x-final-location'] != $url) {
                $this->url_remap[$headers['x-final-location']] = $upload['url'];
            }

            return $upload;
        }

        /**
         * Attempt to associate posts and menu items with previously missing parents
         *
         * An imported post's parent may not have been imported when it was first created
         * so try again. Similarly for child menu items and menu items which were missing
         * the object (e.g. post) they represent in the menu
         */
        public function backfill_parents()
        {
            global $wpdb;

            // find parents for post orphans
            foreach ($this->post_orphans as $child_id => $parent_id) {
                $local_child_id = $local_parent_id = false;
                if (isset($this->processed_posts[$child_id])) {
                    $local_child_id = $this->processed_posts[$child_id];
                }

                if (isset($this->processed_posts[$parent_id])) {
                    $local_parent_id = $this->processed_posts[$parent_id];
                }

                if ($local_child_id && $local_parent_id) {
                    $wpdb->update($wpdb->posts, array('post_parent' => $local_parent_id), array('ID' => $local_child_id), '%d', '%d');
                    clean_post_cache($local_child_id);
                }
            }
        }

        /**
         * Use stored mapping information to update old attachment URLs
         */
        public function backfill_attachment_urls()
        {
            global $wpdb;
            // make sure we do the longest urls first, in case one is a substring of another
            uksort($this->url_remap, array(&$this, 'cmpr_strlen'));

            foreach ($this->url_remap as $from_url => $to_url) {
                // remap urls in post_content
                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url));
                // remap enclosure urls
                $result = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url));
            }
        }

        /**
         * Update _thumbnail_id meta to new, imported attachment IDs
         */
        public function remap_featured_images()
        {
            // cycle through posts that have a featured image
            foreach ($this->featured_images as $post_id => $value) {
                if (isset($this->processed_posts[$value])) {
                    $new_id = $this->processed_posts[$value];
                    // only update if there's a difference
                    if ($new_id != $value) {
                        update_post_meta($post_id, '_thumbnail_id', $new_id);
                    }

                }
            }
        }

        /**
         * Decide if the given meta key maps to information we will want to import
         *
         * @param string $key The meta key to check
         * @return string|bool The key if we do want to import, false if not
         */
        public function is_valid_meta_key($key)
        {
            // skip attachment metadata since we'll regenerate it from scratch
            // skip _edit_lock as not relevant for import
            if (in_array($key, array('_wp_attached_file', '_wp_attachment_metadata', '_edit_lock'))) {
                return false;
            }

            return $key;
        }

        /**
         * Added to http_request_timeout filter to force timeout at 60 seconds during import
         * @return int 60
         */
        public function bump_request_timeout($val)
        {
            return 60;
        }

        // return the difference in length between two strings
        public function cmpr_strlen($a, $b)
        {
            return strlen($b) - strlen($a);
        }
    }

} // class_exists( 'Pauple_WP_Importer' )
