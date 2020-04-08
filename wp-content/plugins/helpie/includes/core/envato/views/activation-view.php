<?php

namespace Helpie\Includes\Core\Envato\Views;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Envato\Views\Activation_View')) {

    class Activation_View
    {

        public function __construct($envato_model)
        {
            $this->model = $envato_model;
        }

        public function get_view()
        {

            $html = '';

            $html .= "<div class='ui segment helpie-segment plugin-activation'>";
            $html .= "<div class='content'>";
            $html .= "<h3 class='ui dividing header'>" . __('Plugin Activation', 'pauple-helpie') . "</h3>";

            if ($this->model->get_purchase_code()) {
                $html .= $this->purchase_code_register_panel();
            } else {

                $html .= $this->no_purchase_code_register_panel();
            }

            $html .= "</div>";
            $html .= "</div>";

            return $html;

        }

        protected function purchase_code_register_panel()
        {
            $html = "";

            $html .= "<div class='ui very relaxed divided list'>";

            $html .= "<div class='item'>";
            $html .= "<i class='large archive middle aligned icon'></i>";
            $html .= "<div class='content'>";
            $html .= "<a class='header'>" . __('Purchase Code', 'pauple-helpie') . "</a>";
            $html .= "<div class='description'><p><div class='ui message'>" . $this->model->get_purchase_code() . "</div></p></div>";
            $html .= "</div>";
            $html .= "</div>";

            $html .= $this->get_support_item_html();

            $html .= "</div>";

            return $html;

        }

        protected function no_purchase_code_register_panel()
        {

            $personal_token_doc = 'http://helpiewp.com/docs/home/updating-the-plugin/';
            $html = "<div class='description'>";
            $html .= '<input name="helpie_envato_api_token" type="text" class="tomb-text" style="width:320px" value="' . $this->model->get_envato_api_token() . '" placeholder="' . __('Enter your Envato API Personal Token', 'pauple-helpie') . '">';

            $html .= '<h3>' . __('Enter your Personal Token to get automatic Updates', 'pauple-helpie') . '</h3>';
            $html .= '<p>' . __('OAuth is a protocol that lets external apps request authorization to private details in a user\'s Envato Market account without entering their password.', 'pauple-helpie') . '</p>';
            $html .= '<p><a target="_blank" href="' . $personal_token_doc . '"><button class="ui basic button">' . __('Create your Personal Token', 'pauple-helpie') . '</button></a></p>';
            $html .= '<p><button id="helpie-save-envato-api-token" class="ui primary button tg-button tg-button-register-token">' . __('Save Changes', 'pauple-helpie') . '</button><div class="spinner"></div><strong></strong></p>';
            $html .= "</div>";

            return $html;
        }

        protected function get_support_item_html()
        {
            if ($this->model->get_supported_until() > 0) {
                $html = "<div class='item'>";
                $html .= "<i class='large life ring middle aligned icon'></i>";
                $html .= "<div class='content'>";
                $html .= "<a class='header'>" . __('Premium Ticket Support', 'pauple-helpie') . ' (' . $this->model->get_supported_until() . ' ' . __('days left', 'pauple-helpie') . ")</a>";

                $html .= "<div class='description'>";
                $html .= "<p>" . __('Direct help from our qualified support team', 'pauple-helpie') . "</p>";
                $html .= "<p>";
                $html .= "<a class='tg-button' target='_blank' href='http://helpie.pauple.com/docs'>";
                $html .= "<button class='ui primary button'>" . __('Get Support', 'pauple-helpie') . "</button>";
                $html .= "</a>";
                $html .= "</p>";
                $html .= "</div>";

                $html .= "</div>";
                $html .= "</div>";
            } else {
                $html = "<div class='item'>";
                $html .= "<i class='large life ring middle aligned icon'></i>";
                $html .= "<div class='content'>";
                $html .= "<a class='header'>" . __('Premium Ticket Support (Expired)', 'pauple-helpie') . "</a>";

                $html .= "<div class='description'>";
                $html .= "<p>" . __('Direct help from our qualified support team', 'pauple-helpie') . "</p>";
                $html .= "<p>";
                $html .= "<a class='tg-button' target='_blank' href='https://codecanyon.net/item/helpie-helpdesk-documentation-wordpress-plugin/18882940'>";
                $html .= "<button class='ui primary button'>";
                $html .= __('Extend support', 'pauple-helpie');
                $html .= '</button>';
                $html .= "</a>";
                $html .= "</a></p>";
                $html .= "</div>";

                $html .= "</div>";
                $html .= "</div>";
            }

            return $html;
        }

    } // END CLASS
}
