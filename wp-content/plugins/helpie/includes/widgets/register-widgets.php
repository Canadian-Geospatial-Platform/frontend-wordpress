<?php

namespace Helpie\Includes\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Widgets\Register_Widgets')) {
    class Register_Widgets
    {
        public function load()
        {
            add_action('widgets_init', function () {
                $article_widget_args = array(
                    'id' => 'helpie-kb-article-listing',
                    'name' => 'Helpie Article Listing',
                    'description' => 'Helpie KB Articles Listing Widget',
                    'model' => new \Helpie\Features\Components\Articles\Article_Listing_Model(),
                    'view' => new \Helpie\Features\Components\Articles\Article_Listing(),
                );
                $article_widget = new \Helpie\Includes\Core\Widget_Factory($article_widget_args);
                register_widget($article_widget);
            });

            add_action('widgets_init', function () {
                $category_widget_args = array(
                    'id' => 'helpie-category-listing-widget',
                    'name' => 'Helpie KB Categories Listing',
                    'description' => 'This is an Categories Listing Widget',
                    'model' => new \Helpie\Features\Components\Category_Listing\Category_Listing_Model(),
                    'view' => new \Helpie\Features\Components\Category_Listing\Category_Listing(),
                );
                $category_widget = new \Helpie\Includes\Core\Widget_Factory($category_widget_args);
                register_widget($category_widget);
            });

            add_action('widgets_init', function () {
                $hero_widget_args = array(
                    'id' => 'helpie-kb-hero-widget',
                    'name' => 'Helpie KB Hero Section',
                    'description' => 'This is a Helpie KB Hero Section Widget',
                    'model' => new \Helpie\Features\Components\Hero\Hero_Area_Model(),
                    'view' => new \Helpie\Features\Components\Hero\Hero_Area(),
                );
                $hero_widget = new \Helpie\Includes\Core\Widget_Factory($hero_widget_args);
                register_widget($hero_widget);
            });

            add_action('widgets_init', function () {
                $stats_widget_args = array(
                    'id' => 'helpie-kb-frontend-stats-widget',
                    'name' => 'Helpie KB Stats Section',
                    'description' => 'This is a Helpie KB Stats Section Widget',
                    'model' => new \Helpie\Features\Components\Stats\Stats_Model(),
                    'view' => new \Helpie\Features\Components\Stats\Frontend_Stats(),
                );
                $stats_widget = new \Helpie\Includes\Core\Widget_Factory($stats_widget_args);
                register_widget($stats_widget);
            });

            add_action('widgets_init', function () {
                $stats_widget_args = array(
                    'id' => 'helpie-kb-toc-widget',
                    'name' => 'Helpie KB Table of Contents',
                    'description' => 'This is a Helpie Table of Contents Section Widget',
                    'model' => new \Helpie\Features\Components\Toc\Model\Toc_Model(),
                    'view' => new \Helpie\Features\Components\Toc\Toc_Controller(),
                );
                $stats_widget = new \Helpie\Includes\Core\Widget_Factory($stats_widget_args);
                register_widget($stats_widget);
            });

            add_action('widgets_init', function () {
                $voting_widget_args = array(
                    'id' => 'helpie-kb-voting-widget',
                    'name' => 'Helpie KB Voting',
                    'description' => 'This is a Helpie Article Voting Widget',
                    'model' => new \Helpie\Features\Components\Voting\Voting_Model(),
                    'view' => new \Helpie\Features\Components\Voting\Voting_Controller(),
                );
                $voting_widget = new \Helpie\Includes\Core\Widget_Factory($voting_widget_args);
                register_widget($voting_widget);
            });

            add_action('widgets_init', function () {
                $breadcrumbs_widget_args = array(
                    'id' => 'helpie-kb-breadcrumbs-widget',
                    'name' => 'Helpie KB Breadcrumbs',
                    'description' => 'This is a Helpie Breadcrumbs Widget',
                    'model' => new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs_Model(),
                    'view' => new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs(),
                );
                $breadcrumbs_widget = new \Helpie\Includes\Core\Widget_Factory($breadcrumbs_widget_args);
                register_widget($breadcrumbs_widget);
            });

            add_action('widgets_init', function () {
                $search_widget_args = array(
                    'id' => 'helpie-kb-search-results-widget',
                    'name' => 'Helpie KB Search Results',
                    'description' => 'This is a Helpie Search Results Widget',
                    'model' => new \Helpie\Features\Components\Search\Models\Search_Model(),
                    'view' => new \Helpie\Features\Components\Search\Search_Controller(),
                );
                $search_widget = new \Helpie\Includes\Core\Widget_Factory($search_widget_args);
                register_widget($search_widget);
            });

            add_action('widgets_init', function () {
                $page_controls_widget_args = array(
                    'id' => 'helpie-kb-page-controls-widget',
                    'name' => 'Helpie KB Page Controls',
                    'description' => 'This is a Helpie Page Controls Widget',
                    'model' => new \Helpie\Features\Components\Page_Controls\Model(),
                    'view' => new \Helpie\Features\Components\Page_Controls\Controller(),
                );
                $page_controls_widget = new \Helpie\Includes\Core\Widget_Factory($page_controls_widget_args);
                register_widget($page_controls_widget);
            });

            add_action('widgets_init', function () {
                $search_box_widget_args = array(
                    'id' => 'helpie-kb-search-box-widget',
                    'name' => 'Helpie KB Search Box',
                    'description' => 'This is a Helpie Search Box Widget',
                    'model' => new \Helpie\Features\Components\Search\Search_Box\Model(),
                    'view' => new \Helpie\Features\Components\Search\Search_Box\Controller(),
                );
                $search_box_widget = new \Helpie\Includes\Core\Widget_Factory($search_box_widget_args);
                register_widget($search_box_widget);
            });
        }
    } // END CLASS
}