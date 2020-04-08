<?php

namespace Helpie\Includes\Admin;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Admin\Admin_Ajax')) {

    class Admin_Ajax
    {
        public function delete_demo_entries()
        {
            $args = [];

            if (isset($_POST['entries']) && !empty($_POST['entries'])) {
                $args = $_POST['entries'];
            }

            $imports = new \Helpie\Features\Components\Imports\Controller();
            $response = $imports->delete_demo_entries($args);

            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die();
            wp_reset_postdata();
        }

        public function helpie_admin_ajax()
        {

            // NOTE: Fix and Enable this
            // check the nonce
            $this->check_nonce();

            $envato_update = new \Helpie\Includes\Core\Envato\Envato_Update();
            $this->ajax_data = (isset($_POST)) ? $_POST : $_GET;

            // retrieve function
            $func = $this->ajax_data['func'];

            if (isset($this->ajax_data['token']) && !empty($this->ajax_data['token'])) {
                $envato_token = $this->ajax_data['token'];
            }

            switch ($func) {
                case 'save_envato_api_token':
                    $response = $envato_update->save_envato_api_token($envato_token);
                    break;
                case 'check_for_update':
                    $response = $envato_update->check_for_update();
                    break;
                default:
                    $response = ajax_response(false, __('Sorry, an unknown error occurred...', 'pauple-helpie'), null);
                    break;
            }

            // send json response and die
            wp_send_json($response);
        }

        /* PROTECTED METHODS */

        // Check nonce in backend

        protected function check_nonce()
        {

            // retrieve nonce
            $nonce = (isset($_POST['nonce'])) ? $_POST['nonce'] : $_GET['nonce'];

            // nonce action for helpie_admin_ajax
            $action = 'helpie_update_nonce';

            // check ajax nounce
            if (!wp_verify_nonce($nonce, $action)) {

                // build response
                $response = $this->ajax_response(false, __('Sorry, an error occurred. Please refresh the page.', 'pauple-helpie'));
                // die and send json error response
                wp_send_json($response);
            }
        }

        public function ajax_response($success = true, $message = null, $content = null)
        {
            $response = array(
                'success' => $success,
                'message' => $message,
                'content' => $content,
            );

            return $response;
        }
    } // END CLASS
}

$admin_ajax = new \Helpie\Includes\Admin\Admin_Ajax();
/* Initiate Envato Update API */
if (HELPIE_KB_VENDOR == 'envato') {
    add_action('wp_ajax_helpie_admin_ajax', array($admin_ajax, 'helpie_admin_ajax'));
}

add_action('wp_ajax_helpie_delete_demo_entries', array($admin_ajax, 'delete_demo_entries'));
