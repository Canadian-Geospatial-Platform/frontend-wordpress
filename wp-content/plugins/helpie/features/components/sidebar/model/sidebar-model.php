<?php

namespace Helpie\Features\Components\Sidebar\Model;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Sidebar\Model\Sidebar_Model')) {
    class Sidebar_Model
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_viewProps($args)
        {
            $collectionProps = $this->get_collectionProps($args);
            $itemsProps = $this->get_itemsProps($collectionProps);

            $viewProps = array(
                'collection' => $collectionProps,
                'items' => $itemsProps,
            );

            return $viewProps;
        }

        public function get_collectionProps($args)
        {
            $collectionProps = array(
                'position' => $args['position'],
                'template' => $args['template'],
                'count' => $args['count'],
            );

            return $collectionProps;
        }

        public function get_itemsProps($collection)
        {
            $sidebar_template = $this->get_sidebar_options($collection);

            $items['sidebar_type'] = $sidebar_template;
            $items['wrapper_classes'] = $this->get_wrapper_classes($collection);

            return $items;
        }

        protected function get_wrapper_classes($collection)
        {

            $classes = $collection['position'];
            $position = $this->settings->components->get_sidebar_position();

            if (isset($position) && !empty($position)) {
                $classes .= ' fixed-sidebar';
            }

            return $classes;
        }

        protected function get_sidebar_options($collection)
        {
            $template = $collection['template'];

            if ($template == 'single_template') {
                $template = $this->set_sidebar_template('sp', $collection);
            } elseif ($template == 'category_template') {
                $template = $this->set_sidebar_template('cp', $collection);
            } elseif ($template == 'mainpage_template') {
                $template = $this->set_sidebar_template('mp', $collection);
            }

            return $template;

        }

        protected function set_sidebar_template($template_code, $collection)
        {
            $position = $collection['position'];
            $count = $collection['count'];
            $options = get_option('helpie-kb');

            $template_option_key = 'helpie_' . $template_code . '_sidebar1';

            if ($count == 'both' && $position == 'right') {
                $template_option_key = 'helpie_' . $template_code . '_sidebar2';
            }

            $template = isset($options[$template_option_key]) ? $options[$template_option_key] : 'helpie_sidebar';

            return $template;
        }
    }
}