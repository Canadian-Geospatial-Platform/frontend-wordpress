<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Style_Getter')) {
    class Style_Getter
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb');
        }

        public function get_search_placeholder_text()
        {
            $group = $this->options;
            $placeholder_text = __('What can I help you with?', 'pauple-helpie');

            if (isset($group['helpie_search_placeholder_text']) && !empty($group['helpie_search_placeholder_text'])) {
                $placeholder_text = $group['helpie_search_placeholder_text'];
            }

            return $placeholder_text;
        }
    }
}
