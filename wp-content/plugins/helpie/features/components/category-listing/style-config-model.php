<?php
namespace Helpie\Features\Components\Category_Listing;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Category_Listing\Style_Config_Model')) {
    class Style_Config_Model
    {
        public function get_config()
        {
            $style_config = array(
                'collection' => array(
                    'name' => 'helpie_category_listing',
                    'selector' => '.helpie-category-listing',
                    'label' => __('Category Listing', 'pauple-helpie'),
                    'styleProps' => array( 'background', 'border', 'padding', 'margin')
                ),

                'title' => array(
                    'name' => 'category-listing_title',
                    'selector' => '.helpie-category-listing .collection-title',
                    'label' => __('Title', 'pauple-helpie'),
                    'styleProps' => array( 'color', 'typography', 'text-align', 'border', 'padding', 'margin')
                ),

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.helpie-category-listing .helpie-element',
                    'label' => __('Single Item', 'elementor'),
                    'styleProps' => array( 'background', 'border', 'padding', 'margin'),
                    'children' => array(
                        'title' => array(
                            'name' => 'helpie_element_title',
                            'selector' => '.helpie-category-listing .helpie-element .header',
                            'label' => __('Single Item Title', 'pauple-helpie'),
                            'styleProps' => array( 'color', 'typography', 'text-align', 'border')
                        ),
                    )
                ),
            );

            return $style_config;
        }
    }
}
