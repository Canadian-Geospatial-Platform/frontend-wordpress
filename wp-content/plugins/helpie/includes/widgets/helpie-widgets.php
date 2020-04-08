<?php

namespace Helpie\Includes\Widgets;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

if (!class_exists('\Helpie\Includes\Widgets\Helpie_Widgets')) {

    class Helpie_Widgets extends \WP_Widget
    {
        /**
         * Sets up the widgets name etc.
         */
        public function __construct()
        {
            $widget_ops = array(
                'classname' => 'pauple_helpie_popular_articles_widget',
                'description' => 'Popular Helpdesk Articles',
            );
            parent::__construct('pauple_helpie_popular_articles_widget', 'Popular Helpdesk Articles Widget', $widget_ops);
        }

        /**
         * Outputs the content of the widget.
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance)
        {
            // outputs the content of the widget
        }

        /**
         * Outputs the options form on admin.
         *
         * @param array $instance The widget options
         */
        public function form($instance)
        {
            // outputs the options form on admin
        }

        /**
         * Processing widget options on save.
         *
         * @param array $new_instance The new options
         * @param array $old_instance The previous options
         */
        public function update($new_instance, $old_instance)
        {
            // processes widget options to be saved
        }
    } // END CLASS
}

// register Foo_Widget widget
function register_foo_widget()
{
    register_widget('Helpie_Widgets');
}
add_action('\widgets_init', 'register_foo_widget');