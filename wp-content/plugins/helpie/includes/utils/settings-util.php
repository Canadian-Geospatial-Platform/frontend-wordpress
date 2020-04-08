<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

if (!class_exists('\Helpie\Includes\Utils\PAUPLE_SETTINGS_UTIL')) {
    class PAUPLE_SETTINGS_UTIL
    {
        private $helper;

        public function __construct()
        {
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();

            add_action('wp_ajax_get_helpie_password_data', array($this, 'get_helpie_password_data'));
        }

        public function get_helpie_password_data()
        {
            $articles = $this->get_all_articles();
            $categories = $this->get_all_categories();

            $data = array(
                'articles' => $articles,
                'categories' => $categories,
            );

            print_r(json_encode($data, JSON_NUMERIC_CHECK));
            wp_die();
        }

        public function get_all_sidebars()
        {
            $available_options = array();
            $available_options['helpie_sidebar'] = 'Helpie Sidebar';
            foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
                $available_options[$sidebar['id']] = $sidebar['name'];
            }

            return $available_options;
        }

        public function get_all_categories()
        {
            $terms = get_terms('helpdesk_category', array(
                'parent' => 0,
            ));
            $available_options = array();
            $available_options['all'] = __('All', 'pauple-helpie');
            foreach ($terms as $term) {
                $available_options[$term->term_id] = $term->name;
            }

            return $available_options;
        }

        public function get_all_articles()
        {
            $available_options = array();
            $available_options['all'] = 'All';

            $myposts = get_helpie_kb_articles();
            foreach ($myposts as $post): setup_postdata($post);

                $available_options[$post->ID] = get_the_title($post->ID);

            endforeach;
            wp_reset_postdata();
            return $available_options;
        }

        public function do_single_option($option, $page_name, $that)
        {
            $option_grp_name = '';
            $option_name = '';
            $section_name = '';

            foreach ($option as $key => $value) {
                if (preg_match('/^option_group/', $key)) {
                    $option_grp_name = $value;
                } elseif (preg_match('/^option_name/', $key)) {
                    $option_name = $value;

                    if (!isset($option_grp_name) || empty($option_grp_name)) {
                        die("option_grp not defined. Check your 'all_registered_options' and may have to move option_grp to be the first property");
                    }
                    register_setting(
                        $option_grp_name, // Option group
                        $option_name, // Option name
                        array($that, 'sanitize') // Sanitize
                    );
                } elseif (preg_match('/^section/', $key)) {
                    $section_name = $value['id'];
                    if (!isset($value['label']) || empty($value['label'])) {
                        $value['label'] = '';
                    }
                    add_settings_section(
                        $section_name, // ID
                        __($value['label'], 'pauple-helpie'), // Title
                        array($that, $section_name . '_callback'), // Callback
                        $page_name // Page
                    );
                } elseif (preg_match('/^fields/', $key)) {
                    $fields = $value;

                    for ($ii = 0; $ii < sizeof($fields); ++$ii) {
                        if (!isset($fields[$ii]) || empty($fields[$ii])) {
                            continue;
                        }
                        if (!isset($fields[$ii]['args'])) {
                            $fields[$ii]['args'] = array();
                        }

                        $callback = $fields[$ii]['id'] . '_callback';

                        if (isset($fields[$ii]['callback'])) {
                            $callback = $fields[$ii]['callback'];
                        }

                        add_settings_field(
                            $fields[$ii]['id'], // ID
                            __($fields[$ii]['label'], 'pauple-helpie'), // Title
                            array($that, $callback), // Callback
                            $page_name, // Page
                            $section_name, // Section
                            $fields[$ii]['args']// args
                        );
                    }
                }
            }
        }

        public function is_registered_input($input_key, $all_registered_options)
        {
            $is_registered = false;
            foreach ($all_registered_options as $key => $value) {
                if (preg_match('/^fields/', $key)) {
                    $single_option_fields = $all_registered_options[$key];
                    for ($ii = 0; $ii < sizeof($single_option_fields); ++$ii) {
                        if ($input_key == $single_option_fields[$ii]['id']) {
                            $is_registered = true;
                        }
                    }
                }
            }

            return $is_registered;
        }

        public function sanitize_option_fields($input, $type, $all_registered_options)
        {
            $new_input = array();

            /* option with multiple fields */
            if (isset($input) && !empty($input) && $this->helper->is_assoc($input)) {
                foreach ($input as $key => $value) {
                    if (isset($input[$key]) && $this->is_registered_input($key, $all_registered_options)) {
                        $new_input[$key] = $this->sanitize($input[$key], $type);
                    }
                }
            } else {
                if (isset($input)) {
                    $new_input = $this->sanitize($input, $type);
                }
            }

            return $new_input;
        }

        public function sanitize($input, $type = 'text')
        {

            if (isset($input)) {
                /* Fields with array values like multi-select */
                if (is_array($input)) {
                    $new_input = array();
                    foreach ($input as $key => $value) {
                        if ($type == 'text') {
                            $new_input[$key] = sanitize_text_field($input[$key]);
                        } elseif ($type = 'number') {
                            $new_input[$key] = absint($input[$key]);
                        }
                    }
                } else {
                    if ($type == 'text') {
                        $new_input = sanitize_text_field($input);
                    } elseif ($type = 'number') {
                        $new_input = absint($input);
                    }
                }
            }

            return $new_input;
        }

        public function abstract_sanitize($input, $text_fields)
        {
            $new_input = array();

            foreach ($input as $key => $value) {
                if (isset($input[$key])) {
                    if ($key == 'id_number') {
                        $new_input[$key] = absint($input[$key]);
                    } elseif (in_array($key, $text_fields)) {
                        $new_input[$key] = sanitize_text_field($input[$key]);
                    }
                }
            }

            return $new_input;
        }

        public function render_navigation($tab_section_objects)
        {
            $html = "<div class='main-nav'><ul>";
            foreach ($tab_section_objects as $key => $value) {
                $tab_object = $tab_section_objects[$key];
                $html .= "<li><a data-target='#" . $tab_object['page_name'] . "'>" . __($tab_object['page_title'], 'pauple-helpie') . '</a></li>';
            }
            $html .= '</ul></div>';
            echo $html;
        }

        public function render_main_area($tab_section_objects, $opts_grp)
        {
            echo "<div class='main-form'><form method='post' action='options.php'>";
            settings_fields($opts_grp);

            foreach ($tab_section_objects as $key => $value) {
                $tab_object = $tab_section_objects[$key];
                echo "<div id='" . $tab_object['page_name'] . "' class='ph-settings-section'>";
                do_settings_sections($tab_object['page_name']);

                if (method_exists($tab_object['page_obj'], 'render_custom_fields')) {
                    $tab_object['page_obj']->render_custom_fields();
                }

                echo '</div>';
            }

            submit_button();
            echo '</form></div>';
        }
    }
}