<?php
namespace  Helpie\Features\Components\Toc\Model;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Toc\Model\Style_Config_Model')) {
    class Style_Config_Model
    {
        public function get_config()
        {
            $style_config = array(
                'collection' => array(
                    'name' => 'helpie_toc',
                    'selector' => '.helpie-toc',
                    'label' => __('Helpie Table of Contents', 'pauple-helpie'),
                    'styleProps' => array( 'background', 'border', 'padding', 'margin')
                ),
                'title' => array(
                    'name' => 'helpie_toc_title',
                    'selector' => '.helpie-toc .collection-title',
                    'label' => __('Title', 'pauple-helpie'),
                    'styleProps' => array( 'background', 'color', 'typography', 'text-align', 'border', 'padding', 'margin')
                ),

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.helpie-toc .helpie-element',
                    'label' => __('Single Item', 'elementor'),
                    'styleProps' => array( 'background', 'border', 'padding', 'margin'),
                    'children' => array(
                        'title' => array(
                            'name' => 'helpie_element_title',
                            'selector' => '.helpie-toc  .helpie-element .item-title a',
                            'label' => __('Single Item Title', 'pauple-helpie'),
                            'styleProps' => array( 'color', 'typography', 'border')
                        ),
                    )
                ),

            );

            return $style_config;
        }
    }
}
