<?php

namespace Helpie\Features\Components\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly



if (!class_exists('\Helpie\Features\Components\Partials\Pageviews')) {
    class Pageviews
    {

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->sp_viewmodel = new \Helpie\Templates\Views\Single_View\Single_Viewmodel();
        }

        public function get_view()
        {
            $show_pageviews = $this->settings->single_page->show_pageviews();

            if (!$show_pageviews) {
                return '';
            }

            $ph_pageviews = get_post_meta(get_the_iD(), 'ph_pageviews', true);

            if (!isset($ph_pageviews) || $ph_pageviews == null) {
                $ph_pageviews = 0;
            }

            $html_content = '';
            $html_content .= "<span class='pauple-helpie-pageviews'>";
            $html_content .= "<span class='value'>" . $ph_pageviews . "</span>";

            $html_content .= " read";
            if (1 < $ph_pageviews) {
                $html_content .= "s";
            }

            $html_content .= "</span>";

            // Update Pageviews
            $this->sp_viewmodel->update_pageviews();

            return $html_content;
        }
    } // END CLASS

}