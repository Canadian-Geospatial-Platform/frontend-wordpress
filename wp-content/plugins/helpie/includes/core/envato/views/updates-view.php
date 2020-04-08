<?php

namespace Helpie\Includes\Core\Envato\Views;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Envato\Views\Updates_View')) {

     class Updates_View{

        public function __construct($envato_model){
            $this->model = $envato_model;
        }

        public function get_view(){
            $html = "";

            $html .= "<div class='column'>";
            $html .= "<div class='ui segment helpie-segment'>";
            $html .= "<div class='content'>";

            $html .= "<h3 class='ui dividing header'>". __( 'Updates', 'pauple-helpie' ) ."</h3>";

            $html .= $this->get_content_html();

            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";

            return $html;

        }

        protected function get_content_html(){
            $html = '';
            $html .= "<div>";

            $html .= $this->get_version_info_html();
            if( $this->model->show_register_to_access_button() ){
                $html .= $this->get_update_or_register_html();

            }

            if( $this->model->is_token_set() ){
                $html .= $this->get_check_for_updates_html();
            }

            $html .= "<div class='ui mini label remote-status'></div>";

            // $html .= "<strong></strong>";

            $html .= "</div>";

            return $html;
        }

        protected function get_update_or_register_html(){
            $html = '';
            if ( $this->model->version_not_set() )  {
                $html .= "<button class='ui disabled button tg-button tg-button-live-update' id='helpie-check-update'>";
                $html .= __( 'Register to Access Update', 'pauple-helpie' );
                $html .= "</button>";
            } else if ( $this->model->show_update_button() ) {
                $html .= $this->model->get_update_link();
                $html .= '</span><div class="spinner"></div><strong></strong>';
            }

            return $html;
        }


        protected function get_check_for_updates_html(){
            $html = "<button class='icon ui primary button tg-button tg-button-live-update' id='helpie-check-update'>";
            $html .= "<span>".__( 'Check for updates', 'pauple-helpie' ) ."</span>";
            $html .= "<span>" . " <i class='sync icon'></i>" ."</span>";
            $html .= "</button>";

            return $html;
        }


        protected function get_version_info_html(){
            $itemsListProps = $this->model->get_version_props();

            $html = "<div class='ui very relaxed divided list'>";

            for ($ii = 0; $ii < sizeof($itemsListProps); $ii++) {
                $itemprops = $itemsListProps[$ii];

                $html .= "<div class='item'>";
                $html .= "<i class='big ".$itemprops['icon_code']." outline middle aligned icon ".$itemprops['icon_color']."'></i>";
                $html .= "<div class='content'>";
                $html .= "<a class='header'>". $itemprops['title'] ."</a>";
                $html .= "<div class='description'><p>".$itemprops['description']."</p></div>";
                $html .= "</div>";
                $html .= "</div>";
            }

            $html .= "</div>";

            return $html;

        }


    }
}
