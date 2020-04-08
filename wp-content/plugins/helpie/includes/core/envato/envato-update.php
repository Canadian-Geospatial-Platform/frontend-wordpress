<?php

namespace Helpie\Includes\Core\Envato;


if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Envato API class.
 *
 * @package Envato_Market
 */

if (!class_exists( '\Helpie\Includes\Core\Envato\Envato_Update' )) {

	class Envato_Update {

        // Plugin ID in Envato
        private $plugin_id = 18882940;

        public function __construct(){
			$this->model = new \Helpie\Includes\Core\Envato\Helpie_Envato_Model();
		}

        public function setup(){
            require_once(HELPIE_PLUGIN_PATH . 'includes/core/envato/envato-api.php');
            require_once(HELPIE_PLUGIN_PATH . 'includes/core/envato/update-plugin-class.php');


        }

        // Check for new plugin update
        public function check_for_update() {

            $envato_token = get_option('helpie_envato_api_token', '');

            if ($envato_token) {
                $plugin_info = $this->get_plugin_info_from_envato($envato_token);
            }

            if ( $this->is_new_update_available($plugin_info) ) {
                ob_start();

                $content = ob_get_clean();
                $response = $this->ajax_response(true, __( 'A new update is available', 'pauple-helpie'), $content);

            } else {
                $response = $this->ajax_response(false, __( 'No update available', 'pauple-helpie'), null);
            }


            return $response;

        }


        //  Save Envato API Personal Token
        public function save_envato_api_token($envato_token) {



            if ($envato_token) {
                $plugin_info = $this->save_process_when_token_is_set($envato_token);
            }

            $output = $this->post_save_process($envato_token, $plugin_info);

            ob_start();
            $content = ob_get_clean();

            $response = $this->ajax_response($output['state'], $output['message'], $content);

            return $response;

        }



        /* PROTECTED METHODS */


        protected function get_plugin_info_from_envato($envato_token){
            $plugin_info = null;

            $API = new \Helpie\Includes\Core\Envato\Envato_API();
            $API->init_globals($envato_token);
            $plugins = (array) $API->plugins();

            foreach ($plugins as $key) {
                $id = isset($key['id']) ? $key['id'] : null;
                if ($id == $this->plugin_id ) {
                    // save Plugin info
                    $plugin_info = $this->get_plugin_info($key);
                    update_option('helpie_plugin_info', $plugin_info);
                    break;
                }
            }

            return $plugin_info;
        }


        protected function is_new_update_available($plugin_info){
            $current_version = $this->model->get_current_version();
            return (!empty($plugin_info) && isset($plugin_info['version']) && version_compare($plugin_info['version'], $current_version) >  0);
        }


        protected function get_envato_error($plugins){
            // show error message if error from Envato API
            $defaut_msg = __( 'An unknown API error occurred from Envato', 'pauple-helpie');
            $error_msg  = !empty($plugins) && is_string($plugins) ? __( 'Envato API error:', 'pauple-helpie').'&nbsp;'.$plugins : $defaut_msg;
            $response   = $this->ajax_response(false, $error_msg, null);
            return $response;
        }

        protected function post_save_process($envato_token, $plugin_info){

            if (empty($envato_token)) {

                $state   = false;
                $message = __( 'Please enter your Personal Token', 'pauple-helpie');
                update_option('helpie_plugin_info', '');
                update_option('helpie_envato_api_token', '');

            } else if (!$plugin_info) {

                $state   = false;
                $message = __( 'No purchase was found', 'pauple-helpie');
                update_option('helpie_envato_api_token', '');
                update_option('helpie_plugin_info', '');

            } else {

                $state   = true;
                $message = null;

            }

            return array(
                'state' => $state,
                 'message' => $message,
            );
        }

        protected function save_process_when_token_is_set($envato_token){
            error_log('save_envato_api_token: ' .$envato_token);
            $plugin_info  = null;

            $API = new \Helpie\Includes\Core\Envato\Envato_API();
            $API->init_globals($envato_token);
            $plugins = $API->plugins();

            if (!is_array($plugins)) {
                $response = $this->get_envato_error($plugins);
                error_log('response: ' . $response );
            }

            foreach ($plugins as $key) {

                $id = $key['id'];

                if ($id == $this->plugin_id ) {
                    // save Plugin info
                    $plugin_info = $this->get_plugin_info($key);
                    update_option('helpie_plugin_info', $plugin_info);
                    // save Envato API personal token
                    update_option('helpie_envato_api_token', $envato_token);
                    break;
                }

            }

            return $plugin_info;
        }

        // Get plugin infor from Envato API
        protected function get_plugin_info($key) {

            return array(
                'id'              => $key['id'],
                'slug'            => 'helpie/helpie.php',
                'name'            => $key['name'],
                'author'          => $key['author'],
                'version'         => $key['version'],
                'description'     => $key['description'],
                'content'         => $key['content'],
                'url'             => $key['url'],
                'author_url'      => $key['author_url'],
                'license'         => $key['license'],
                'updated_at'      => $key['updated_at'],
                'purchase_code'   => $key['purchase_code'],
                'supported_until' => $key['supported_until'],
                'thumbnail_url'   => $key['thumbnail_url'],
                'landscape_url'   => $key['landscape_url'],
                'requires'        => $key['requires'],
                'tested'          => $key['tested'],
                'number_of_sales' => $key['number_of_sales'],
                'rating'          => $key['rating'],
            );

        }

        // Ajax array response for wp_send_json
        protected function ajax_response($success = true, $message = null, $content = null) {

            $response = array(
                'success' => $success,
                'message' => $message,
                'content' => $content
            );

            return $response;

        }


    } // END CLASS
}
