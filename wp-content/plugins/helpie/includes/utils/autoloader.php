<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\PAUPLE_HELPIE_MAIN_CLS')) {
    class AutoLoader
    {
        public function load($helpie_mode = 'live_mode')
        {
            // echo "helpie_mode: " . $helpie_mode;
            if ($helpie_mode == 'test_mode') {
                spl_autoload_register(array($this, 'test_autoload'));
            } else {
                spl_autoload_register(array($this, 'live_autoload'));
            }
        }

        protected function live_autoload($classname)
        {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('_', '-', strtolower($classname)));

            // Explode class based on helpie string
            $explode = explode('helpie', $class, 2);

            // Replace helpie string to HELPIE_FOLDER_NAME;
            $explode[0] = HELPIE_FOLDER_NAME;            
            
            // Convert array into string
            $class = implode(DIRECTORY_SEPARATOR, $explode);        
            
            $file_path = dirname(HELPIE_PLUGIN_PATH) . DIRECTORY_SEPARATOR . $class . '.php';            
            
            // Change file_path when running on Bitbucket Pipeline
            if (strpos($file_path, '/opt/atlassian/pipelines/agent') !== false) {
                $file_path = str_replace("agent/helpie", "agent/build", $file_path);
            }

            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }

        // protected function test_autoload($classname){
        //     $class     = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower($classname) ) );
        //     $class = str_replace('helpie/', 'dist/', $class);
        //     $file_path = dirname(HELPIE_PLUGIN_PATH) . DIRECTORY_SEPARATOR . $class . '.php';

        //     if ( file_exists( $file_path ) ) {
        //         require_once $file_path;
        //     }
        // }
    } // END CLASS
}
