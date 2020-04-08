<?php
// error_log('functions.php');
global $helpie_kb_all_topics;
global $helpie_kb_get_term_query_index;
$helpie_kb_get_term_query_index = 0;

function set_all_helpie_kb_topics()
{
    global $helpie_kb_all_topics;
    $helpie_kb_all_topics = get_terms('helpdesk_category');
}

function get_all_helpie_kb_topics()
{
    global $helpie_kb_all_topics;

    // error_log('$helpie_kb_all_topics : ' . print_r($helpie_kb_all_topics, true));
    return $helpie_kb_all_topics;
}

/* Filter Executers */

function helpie_kb_the_content($content)
{
    $post_type = 'pauple_helpie';

    global $post;
    if (isset($post->post_type) && $post->post_type == $post_type) {
        $content = apply_filters('helpie_kb_the_content', $content);
    }

    return $content;
}

function helpie_kb_filter_posts($query)
{

    $post_type = 'pauple_helpie';
    // $is_allowed_query = ($query->is_main_query() || $query->is_search());
    $is_single = $query->is_single();
    $is_helpie_cpt = in_array($query->get('post_type'), array($post_type));
    if ($is_helpie_cpt && !$is_single) {
        // error_log('filter_helpie_posts');
        do_action('helpie_kb_filter_posts', $query);
    }
}

function bool2str($bool)
{
    if ($bool === false) {
        return 'FALSE';
    } else {
        return 'TRUE';
    }
}

function helpie_kb_pre_get_terms($query_loc)
{
    global $helpie_kb_get_term_query_index;

    remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
    $is_helpie_tax_page = is_tax('helpdesk_category');
    add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter
    $helpie_kb_get_term_query_index++;

    if (!is_object($query_loc) || !property_exists($query_loc, 'query_vars') || ($is_helpie_tax_page && $helpie_kb_get_term_query_index == 1)) {
        return;
    }

    $is_helpie_tax = (isset($query_loc->query_vars['taxonomy']) && in_array('helpdesk_category', $query_loc->query_vars['taxonomy']));

    if ($is_helpie_tax) {
        do_action('helpie_kb_pre_get_terms', $query_loc);
    }
}

// function helpie_kb_pre_get_terms($args, $taxonomies)
// {
//     $category = 'helpdesk_category';

//     if (!in_array($category, $taxonomies)) {
//         return $args;
//     }

//     $args = apply_filters('helpie_kb_pre_get_terms', $args, $taxonomies);
//     return $args;
// }

/* Getters*/

function get_helpie_kb_articles($args = array())
{

    // error_log('get_helpie_kb_articles');
    // error_log('$args : ' . print_r($args, true));
    $articles_model = new \Helpie\Features\Domain\Query\Articles_Model();
    $articles = $articles_model->get_articles($args);

    return $articles;
}

if (!function_exists('csf_get_all_helpie_kb_topics')) {
    function csf_get_all_helpie_kb_topics()
    {
        $options = ['all' => 'All'];
        $topics = get_all_helpie_kb_topics();

        if (!empty($topics)) {
            foreach ($topics as $key => $value) {
                $options[$value->term_id] = $value->name;
            }
        }
        return $options;
    }
}

if (!function_exists('csf_get_all_helpie_kb_mp_topics')) {
    function csf_get_all_helpie_kb_mp_topics()
    {
        $options = ['all' => __('All', 'pauple-helpie')];
        $topics = get_all_helpie_kb_topics();

        if (!empty($topics)) {
            foreach ($topics as $key => $value) {
                if ($value->parent == 0) {
                    $options[$value->term_id] = $value->name;
                }
            }
        }
        return $options;
    }
}

/* Core Helpie Functions */
function get_helpie_kb_capabilities($location = 'single', $wp_obj = null)
{
    $access_controller = new \Helpie\Features\Services\Access_Control\Controller();
    $dynamic_caps = $access_controller->get_dynamic_capabilities($location, $wp_obj);

    // error_log('$dynamic_caps : ' . print_r($dynamic_caps, true));
    return $dynamic_caps;
}

function get_helpie_header()
{
    $headerName = apply_filters('helpie_kb_header', '');
    return get_header($headerName);
}

/* Protected */
