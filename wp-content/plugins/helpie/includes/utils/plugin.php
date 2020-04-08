<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly



if (!class_exists('\Helpie\Includes\Utils\Plugin')) {
    class Plugin
    { 
        public function __construct(){
            $this->post = new \Helpie\Includes\Utils\Post();
        }

        public function activatePlugin($I)
        {
            $I->loginAsAdmin();
            $I->see('Dashboard');

            $I->amOnAdminPage('plugins.php');

            $I->see('Helpie');
            $I->activatePlugin('helpie-wordpress-helpdesk-plugin');
            $I->seePluginActivated('helpie-wordpress-helpdesk-plugin');
        }

        public function delete_plugin_data()
        {
            $this->delete_all_posts_of_cpt('pauple_helpie');
            $this->unregister_post_type('pauple_helpie');
        }

        public function delete_all_posts_of_cpt($post_type)
        {
            $mycustomposts = get_posts(array( 'post_type' => $post_type));
            foreach ($mycustomposts as $mypost) {
                wp_delete_post($mypost->ID, true);
                // Set to False if you want to send them to Trash.
            }
        }


        public function unregister_post_type($post_type)
        {
            global $wp_post_types;
            if (isset($wp_post_types[ $post_type ])) {
                unset($wp_post_types[ $post_type ]);
                return true;
            }
            return false;
        }

        
    } // END CLASS

}