<?php

namespace Helpie\Includes\Core\Envato;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Envato\Helpie_Envato_View')) {

     class Helpie_Envato_View{


         public function __construct(){
 			$this->model = new \Helpie\Includes\Core\Envato\Helpie_Envato_Model();
            $this->activation_view = new \Helpie\Includes\Core\Envato\Views\Activation_View($this->model);
            $this->updates_view  = new \Helpie\Includes\Core\Envato\Views\Updates_View($this->model);
 		}

        public function get_view(){
			$html = "<div class='ui two column grid'>";
  			$html .= "<div class='column'>";

			if ( $this->model->show_register_panel() ) {
				$html .= $this->activation_view->get_view();
			}

			$html .= $this->updates_view->get_view();

            $html .= '</div>';
			return $html;
		}



		protected function get_registeration_msg_html(){
			$registration_msg = (!empty($this->unregister_panel) && is_bool($this->unregister_panel) !== true) ? $this->unregister_panel : __( 'If you have a valid purchase of Helpie, you can register it to get automatic updates.', 'pauple-helpie' );
			$registration_msg_html = (!empty($registration_msg)) ? '<span style="width:65%;display:inline-block">'.$registration_msg.'</span>' : null;

			return $registration_msg_html;
		}



    } // END CLASS

}
