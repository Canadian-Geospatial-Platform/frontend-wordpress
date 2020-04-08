<?php

namespace Helpie\Features\Components\Toc;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Components\Toc\Toc_Controller')) {

    class Toc_Controller
    {
        public function __construct()
        {
            // Scripts
            $this->scripts_handler = new \Helpie\Includes\Core\Scripts_Handler();

            // Toc Models
            $this->toc_model = new \Helpie\Features\Components\Toc\Model\Toc_Model();
            $this->auto_toc_model = new \Helpie\Features\Components\Toc\Model\Auto_Toc_model();

            // Single Page Components Views
            $this->id_added_content_view = new \Helpie\Features\Components\Toc\View\Id_Added_Content_View();
            $this->backtotop_view = new \Helpie\Features\Components\Toc\View\Backtotop_View();

            // Table Of Contents Views
            $this->toc_view = new \Helpie\Features\Components\Toc\View\Toc_View();
            $this->auto_toc_view = new \Helpie\Features\Components\Toc\View\Auto_Toc_View();
        }

        public function get_view($args = array())
        {
            // error_log('$args : ' . print_r($args, true));
            $args = $this->convert_booleanString_to_bolean($args);
            $viewProps = $this->toc_model->get_viewProps($args);
            $collectionProps = $viewProps['collection'];

            $this->scripts_handler->enqueue_semantic_scripts();
            $this->scripts_handler->enqueue_kb_frontend_scripts();

            $post_id = get_the_ID();
            $post = get_post($post_id);

            if (isset($post) && !empty($post)) {
                $has_postType = ($post->post_type == 'pauple_helpie');
                $has_inPageNav = $collectionProps['toc_type'] == 'page-scroll-only';

                if ($has_postType && $has_inPageNav && is_single()) {

                    $is_unlocked = apply_filters('helpiekb/is_unlocked', 'article', $post_id);
                    if (!$is_unlocked) {
                        return;
                    }

                    $viewProps = $this->auto_toc_model->get_viewProps($collectionProps);

                    return $this->auto_toc_view->get($viewProps);
                }
            }
            return $this->toc_view->get($viewProps);
        }

        public function convert_booleanString_to_bolean($args)
        {

            foreach ($args as $key => $arg) {
                if ($arg === 'true') {
                    $args[$key] = true;
                }

                if ($arg === 'false') {
                    $args[$key] = false;
                }

                // error_log('$key : ' . $key);
                // error_log('$arg : ' . $arg);
            }

            return $args;
        }

        public function get_content($content)
        {
            $viewProps = $this->auto_toc_model->get_viewProps();

            return $this->id_added_content_view->get_view($viewProps, $content);
        }

        public function get_backtotop($content)
        {
            $post_id = get_the_ID();
            $post_type =   $post_type = get_post_type();
            $has_postType = ($post_type == 'pauple_helpie');


            if ($has_postType  && is_single()) {
                $viewProps = $this->auto_toc_model->get_viewProps();
                $collectionProps = $viewProps['collection'];

                return $this->backtotop_view->get_view($collectionProps, $content);
            }

            return $content;
        }
    }
}