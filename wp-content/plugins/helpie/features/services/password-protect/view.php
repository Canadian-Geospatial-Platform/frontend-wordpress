<?php

namespace Helpie\Features\Services\Password_Protect;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Password_Protect\View')) {
    class View
    {
        public function get_access_restricted_message()
        {
            $args = $this->get_args();

            $html_content = "<p>Access Restricted</p>";

            $button_props = "id='helpie-enter-password'";
            $button_props .= "class='helpie-enter-password'";
            $button_props .= "data-origin='" . $args['origin'] . "'";
            $button_props .= "name='helpie-enter-password'";
            $button_props .= "data-post-id='" . get_the_ID() . "'";
            $button_props .= "data-term-id='" . $args['term_id'] . "'";

            $html_content .= "<button " . $button_props . ">Enter Password</button>";
            return $html_content;
        }

        protected function get_args()
        {
            $args = [];

            if (is_tax(HELPIE_TAXONOMY)) {
                $args['origin'] = 'category';
                $args['term_id'] = get_queried_object_id();
            } else {
                $args['origin'] = 'article';
                $terms = get_the_terms(get_the_ID(), HELPIE_TAXONOMY);
                $args['term_id'] = (isset($terms) && !empty($terms)) ? $terms[0]->term_id : null;
            }

            return $args;
        }

        public function get_view()
        {
            global $helpie_password_modal;
            $html = '';

            if ($helpie_password_modal == 0) {
                $html = "<div class='ui dimmer modals page' style='display: none;'>";
                $html .= "<div id='helpie-password-modal' class='pauple_helpie ui modal small' style='display: none;'>";
                $html .= "<div class='ui header'><i class='circular lock icon'></i> Password Protected</div>";
                $html .= "<div class='item-content'>";
                $html .= "<br /><label for='password_check'>Enter Password : </label>";
                $html .= "<p><input type='password' id='password_check' name='password_check' class='password' value='' required></p>";
                $html .= "</div>";
                $html .= "<div class='actions'>";
                $html .= "<div class='ui black deny button'>Nope</div>";
                $html .= "<div class='ui positive right labeled icon button'>Yep, that's right!<i class='checkmark icon'></i></div>";
                $html .= "</div>";
                $html .= "<div class='clear'></div>";
                $html .= "</div>";
                $html .= "</div>";

                $helpie_password_modal = 1;
            }

            return $html;
        }
    } // END CLASS

}
