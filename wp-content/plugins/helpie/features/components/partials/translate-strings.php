<?php

namespace Helpie\Features\Components\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('Helpie\Features\Components\Partials\Translate_Strings')) {
    class Translate_Strings
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_strings()
        {
            // Single Cpt Name default to "Article"
            $article = $this->settings->single_page->get_single_cpt_name();

            /**
             * Helpie Local String is passed to make javascript strings translatable.
             */

            $search_settings = $this->settings->search->get_settings();
            $local_strings = array(
                'in' => __('in', 'pauple-helpie'),
                'noMatches' => __($search_settings['empty_search_result_label'], 'pauple-helpie'),
                'dirURL' => ABSPATH,
                'pluginURL' => HELPIE_PLUGIN_URL,
                'onPublish' => __($article . ' Published', 'pauple-helpie'),
                'onSubmitted' => __($article . ' Submitted', 'pauple-helpie'),
                'onRevisionRemoved' => __('Viewed Revision Removed', 'pauple-helpie'),
                'onTrashed' => __($article . ' Trashed', 'pauple-helpie'),
                'onDeleted' => __($article . ' Deleted', 'pauple-helpie'),
                'onVisit' => __('View ' . $article, 'pauple-helpie'),
                'setFeaturedImage' => __("Set Featured Image", "pauple-helpie"),
                'chooseFeaturedImage' => __("Choose Featured Image", "pauple-helpie"),
            );

            return $local_strings;
        }
    }
}