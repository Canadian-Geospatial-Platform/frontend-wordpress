<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Widget_Factory')) {
    class Widget_Factory extends \Helpie\Includes\Widgets\Helpie_Widget
    {
        public function __construct($widget_options)
        {
            $this->widget_options = $widget_options;
            // error_log('widget_options: ' . print_r($widget_options, true));
            parent::__construct($widget_options);

            $this->widget_model = $widget_options['model'];
            $this->widget_view = $widget_options['view'];
        }

        public function widget($args, $instance)
        {
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);

            // before widget render content filter
            // $render_content = apply_filters("helpiekb/widget/before_render_content", $this->widget_options);
            // $after_widget = $after_widget . $render_content;

            echo $before_widget;
            if (!empty($title)) {
                echo $before_title . $title . $after_title;
            }

            // Array of Fields => default Values
            $defaults = $this->widget_model->get_default_args();
            $input = $this->setInputFromInstance($defaults, $instance);
            
            // After widget render content filter
            $render_content = apply_filters("helpiekb/widget/after_render_content", '', $this->widget_options, 'helpiekb');
            $after_widget = $after_widget . $render_content;

            // Widget output
            echo $this->widget_view->get_view($input);
            echo $after_widget;            
        }

        public function update($new_instance, $old_instance)
        {
            // Save widget options
            $instance = $old_instance;
            $default_args = $this->widget_model->get_default_args();
            $instance = $this->updateInstanceFromNewInstance($instance, $new_instance, $default_args);

            return $instance;
        }

        public function form($instance)
        {
            // Output admin widget options form

            $html = '';

            $fields = $this->widget_model->get_fields();
            foreach ($fields as $field) {
                $html .= $this->get_field_html($instance, $field);
            }

            echo $html;
        }
    }
}
