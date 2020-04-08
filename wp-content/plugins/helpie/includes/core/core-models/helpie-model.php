<?php

namespace Helpie\Includes\Core\Core_Models;

if (!class_exists('\Helpie\Includes\Core\Core_Models\Helpie_Model')) {
    class Helpie_Model
    {
        public function __construct()
        {
            $this->mp_settings = new \Helpie\Includes\Settings\Getters\Mp_Settings();
        }
        public function get_mainpage_permalink()
        {

            if ($this->mp_settings->get_mp_location() == 'archive') {
                return get_post_type_archive_link('pauple_helpie');
            } else {
                $post_id = $this->get_mp_selected_page();
                return get_permalink($post_id);
            }
        }

        public function get_cpt_slug()
        {

            if ($this->mp_settings->get_mp_location() == 'archive') {
                $cpt_slug = $this->mp_settings->get_mp_slug();
            } else {
                $post_id = $this->get_mp_selected_page();
                $post = get_post($post_id);
                $cpt_slug = $post->post_name;
            }

            return $cpt_slug;
        }

        public function get_mp_selected_page()
        {

            return $this->mp_settings->get_mp_selected_page();
        }

        public function has_archive()
        {
            if ($this->mp_settings->get_mp_location() == 'archive') {
                return true;
            }

            return false;
        }

    }
}