<?php

namespace Helpie\Features\Components\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

if (!class_exists('\Helpie\Features\Components\Partials\Updated_By')) {
    class Updated_By
    {

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }


        public function get_view()
        {
            $html_content = '';
            $show_user_name = $this->settings->single_page->show_user_name();
            $show_last_updatedon = $this->settings->single_page->show_last_updatedon();

            $updatedon_text = ($show_user_name == false) ? __("Last updated on", 'pauple-helpie') : __("on", 'pauple-helpie');

            if ($show_user_name || $show_last_updatedon) {
                $html_content .= "<div class='helpie-row'>";

                $last_update_author_id = get_post_meta(get_the_ID(), '_edit_last', true);
                $avatar = get_avatar($last_update_author_id);
                $author = get_the_modified_author();
                $author = (!empty($author)) ? $author : __("Anonymous", "pauple-helpie");

                $html_content .= "<span class='helpiekb-last-updated'>";
                if ($show_user_name) {
                    $html_content .= __("Last updated by", 'pauple-helpie');
                    $html_content .= $avatar;
                    $html_content .= $author;
                }

                if ($show_last_updatedon) {
                    $html_content .= " " . $updatedon_text . " " . get_the_modified_date();
                }
                $html_content .= "</span>";
                $html_content .= "</div>";
            }

            return $html_content;
        }
    } // END CLASS
}