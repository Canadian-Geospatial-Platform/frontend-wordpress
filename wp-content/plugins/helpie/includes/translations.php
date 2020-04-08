<?php

namespace Helpie\Includes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Translations')) {
    class Translations
    {

        public static function getStrings($stringName)
        {

            $strings = [
                'HelpieSettings' => __('Helpie Settings', 'pauple-helpie'),
                'SingleArticlePage' => __('Single Article Page', 'pauple-helpie'),
                'SearchSettings' => __('Search Settings', 'pauple-helpie'),
                'FrontendEditor' => __('Frontend Editor', 'pauple-helpie'),
                'Design' => __('Design', 'pauple-helpie'),
                'PasswordSettings' => __('Password Settings', 'pauple-helpie'),
                'DynamicCapabilities' => __('Dynamic Capabilities', 'pauple-helpie'),
                'TableofContents' => __('Table of Contents', 'pauple-helpie'),
                'Autolinking' => __('Autolinking', 'pauple-helpie'),
                'BackupRestore' => __('Backup / Restore', 'pauple-helpie'),
            ];

            return $strings[$stringName];
        }
    } // END CLASS
}