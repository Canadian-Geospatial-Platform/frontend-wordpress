<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Class_Cpt')) {
    class Class_Cpt
    {
        public $post_type_name = 'pauple_helpie';

        public function helpie_load_wp_media_files()
        {
            wp_enqueue_media();
        }

        public function __construct()
        {
            // include_once 'includes/admin/fontawesome-icons.php';
            $this->helpie_model = new \Helpie\Includes\Core\Core_Models\Helpie_Model();
            $this->fontawesome_icons = new \Helpie\Includes\Admin\FontAwesome_Icons();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();

            add_action('init', array($this, 'register_element'));

            /* Add Image Field */

            add_action('helpdesk_category_add_form_fields', array($this, 'add_category_image'), 10, 2);
            add_action('created_helpdesk_category', array($this, 'save_category_image'), 10, 2);
            add_action('helpdesk_category_edit_form_fields', array($this, 'update_category_image_field'), 10, 2);
            add_action('edited_helpdesk_category', array($this, 'update_category_image'), 10, 2);
            add_action('admin_footer', array($this, 'add_script'));

            // add_action( 'helpdesk_category_edit_form_fields', array ( $this, 'update_category_fontawesome' ));

            add_action('admin_enqueue_scripts', array($this, 'helpie_load_wp_media_files'));
        }

        public function register_updated_tag()
        {
            $labels = array(
                'name' => __('Updated Tags', 'pauple-helpie'),
                'singular_name' => __('Updated Tag', 'pauple-helpie'),
                'search_items' => __('Search Updated Tags', 'pauple-helpie'),
                'all_items' => __('All Updated Tags', 'pauple-helpie'),
                'parent_item' => __('Parent Updated Tag', 'pauple-helpie'),
                'parent_item_colon' => __('Parent Updated Tag:', 'pauple-helpie'),
                'edit_item' => __('Edit Updated Tag', 'pauple-helpie'),
                'update_item' => __('Update Updated Tag', 'pauple-helpie'),
                'add_new_item' => __('Add New Updated Tag', 'pauple-helpie'),
                'new_item_name' => __('New Updated Tag Name', 'pauple-helpie'),
                'menu_name' => __('Updated Tag', 'pauple-helpie'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'helpie_up_tag', 'with_front' => false),
            );

            register_taxonomy('helpie_up_tag', array('pauple_helpie'), $args);
        }

        public function register_added_tag()
        {
            $labels = array(
                'name' => __('Added Tags', 'pauple-helpie'),
                'singular_name' => __('Added Tag', 'pauple-helpie'),
                'search_items' => __('Search Added Tags', 'pauple-helpie'),
                'all_items' => __('All Added Tags', 'pauple-helpie'),
                'parent_item' => __('Parent Added Tag', 'pauple-helpie'),
                'parent_item_colon' => __('Parent Added Tag:', 'pauple-helpie'),
                'edit_item' => __('Edit Added Tag', 'pauple-helpie'),
                'update_item' => __('Update Added Tag', 'pauple-helpie'),
                'add_new_item' => __('Add New Added Tag', 'pauple-helpie'),
                'new_item_name' => __('New Added Tag Name', 'pauple-helpie'),
                'menu_name' => __('Added Tag', 'pauple-helpie'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'helpie_add_tag', 'with_front' => false),
            );

            register_taxonomy('helpie_add_tag', array('pauple_helpie'), $args);
        }

        public function register_tag()
        {
            $labels = array(
                'name' => __('Tags', 'pauple-helpie'),
                'singular_name' => __('Tag', 'pauple-helpie'),
                'search_items' => __('Search Tags', 'pauple-helpie'),
                'all_items' => __('All Tags', 'pauple-helpie'),
                'parent_item' => __('Parent Tag', 'pauple-helpie'),
                'parent_item_colon' => __('Parent Tag:', 'pauple-helpie'),
                'edit_item' => __('Edit Tag', 'pauple-helpie'),
                'update_item' => __('Update Tag', 'pauple-helpie'),
                'add_new_item' => __('Add New Tag', 'pauple-helpie'),
                'new_item_name' => __('New Tag Name', 'pauple-helpie'),
                'menu_name' => __('Tag', 'pauple-helpie'),
            );

            $args = array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'helpie_tag', 'with_front' => false),
            );

            register_taxonomy('helpie_tag', array('pauple_helpie'), $args);
        }

        public function register_category()
        {
            // Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name' => __('Wiki Categories', 'pauple-helpie'),
                'singular_name' => __('Wiki Category', 'pauple-helpie'),
                'search_items' => __('Search Wiki Categories', 'pauple-helpie'),
                'all_items' => __('All Wiki Categories', 'pauple-helpie'),
                'parent_item' => __('Parent Wiki Category', 'pauple-helpie'),
                'parent_item_colon' => __('Parent Wiki Category:', 'pauple-helpie'),
                'edit_item' => __('Edit Wiki Category', 'pauple-helpie'),
                'update_item' => __('Update Wiki Category', 'pauple-helpie'),
                'add_new_item' => __('Add New Wiki Category', 'pauple-helpie'),
                'new_item_name' => __('New Wiki Category Name', 'pauple-helpie'),
                'menu_name' => __('Wiki Category', 'pauple-helpie'),
            );

            $cpt_cat_slug = $this->settings->category_page->get_cpt_category_slug();

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => $cpt_cat_slug, 'with_front' => false),
            );

            if (post_type_exists('helpie_faq')) {
                register_taxonomy('helpdesk_category', array('pauple_helpie', 'helpie_faq'), $args);
            } else {
                register_taxonomy('helpdesk_category', array('pauple_helpie'), $args);
            }
        }

        public function register_element()
        {
            $article = $this->settings->single_page->get_single_cpt_name();

            $articles = $this->settings->single_page->get_single_cpt_name_plural();

            $labels = array(
                'name' => _x($articles, 'Post type general name', 'pauple-helpie'),
                'singular_name' => _x($article, 'Post type singular name', 'pauple-helpie'),
                'add_new' => __('Add New ' . $article, 'pauple-helpie'),
                'add_new_item' => __('Add New ' . $article, 'pauple-helpie'),
                'edit' => __('Edit', 'pauple-helpie'),
                'edit_item' => __('Edit ' . $article, 'pauple-helpie'),
                'new_item' => __('New ' . $article, 'pauple-helpie'),
                'view_item' => __('View ' . $article, 'pauple-helpie'),
                'search_items' => __('Search ' . $articles, 'pauple-helpie'),
                'not_found' => __('No ' . $articles . ' found', 'pauple-helpie'),
                'parent' => __('Parent ' . $articles, 'pauple-helpie'),
                'filter_items_list' => __('Filter elements list', 'pauple-helpie'),
                'items_list' => __($articles . ' list', 'pauple-helpie'),
                'items_list_navigation' => __('Elements list navigation', 'pauple-helpie'),
                'menu_name' => __('Helpie KB Wiki', 'pauple-helpie'),
                'all_items' => __('All', 'pauple-helpie') . ' ' . $articles,
            );

            $cpt_slug = $this->helpie_model->get_cpt_slug();

            $args = array(
                'labels' => $labels,
                'public' => true,
                'menu_position' => 25,
                'menu_icon' => 'dashicons-book',
                'show_in_nav_menus' => true,
                'show_in_rest' => true,
                'map_meta_cap' => true,
                'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats', 'thumbnail', 'author'),
                'has_archive' => $this->helpie_model->has_archive(),
                'rewrite' => array('slug' => $cpt_slug, 'with_front' => false),
                'exclude_from_search' => true,
                // 'capability_type' => array('pauple_helpie_article', 'pauple_helpie_articles'),
            );

            register_post_type($this->post_type_name, $args);
            $this->register_category();
            $this->register_tag();
            $this->register_added_tag();
            $this->register_updated_tag();
            flush_rewrite_rules();

            // Register a helpie sidebar
            $this->register_helpie_sidebar();
        }

        /*
         * Add a form field in the new category page
         * @since 1.0.0
         */
        public function add_category_image($taxonomy)
        {
            ?>
            <div class="form-field term-group">
                <label for="category-image-id"><?php _e('Image', 'pauple-helpie');?></label>
                <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
                <div id="category-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'pauple-helpie');?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'pauple-helpie');?>" />
                </p>
            </div>
        <?php

            echo $this->add_category_fontawesome($taxonomy);
        }

        public function add_category_fontawesome($taxonomy)
        {
            // $icon_value = get_term_meta ( $term->term_id, 'helpie-category-icon', true );
            $html = "<div class='form-field term-group'>";
            $html .= "<label for='helpie-category-icon'>" . __('Icon', 'pauple-helpie') . "</label>";

            // $html .= "<input type='hidden' id='helpie-category-icon' name='helpie-category-icon' class='' value=''>";
            $html .= "<div id='category-image-wrapper'></div>";
            $html .= "<p>";
            $html .= "<div id='helpie_category_fontawesome' class='ui fluid search selection dropdown'>";
            $html .= "<input type='hidden' name='helpie-category-icon' value=''>";
            $html .= "<i class='dropdown icon'></i>";
            $html .= "<div class='default text'>" . __("Select an Icon", 'pauple-helpie') . "</div>";
            $html .= "<div class='menu'>";

            $icons_array = $this->fontawesome_icons->get_all_icons_list();

            for ($ii = 0; $ii < sizeof($icons_array); $ii++) {
                $html .= "<div class='item' data-value='" . $icons_array[$ii] . "'>";
                $html .= "<i class='fa " . $icons_array[$ii] . "' aria-hidden='true'></i>";
                $html .= $icons_array[$ii] . " </div>";
            }
            $html .= "</div></div></div>";

            return $html;
        }

        /*
         * Save the form field
         * @since 1.0.0
         */
        public function save_category_image($term_id, $tt_id)
        {
            if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
                $image = $_POST['category-image-id'];
                add_term_meta($term_id, 'category-image-id', $image, true);
            }

            if (isset($_POST['helpie-category-icon']) && '' !== $_POST['helpie-category-icon']) {
                $icon = $_POST['helpie-category-icon'];
                add_term_meta($term_id, 'helpie-category-icon', $icon, true);
            }
        }

        /*
         * Update the form field value
         * @since 1.0.0
         */
        public function update_category_image($term_id, $tt_id)
        {
            if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
                $image = $_POST['category-image-id'];
                update_term_meta($term_id, 'category-image-id', $image);
            } else {
                update_term_meta($term_id, 'category-image-id', '');
            }

            if (isset($_POST['helpie-category-icon']) && '' !== $_POST['helpie-category-icon']) {
                $icon = $_POST['helpie-category-icon'];
                update_term_meta($term_id, 'helpie-category-icon', $icon);
            }
        }

        /*
         * Edit the form field
         * @since 1.0.0
         */
        public function update_category_image_field($term, $taxonomy)
        {
            ?>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="category-image-id"><?php _e('Image', 'hero-theme');?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'category-image-id', true);?>
                    <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
                    <div id="category-image-wrapper">
                        <?php if ($image_id) {
                ?>
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <?php
}?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'hero-theme');?>" />
                        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'hero-theme');?>" />
                    </p>
                </td>
            </tr>
            <?php

            echo $this->update_category_fontawesome($term, $taxonomy);
        }

        /*
         * Add a form field in the new category page
         * @since 1.0.0
         */
        public function update_category_fontawesome($term, $taxonomy)
        {
            $icon_value = get_term_meta($term->term_id, 'helpie-category-icon', true);
            $html = "<tr class='form-field term-group-wrap'>";
            $html .= "<th scope='row'>";
            $html .= "<label for='helpie-category-icon'>" . __('Icon', 'pauple_helpie') . "</label>";
            $html .= "</th>";
            $html .= "<td>";
            // $html .= "<input type='hidden' id='helpie-category-icon' name='helpie-category-icon' class='' value=''>";
            $html .= "<div id='category-image-wrapper'></div>";
            $html .= "<p>";
            $html .= "<div id='helpie_category_fontawesome' class='ui fluid search selection dropdown'>";
            $html .= "<input type='hidden' name='helpie-category-icon' value='" . $icon_value . "'>";
            $html .= "<i class='dropdown icon'></i>";
            $html .= "<div class='default text'>Select an Icon</div>";
            $html .= "<div class='menu'>";

            $icons_array = $this->fontawesome_icons->get_all_icons_list();

            for ($ii = 0; $ii < sizeof($icons_array); $ii++) {
                $html .= "<div class='item' data-value='" . $icons_array[$ii] . "'>";
                $html .= "<i class='fa " . $icons_array[$ii] . "' aria-hidden='true'></i>";
                $html .= $icons_array[$ii] . " </div>";
            }
            $html .= "</div></div>";
            $html .= "</td>";
            $html .= "</tr>";

            return $html;
        }

        /*
         * Add script
         * @since 1.0.0
         */
        public function add_script()
        {
            $screen = get_current_screen();

            if (($screen->base == 'edit-tags' || $screen->base == 'term') && $screen->post_type == 'pauple_helpie') {
                ?>
                <script>
                    jQuery(document).ready(function($) {

                        jQuery('#helpie_category_fontawesome').dropdownX();


                        function ct_media_upload(button_class) {
                            var _custom_media = true,
                                _orig_send_attachment = wp.media.editor.send.attachment;
                            $('body').on('click', button_class, function(e) {
                                var button_id = '#' + $(this).attr('id');
                                var send_attachment_bkp = wp.media.editor.send.attachment;
                                var button = $(button_id);
                                _custom_media = true;
                                wp.media.editor.send.attachment = function(props, attachment) {
                                    if (_custom_media) {
                                        $('#category-image-id').val(attachment.id);
                                        $('#category-image-wrapper').html(
                                            '<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />'
                                        );
                                        $('#category-image-wrapper .custom_media_image').attr('src', attachment.sizes
                                            .thumbnail.url).css('display', 'block');
                                    } else {
                                        return _orig_send_attachment.apply(button_id, [props, attachment]);
                                    }
                                }
                                wp.media.editor.open(button);
                                return false;
                            });
                        }
                        ct_media_upload('.ct_tax_media_button.button');
                        $('body').on('click', '.ct_tax_media_remove', function() {
                            $('#category-image-id').val('');
                            $('#category-image-wrapper').html(
                                '<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />'
                            );
                        });
                        // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
                        $(document).ajaxComplete(function(event, xhr, settings) {
                            var queryStringArr = settings.data.split('&');
                            if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                                var xml = xhr.responseXML;
                                $response = $(xml).find('term_id').text();
                                if ($response != "") {
                                    // Clear the thumb image
                                    $('#category-image-wrapper').html('');
                                }
                            }
                        });
                    });
                </script>
<?php
}
        }

        public function register_helpie_sidebar()
        {
            register_sidebar(
                array(
                    'id' => 'helpie_sidebar',
                    'name' => __('Helpie Sidebar'),
                    'description' => __('Sidebar of Helpie Knowledge Base Wiki'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
                )
            );
        }
    } // END CLASS
}

$cpt = new Class_Cpt();
