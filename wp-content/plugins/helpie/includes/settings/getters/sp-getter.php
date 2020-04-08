<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Sp_Getter')) {
    class Sp_Getter
    {
        public function __construct()
        {
            // $this->options = get_option('helpie_sp_options');
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

        public function show_search()
        {
            $show_search = isset($this->options['helpie_single_page_search_display']) ? $this->options['helpie_single_page_search_display'] : true;
            return $show_search;
        }


        public function get_template_source()
        {
            $option_name = 'helpie_sp_template_source';
            $template_source = 'helpie';

            if (isset($this->options[$option_name])) {
                $template_source = $this->options[$option_name];
            }

            return $template_source;
        }

        public function get_template()
        {
            $option_name = 'helpie_sp_template';
            $template = 'left-sidebar';

            if (isset($this->options[$option_name])) {
                $template = $this->options[$option_name];
            }

            return $template;
        }

        public function show_user_name()
        {

            $show_user_name = isset($this->options['helpie_single_page_updatedby_display']) ? $this->options['helpie_single_page_updatedby_display'] : false;
            return $show_user_name;
        }

        public function show_last_updatedon()
        {
            $show_last_updatedon = isset($this->options['helpie_single_page_updatedon_display']) ? $this->options['helpie_single_page_updatedon_display'] : false;
            return $show_last_updatedon;
        }

        public function show_pageviews()
        {
            $show_pageviews = isset($this->options['helpie_single_page_show_pageviews']) ? $this->options['helpie_single_page_show_pageviews'] : false;
            return $show_pageviews;
        }

        public function allow_visitors_to_vote()
        {
            $allow_visitors_to_vote = isset($this->options['helpie_voting_access']) ? $this->options['helpie_voting_access'] : false;
            return $allow_visitors_to_vote;
        }

        public function show_comments()
        {
            $show_comments = isset($this->options['helpie_show_comments']) ? $this->options['helpie_show_comments'] : false;
            return $show_comments;
        }

        public function get_voting_label()
        {
            $option_name = 'helpie_voting_label';
            $label = 'How did you like this article?';

            if (isset($this->options[$option_name])) {
                $label = $this->options[$option_name];
            }

            return $label;
        }

        public function get_voting_template()
        {
            $voting_template = isset($this->options['helpie_voting_template']) ? $this->options['helpie_voting_template'] : 'emotion';
            return $voting_template;
        }

        public function get_single_cpt_name()
        {
            $single_cpt_name = "Article";
            $group = $this->options;

            if (isset($group['helpie_sp_cpt_label']) && !empty($group['helpie_sp_cpt_label'])) {
                $single_cpt_name = $this->options['helpie_sp_cpt_label'];
            }

            return $single_cpt_name;
        }

        public function get_single_cpt_name_plural()
        {
            $single_cpt_name = "Articles";
            $group = $this->options;

            if (isset($group['helpie_sp_cpt_label_plural']) && !empty($group['helpie_sp_cpt_label_plural'])) {
                $single_cpt_name = $this->options['helpie_sp_cpt_label_plural'];
            }

            return $single_cpt_name;
        }
    }
}