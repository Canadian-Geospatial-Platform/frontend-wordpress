<?php

namespace Helpie\Features\Components\Toc\Model;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Components\Toc\Model\Auto_Toc_Model')) {
    class Auto_Toc_Model extends \Helpie\Includes\Core\Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->auto_toc_service = new \Helpie\Features\Components\Toc\Model\Auto_Toc_Service();
        }

        public function get_viewProps($args = array())
        {
            $collectionProps = $this->get_collectionProps($args);
            $itemsProps = $this->get_itemsProps($collectionProps);

            $viewProps = array(
                'collection' => $collectionProps,
                'items' => $itemsProps,
            );

            return $viewProps;
        }

        protected function get_collectionProps($args)
        {
            $settings = $this->settings->components->get_toc_settings();
            return array_merge($settings, $args);
        }

        protected function get_itemsProps($collectionProps)
        {
            $heads = $this->get_heads($collectionProps);

            return $this->auto_toc_service->generateProps($heads, $collectionProps);
        }

        protected function get_content()
        {
            $post = get_post(get_the_ID());
            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);

            return $kb_article->get_the_content();
        }

        protected function get_heads($collectionProps)
        {
            $exclude = $this->get_excluded_heads($collectionProps);
            $content = $this->get_content();

            // get the headings down to the specified depth
            $pattern = '/<h([' . $exclude . '])[^>]*>\S.*<\/h\1>/msuU';
            preg_match_all($pattern, $content, $matches);

            return $matches[0];
        }

        protected function get_excluded_heads($collectionProps)
        {
            $exclude = $collectionProps['exclude_heads'];

            if (isset($exclude) && is_array($exclude) && !empty($exclude)) {

                $exclude = implode(',', array_diff([1, 2, 3, 4, 5, 6], $exclude));

                return (empty($exclude)) ? '0' : $exclude;
            }

            return '1-6';
        }
    }
}