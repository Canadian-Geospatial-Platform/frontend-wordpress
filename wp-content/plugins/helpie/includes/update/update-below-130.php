<?php

namespace Helpie\Includes\Update;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Class to handle updates from version less than 1.1.0

if (!class_exists('\Helpie\Includes\Update\Update_Below_130')) {
    class Update_Below_130
    {
        public function update_values_11()
        {
            $kb_user = new \Helpie\Features\Domain\Models\Kb_User();
            // We use 'default_review_roles' to set default 'kb_edit_capability'
            $kb_edit_capability = $kb_user->get_default_review_roles();

            update_option('kb_edit_capability', $kb_edit_capability);
        }

        public function update_values_123()
        {
            $helpie_mp_options = get_option('helpie_mp_options');

            if (isset($helpie_mp_options) && !empty($helpie_mp_options)) {
                if (isset($helpie_mp_options['helpie_mp_cats'])) {
                    $helpie_mp_cats = $helpie_mp_options['helpie_mp_cats'];
                    $mp_cat_array = array_filter(explode(',', $helpie_mp_cats));

                    $terms = get_terms('helpdesk_category', array(
                        'parent' => 0,
                    ));

                    $top_level_terms = array();
                    $mp_excluded_cat_array = array();

                    // Get top_level_terms as term_id => $term_name format
                    foreach ($terms as $term) {
                        $top_level_terms[$term->term_id] = $term->name;
                    }

                    // Get 'helpie_excluded_mp_cats' as categories
                    // in top_level_terms but not in 'included' which is
                    // 'helpie_mp_cats'
                    foreach ($top_level_terms as $key => $value) {
                        if (!in_array($key, $mp_cat_array)) {
                            $mp_excluded_cat_array[$key] = $key;
                        }
                    }
                    $mp_excluded_cats = implode(",", $mp_excluded_cat_array);
                    $helpie_mp_options['helpie_excluded_mp_cats'] =  $mp_excluded_cats;
                    update_option('helpie_mp_options', $helpie_mp_options);
                }
            }
        }
    }
}
