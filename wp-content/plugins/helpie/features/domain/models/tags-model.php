<?php

namespace Helpie\Features\Domain\Models;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Domain\Models\Tags_Model')) {

    class Tags_Model
    {

      public function __construct() { }

      public function get_added_tag($post_id){
          $taxonomy = 'helpie_add_tag';
          $terms = get_the_terms($post_id, $taxonomy);

          wp_reset_postdata();
          wp_reset_query();

          if(isset($terms) && is_array($terms) && !empty($terms)){
              $term = $terms[0];
              if(isset($term)){
                  return $term->name;
              }
          }
      }

      public function get_permitted_added_tag($post_id){
        $added_tag = $this->get_added_tag($post_id);

        $option_name ='helpie_show_added_tags';
        $permitted_added_tags_array = get_option($option_name);

        if(!$permitted_added_tags_array){
          $permitted_added_tags_array = array(
            0 => 'all',
          );
        }

        if( isset($added_tag) && is_array($permitted_added_tags_array) && (
            in_array($added_tag, $permitted_added_tags_array) ||
            in_array('all', $permitted_added_tags_array)
        )){
          return $added_tag;
        }

      }

      public function get_updated_tag($post_id){
          $taxonomy = 'helpie_up_tag';
          $terms = get_the_terms($post_id, $taxonomy);
          wp_reset_postdata();
          wp_reset_query();
          if(isset($terms) && is_array($terms) && !empty($terms)){
              $term = $terms[0];
              if(isset($term)){
                  return $term->name;
              }
          }
      }

      public function get_permitted_updated_tag($post_id){
        $updated_tag = $this->get_updated_tag($post_id);

        $option_name ='helpie_show_updated_tags';
        $permitted_updated_tags_array = get_option($option_name);
        if(!$permitted_updated_tags_array){
          $permitted_updated_tags_array = array(
            0 => 'all',
          );
        }

        if(isset($updated_tag) && is_array($permitted_updated_tags_array) && (
            in_array($updated_tag, $permitted_updated_tags_array) ||
            in_array('all', $permitted_updated_tags_array)
        )){
          return $updated_tag;
        }
      }

    } // End of CLASS
}
