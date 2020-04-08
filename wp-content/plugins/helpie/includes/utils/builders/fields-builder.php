<?php

namespace Helpie\Includes\Utils\Builders;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/settings-util.php';

if (!class_exists('\Helpie\Includes\Utils\Builders\Fields_Builder')) {
    class Fields_Builder
    {

        private $settings_util;

        public function __construct()
        {
            $this->settings_util = new \Helpie\Includes\Utils\PAUPLE_SETTINGS_UTIL();
        }

        public function render_field($option_name, $option_grp, $field_type, $default_value, $available_options = '')
        {
            $options = get_option($option_grp);
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : $default_value;
            if ($field_type == 'text') {
                $this->textfield($option_grp, $option_name, $option_value);
            } elseif ($field_type == 'select') {
                $this->print_select_field($option_name, $option_grp, $available_options);
            } elseif ($field_type == 'radioStyle2') {
                $this->radioStyles($option_grp, $option_name, $available_options, $default_value, 'style2');
            } elseif ($field_type == 'radioStyle3') {
                $this->radioStyles($option_grp, $option_name, $available_options, $default_value, 'style3');
            } elseif ($field_type == 'toggle') {
                $this->print_toggle_switch1($option_grp, $option_name, $default_value);
            }
        }

        public function is_selected_multi($available_option, $option_value)
        {
            if (isset($option_value) && is_array($option_value) && isset($available_option) && in_array($available_option, $option_value)) {
                return "selected='selected'";
            } else {
                return '';
            }
        }
        public function print_multiple_select_field($option_name, $available_options, $multi = '')
        {
            $option_value = get_option($option_name);

            $html = "<select id='" . $option_name . "' name='" . $option_name . "[]' " . (isset($multi) ? 'multiple ' : '') . "value='%s' >";
            foreach ($available_options as $available_option => $label) {
                $selected_tag = '';
                $classes = '';

                if ($this->is_selected_multi($available_option, $option_value)) {
                    $selected_tag = "selected='selected'";
                    $classes = 'selected';
                }

                $html .= "<option class='" . $classes . "' value='" . $available_option . "' " . $selected_tag . '>' . $label . '</option>';
            }
            $html .= '</select></div>';

            printf($html, isset($this->options[$option_name]) ? esc_attr($this->options[$option_name]) : 'All');
        }

        public function print_select_field($option_name, $option_grp, $available_options)
        {
            $options = get_option($option_grp);
            // print_r($options);

            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : '';

            $html = "<div class='helpie-styled-select1 slate'><select id='" . $option_name . "'  name='" . $option_grp . '[' . $option_name . "]' value='%s' >";
            foreach ($available_options as $available_option => $label) {
                $html .= "<option value='" . $available_option . "' " . (($option_value == $available_option) ? "selected='selected'" : '') . '>' . $label . '</option>';
            }
            $html .= '</select></div>';

            printf($html, isset($options[$option_name]) ? esc_attr($options[$option_name]) : '');
        }

        public function print_toggle_switch($option_name)
        {
            $options = get_option('helpie_components_options');
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : '';

            $html = "<label id='" . $option_name . "-switch' class='switch'><input " . (($option_value == 'on') ? 'checked ' : '') . "type='checkbox' id='" . $option_name . "' name='helpie_components_options[" . $option_name . "]' value='on'><div class='slider round'></div></label>";
            printf($html);
        }

        public function print_toggle_switch1($option_grp, $option_name, $default)
        {
            $options = get_option($option_grp);
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : $default;

            $html = "<label id='" . $option_name . "-switch' class='switch'><input " . (($option_value == 'on') ? 'checked ' : '') . "type='checkbox' id='" . $option_name . "' name='" . $option_grp . '[' . $option_name . "]' value='on'><div class='slider round'></div></label>";
            printf($html);
        }

        public function checkbox($option_name, $label)
        {
            $options = get_option('helpie_components_options');
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : '';
            $html = '<input ' . (($option_value == 'on') ? 'checked ' : '') . "type='checkbox' id='" . $option_name . "' name='helpie_components_options[" . $option_name . "]' value='on'>" . $label;
            printf($html);
        }

        public function checkbox1($option_grp, $option_name, $label)
        {
            $options = get_option($option_grp);
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : '';
            $html = '<input ' . (($option_value == 'on') ? 'checked ' : '') . "type='checkbox' id='" . $option_name . "' name='" . $option_grp . '[' . $option_name . "]' value='on'>" . $label;
            printf($html);
        }

        public function colorSelect($option_name, $label, $value)
        {
            $html = "<input type='text' id='" . $option_name . "' class='minicolors'  name='helpie_style_options[" . $option_name . "]' value='" . $value . "'/>";
            printf($html);
        }

        public function get_editor_dropdown($option_grp, $option_name, $available_options, $label, $option_value, $has_image = false, $tabindex = '')
        {
            $html = "<div tabindex='" . $tabindex . "' id='" . $option_name . "' class='ui fluid selection dropdown single_dropdown no-radius password_content_type'>";
            $html .= "<input id='" . $option_name . "-input' type='hidden' name='" . $option_grp . '[' . $option_name . "]' value='" . $option_value . "'>";
            $html .= "<i class='dropdown icon'></i>";
            $html .= "<div class='default text'>" . __($label, 'pauple-helpie') . '</div>';
            $html .= "<div class='menu editor-dropdown'>";

            foreach ($available_options as $key => $value) {
                $style = '';
                if ($key == -1) {
                    $style = "style = 'display: none;'";
                }

                $additional_item_classes = '';
                if (isset($value['disabled']) && $value['disabled'] == 'true') {
                    $additional_item_classes .= ' disabled';
                }
                $html .= "<div class='item " . $additional_item_classes . "' data-value='" . $key . "' data-parent='" . $value['parent'] . "' data-level='" . $value['level'] . "' " . $style . ">";
                if ($has_image == true) {
                    $html .= "<img class='ui mini avatar image' src='" . HELPIE_PLUGIN_URL . '/includes/asset-files/images/' . $option_name . '/' . $key . ".png'>";
                }

                $html .= __($value['name'], 'pauple-helpie');
                $html .= '</div>';
            }

            $html .= '</div></div>';

            return $html;
        }

        public function get_dropdown($option_grp, $option_name, $available_options, $label, $option_value, $has_image = false, $tabindex = '')
        {
            $html = "<div tabindex='" . $tabindex . "' id='" . $option_name . "' class='ui fluid selection dropdown single_dropdown no-radius password_content_type'>";
            $html .= "<input id='" . $option_name . "-input' type='hidden' name='" . $option_grp . '[' . $option_name . "]' value='" . $option_value . "'>";
            $html .= "<i class='dropdown icon'></i>";
            $html .= "<div class='default text'>" . __($label, 'pauple-helpie') . '</div>';
            $html .= "<div class='menu'>";

            foreach ($available_options as $key => $value) {
                $html .= "<div class='item' data-value='" . $key . "'>";
                if ($has_image == true) {
                    $html .= "<img class='ui mini avatar image' src='" . HELPIE_PLUGIN_URL . '/includes/asset-files/images/' . $option_name . '/' . $key . ".png'>";
                }

                $html .= __($value, 'pauple-helpie');
                $html .= '</div>';
            }

            $html .= '</div></div>';

            return $html;
        }

        public function dropdown($option_grp, $option_name, $available_options, $label, $option_value, $has_image = false)
        {
            echo $this->get_dropdown($option_grp, $option_name, $available_options, $label, $option_value, $has_image = false);
        }

        public function dropdown_frontend($meta_key, $available_options, $label, $option_value, $tabindex = '')
        {
            return $this->get_editor_dropdown('', $meta_key, $available_options, $label, $option_value, $has_image = false, $tabindex);
        }

        public function multi_dropdown_frontend($meta_key, $available_options, $label, $option_value)
        {
            return $this->get_multi_dropdown_base('', $meta_key, $label, $available_options, $option_value);
        }

        public function textfield($option_grp, $option_name, $option_value, $option_placeholder = '')
        {
            $html = "<input id='" . $option_name . "' type='text' name='" . $option_grp . '[' . $option_name . "]' value='" . $option_value . "' placeholder ='" . $option_placeholder . "' />";
            printf($html);
        }

        public function numberfield($option_grp, $option_name, $option_value)
        {
            $html = "<input type='number' min='0' name='" . $option_grp . '[' . $option_name . "]' value='" . $option_value . "' />";
            printf($html);
        }

        public function radioImage($option_grp, $option_name, $available_options, $option_value)
        {
            $html = "<span id='" . $option_name . "'>";
            foreach ($available_options as $key => $value) {
                $html .= "<label class='radio-image " . $key . "'><input " . (($option_value == $key) ? 'checked ' : '') . " type='radio' name='" . $option_grp . '[' . $option_name . "]' value='" . $key . "'/>";
                $html .= "<img class='image' src='" . HELPIE_PLUGIN_URL . '/includes/asset-files/images/' . $option_name . '/' . $key . ".png'>";
                $html .= '</label>';
            }

            $html .= "</span>";

            printf($html);
        }

        public function get_option_value($option_name, $option_grp, $default)
        {
            $options = get_option($option_grp);
            $option_value = isset($options[$option_name]) ? esc_attr($options[$option_name]) : $default;

            return $option_value;
        }

        public function radioStyles($option_grp, $option_name, $available_options, $default, $style = 'style2')
        {
            $option_value = $this->get_option_value($option_name, $option_grp, $default);
            $html = '';
            foreach ($available_options as $key => $value) {
                $html .= "<label class='helpie-radio-" . $style . "'><input " . (($option_value == $key) ? 'checked ' : '') . " type='radio' name='" . $option_grp . '[' . $option_name . "]' value='" . $key . "'/>";
                $html .= "<div class='radio-button'>" . $value . '</div>';
                $html .= '</label>';
            }

            printf($html);
        }

        public function get_multi_dropdown($option_grp, $option_name, $type_name, $available_options)
        {
            $option_value = $this->get_option_value($option_name, $option_grp, '');

            $html = $this->get_multi_dropdown_base($option_grp, $option_name, $type_name, $available_options, $option_value);

            return $html;
        }

        public function get_multi_dropdown_base($option_grp, $option_name, $type_name, $available_options, $option_value)
        {
            $html = "<input id='" . $option_name . "-hidden' type='hidden' value='" . $option_value . "' name=" . $option_grp . '[' . $option_name . ']>';

            $html .= "<select id='" . $option_name . "'  multiple='' class='ui fluid dropdown multi_dropdown'>";
            $html .= "<option value=''>" . '</option>';
            foreach ($available_options as $key => $value) {
                $html .= "<option value='" . $key . "'>" . __($value, 'pauple-helpie') . '</option>';
            }

            $html .= '</select>';

            return $html;
        }

        public function get_multi_dropdown_test($option_grp, $option_name, $type_name, $available_options)
        {
            $options = get_option($option_name);

            $html = "<div class='ui multiple fluid dropdown'><input type='hidden' id='" . $option_name . "' name=" . $option_grp . '[' . $option_name . ']>';
            $html .= "<i class='dropdown icon'></i><div class='default text'>Default text</div>";
            $html .= "<div class='menu'>";
            foreach ($available_options as $key => $value) {
                $html .= "<div class='item' data-value='" . $key . "'>" . $value . '</div>';
            }

            $html .= '</div></div>';

            return $html;
        }

        public function get_password_field($option_grp, $option_name)
        {
            $options = get_option($option_grp);
            if (isset($options[$option_name]) && !empty($options[$option_name])) {
                $option_value = $options[$option_name];
            } else {
                $option_value = '';
            }
            $html = "<input id='" . $option_name . "' type='password' name='" . $option_grp . '[' . $option_name . "]' class='password' value='" . $option_value . "'>";

            return $html;
        }

        // Drag and Drop methods

        public function excluded_articles_html($option_value_array, $available_options)
        {
            $html = '';

            for ($ii = 0; $ii < sizeof($option_value_array); ++$ii) {
                foreach ($available_options as $key => $value) {
                    if ($key == $option_value_array[$ii]) {
                        $html .= "<div id='dnd-cat-id-" . $key . "' data-cat-id='" . $key . "'>" . $value . '</div>';
                    }
                }
            }

            return $html;
        }

        public function included_articles_html($option_value_array, $available_options)
        {

            $dnd = new \Helpie\Includes\Core\Lib\Dnd\Getter();
            $mainpage_category = $dnd->get_all_included_categories();

            $html = '';
            for ($ii = 0; $ii < sizeof($mainpage_category); $ii++) {
                $term_id = $mainpage_category[$ii];
                $term = get_term($term_id, 'helpdesk_category');
                $html .= "<div id='dnd-cat-id-" . $term_id . "' data-cat-id='" . $term_id . "'>" . $term->name . '</div>';
            }

            return $html;
        }

        public function dragndrop($option_grp, $option_name, $available_options, $option_value)
        {
            $option_value_array = array_filter(explode(',', $option_value));
            if ($option_name == 'helpie_mp_articles_in_cats') {
                $left = 'left-articles';
                $right = 'right-articles';
            } else {
                $left = 'left-events';
                $right = 'right-events';
            }

            $html = "<div id='" . $option_name . "' class='parent'><div class='wrapper'>";

            $html .= "<div id='" . $left . "' class='container'>";
            $html .= $this->included_articles_html($option_value_array, $available_options);
            $html .= '</div>';

            $html .= "<div id='" . $right . "' class='container'>";
            $html .= $this->excluded_articles_html($option_value_array, $available_options);
            $html .= '</div>';

            $html .= "<input type='hidden' class='score-keeper' name='" . $option_grp . '[' . $option_name . "]' value='" . $option_value . "'>";
            $html .= '</div></div>';

            printf($html);
        }

        /* No function in WordPress to 'get' editor */
        public function get_wp_editor_inlite($editor_id = 'singleticketeditor', $show_submit = true, $tabindex = '')
        {
            $content = '';
            $settings = array(
                'tabindex' => $tabindex,
                'media_buttons' => true,
                'quicktags' => false,
                'tinymce' => array(
                    'toolbar1' => 'bold, italic, link, media_buttons',
                    'height' => 200,
                    'theme' => 'inlite',
                ),
            );

            $html = "<div class='helpie-wp-editor-container'>";

            ob_start();
            wp_editor($content, $editor_id, $settings);
            $html .= ob_get_contents();
            ob_end_clean();

            $html .= '</div>';
        }

        public function get_wp_editor($editor_id = 'singleticketeditor', $show_submit = true, $tabindex = '')
        {
            $content = '';
            $settings = array(
                'tabindex' => $tabindex,
                'media_buttons' => true,
                'quicktags' => false,
                'tinymce' => array(
                    'toolbar1' => 'bold, italic, link, media_buttons',
                    'height' => 200,
                ),
            );

            $html = "<div class='helpie-wp-editor-container'>";

            ob_start();
            wp_editor($content, $editor_id, $settings);
            $html .= ob_get_contents();
            ob_end_clean();

            if ($show_submit) {
                $html .= "<button type='submit' form='form1' value='Submit'>Submit</button>";
            }

            $html .= '</div>';

            return $html;
        }
    } // END class
}