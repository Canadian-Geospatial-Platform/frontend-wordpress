<?php

namespace Helpie\Features\Components\Toc\Model;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Components\Toc\Model\Auto_Toc_Service')) {
    class Auto_Toc_Service
    {
        public function generateProps($heads, $collectionProps)
        {
            $props = array();

            for ($ii = 0; $ii < sizeof($heads); $ii++) {

                preg_match('/(<h([1-6])[^>]*>)(\S.*)<\/h\2>/msuU', $heads[$ii], $matches);

                $props[$ii] = array(
                    'tag' => $matches[1],
                    'level' => $matches[2],
                    'text' => $matches[3],
                );

                // Should be after the array is created
                $props[$ii]['parent'] = $this->get_parent_index($props, $ii);
                $props[$ii]['serial'] = $this->get_serial_index($props, $ii);
                $props[$ii]['head_id'] = $this->get_generate_content_header_id($props, $ii, $collectionProps);
            }
            $props = $this->get_children_index($props);

            return $props;
        }

        public function get_parent_index($props, $current_index)
        {
            $parent_index = -1; // imaginary index

            $current_level = $props[$current_index]['level'];

            for ($ii = $current_index; 0 <= $ii; $ii--) {
                if ($props[$ii]['level'] < $current_level) {
                    $parent_index = $ii;
                    break;
                }
            }

            return $parent_index;
        }

        protected function get_generate_content_header_id($props, $ii, $collectionProps)
        {
            $URLText = $collectionProps['section_page_url_text'];
            $URLText = (!empty($URLText)) ? $URLText : 'helpie-sp';
            return $URLText . '-' . $props[$ii]['serial'];
        }

        protected function get_serial_index($props, $main_loop_index)
        {
            $pos = 1;
            $parent_index = $props[$main_loop_index]['parent'];

            for ($jj = ($main_loop_index - 1); 0 <= $jj; $jj--) {
                if ($props[$jj]['parent'] == $parent_index) {
                    $pos++;
                }
            }
            if (!isset($props[$parent_index]['serial'])) {
                return $pos;
            }

            return $props[$parent_index]['serial'] . '-' . $pos;
        }

        protected function get_children_index($props)
        {
            for ($ii = 0; $ii < sizeof($props); $ii++) {
                if (isset($props[$ii]['parent']) && ($props[$ii]['parent'] !== -1)) {
                    $parent_index = $props[$ii]['parent'];

                    if (!isset($props[$parent_index]['children']) || !is_array($props[$parent_index]['children'])) {
                        $props[$parent_index]['children'] = array();
                    }
                    array_push($props[$parent_index]['children'], $ii);
                }
            }

            return $props;
        }
    }
}
