<?php

namespace Helpie\Includes\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if (!class_exists('\Helpie\Includes\Widgets\Elementor_Widget_Base')) {
    abstract class Elementor_Widget_Base extends Widget_Base
    {
        public function __construct($data = [], $args = null)
        {
            parent::__construct($data, $args);
        }

        protected function get_elementor_type($input_type)
        {
            if ($input_type == 'text') {
                return Controls_Manager::TEXT;
            } elseif ($input_type == 'multi-select') {
                return Controls_Manager::SELECT2;
            } elseif ($input_type == 'select') {
                return Controls_Manager::SELECT;
            } elseif ($input_type == 'number') {
                return Controls_Manager::NUMBER;
            } else {
                return Controls_Manager::TEXT;
            }
        }

        // To be used in render() and _content_template()
        protected function helpie_render_template($input, $widget_view)
        {
            echo $widget_view->get_view($input);
        }

        protected function get_elementor_props($field)
        {
            $field_props = array(
                'label' => $field['label'],
                'type' => $this->get_elementor_type($field['type']),
                'default' => $field['default'],
            );

            if ($field['type'] == 'select' || $field['type'] == 'multi-select') {
                $field_props['options'] = $field['options'];
            }

            if ($field['type'] == 'multi-select') {
                $field_props['multiple'] = true;
            }

            return $field_props;
        }

        protected function register_content_controls_from_fields($fields)
        {
            $this->start_controls_section(
                'section_content',
                [
                    'label' => __('Content', 'pauple-helpie'),
                ]
            );

            foreach ($fields as $key => $field) {
                $field_name = $key;
                $field_props = $this->get_elementor_props($field);
                $this->add_control($field_name, $field_props);
            }

            $this->end_controls_section();
        }

        protected function render_style_control($name, $selector, $control_name, $label = '')
        {
            if ($control_name == 'background') {
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => $name . '_background',
                        'types' => ['classic', 'gradient', 'video'],
                        'selector' => '{{WRAPPER}} ' . $selector,
                        'separator' => 'before',
                    ]
                );
            } elseif ($control_name == 'border') {
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => $name . '_border',
                        'selector' => '{{WRAPPER}} ' . $selector,
                        'separator' => 'before',
                    ]
                );
            } elseif ($control_name == 'border_radius') {
                $this->add_control(
                    $name . '_border_radius',
                    [
                        'label' => __('Border Radius', 'elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );
            } elseif ($control_name == 'box_shadow') {
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => $name . '_box_shadow',
                        'selector' => '{{WRAPPER}} ' . $selector,
                    ]
                );
            } elseif ($control_name == 'color') {
                $this->add_control(
                    $name . '_color',
                    [
                        'label' => __($label . ' Color', 'pauple-helpie'),
                        'type' => Controls_Manager::COLOR,
                        'scheme' => [
                            'type' => Scheme_Color::get_type(),
                            'value' => Scheme_Color::COLOR_1,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} ' . $selector => 'color: {{VALUE}} !important',
                        ],
                    ]
                );
            } elseif ($control_name == 'typography') {
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => $name . '_typography',
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                        'selector' => '{{WRAPPER}} ' . $selector,
                        'separator' => 'before',
                    ]
                );
            } elseif ($control_name == 'text-align') {
                $this->add_control(
                    $name . '_text_align',
                    [
                        'label' => __('Text Align', 'elementor'),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'left' => [
                                'title' => __('Left', 'elementor'),
                                'icon' => 'fa fa-align-left',
                            ],
                            'center' => [
                                'title' => __('Center', 'elementor'),
                                'icon' => 'fa fa-align-center',
                            ],
                            'right' => [
                                'title' => __('Right', 'elementor'),
                                'icon' => 'fa fa-align-right',
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}} !important;',
                        ],
                    ]
                );
            } elseif ($control_name == 'icon') {
                $this->fontawesome_icons = $this->fontawesome_icons = new \Helpie\Includes\Admin\FontAwesome_Icons();
                $icons_array = $this->fontawesome_icons->get_all_icons_list();

                foreach ($icons_array as $key => $value) {
                    $icons_array[$key] = 'fa ' . $value;
                }

                $this->add_control(
                    $name,
                    [
                        'label' => __('Title Icon', 'pauple-helpie'),
                        'type' => Controls_Manager::ICON,
                        'include' => $icons_array,
                    ]
                );
            } elseif ($control_name == 'position') {
                $this->add_control(
                    $name . '_position',
                    [
                        'label' => __($label . ' Position', 'pauple-helpie'),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'before',
                        'options' => array(
                            'before' => 'Before',
                            'after' => 'After',
                        ),
                    ]
                );
            } elseif ($control_name == 'padding') {
                // PADDING
                $this->add_responsive_control(
                    $name . '_padding',
                    [
                        'label' => __('Padding', 'elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                    ]
                );
            } elseif ($control_name == 'margin') {

                // MARGIN
                $this->add_responsive_control(
                    $name . '_margin',
                    [
                        'label' => __('Margin', 'elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                    ]
                );
            }
        }

        protected function collection_style_controls($style_config)
        {
            $element_style_config = $style_config['collection'];
            if (isset($element_style_config) && !empty($element_style_config)) {
                $this->render_single_element_style_controls($element_style_config);
            }
        }

        protected function render_single_element_style_controls($config)
        {
            if (isset($config) && !empty($config)) {
                $this->start_controls_section(
                    $config['name'] . '_style',
                    [
                        'label' => $config['label'],
                        'tab' => Controls_Manager::TAB_STYLE,
                    ]
                );

                for ($ii = 0; $ii < sizeof($config['styleProps']); $ii++) {
                    $this->render_style_control($config['name'], $config['selector'], $config['styleProps'][$ii]);
                }

                $this->end_controls_section();
            }
        }

        protected function single_element_controls($config)
        {
            if (isset($config) && !empty($config)) {
                $this->render_single_element_style_controls($config);
            }

            if (isset($config['children']) && !empty($config['children'])) {
                foreach ($config['children'] as $key => $child_config) {
                    $this->render_single_element_style_controls($child_config);
                }
            }
        }

        protected function collection_title_style_controls($style_config)
        {
            if (isset($style_config) && !empty($style_config)) {
                $this->render_single_element_style_controls($style_config);
            }
        }
    } // END CLASS
}