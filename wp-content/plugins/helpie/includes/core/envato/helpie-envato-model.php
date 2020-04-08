<?php

namespace Helpie\Includes\Core\Envato;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Envato\Helpie_Envato_Model')) {
    class Helpie_Envato_Model
    {
        public function __construct()
        {
            $this->set_default_props();
        }

        public function set_default_props()
        {
            $this->plugin_info = get_option('helpie_plugin_info', '');

            $this->envato_api_token = get_option('helpie_envato_api_token', '');
            $this->force_register = get_option('helpie_force_registration', '');
            $this->unregister_panel = apply_filters('helpie_unregister', false);
            $this->current_version = HELPIE_PLUGIN_VERSION;
            $this->last_version = (isset($this->plugin_info['version'])) ? $this->plugin_info['version'] : '';
            $this->updated_at = (isset($this->plugin_info['updated_at'])) ? ' (' . date('m/d/Y', strtotime($this->plugin_info['updated_at'])) . ')' : null;
            $this->license = (isset($this->plugin_info['license'])) ? $this->plugin_info['license'] : null;
            $this->purchase_code = (isset($this->plugin_info['purchase_code'])) ? $this->plugin_info['purchase_code'] : null;

            $this->supported_until = (isset($this->plugin_info['supported_until'])) ? $this->plugin_info['supported_until'] : null;
            if ($this->supported_until) {
                $date = strtotime($this->supported_until);
                $diff = $date - time();
                $this->supported_until = floor($diff / (60 * 60 * 24));
            }
        }

        public function get_version_props()
        {
            $current_version_color = 'green';

            if ($this->new_version_available()) {
                $current_version_color = 'orange';
            }

            $itemsListProps = array(
                0 => array(
                    'icon_code' => 'hdd',
                    'icon_color' => $current_version_color,
                    'title' => $this->get_current_version(),
                    'description' => __('Installed Version', 'pauple-helpie'),
                ),
                1 => array(
                    'icon_code' => 'download',
                    'icon_color' => '',
                    'title' => $this->get_last_version(),
                    'description' => __('Last Available Version', 'pauple-helpie'),
                ),
            );

            return $itemsListProps;
        }

        public function is_token_set()
        {
            if (isset($this->envato_api_token) && !empty($this->envato_api_token)) {
                return true;
            }

            return false;
        }

        public function get_current_version()
        {
            return $this->current_version;
        }

        public function get_last_version()
        {
            return $this->last_version;
        }

        public function get_supported_until()
        {
            return $this->supported_until;
        }

        public function get_purchase_code()
        {
            return $this->purchase_code;
        }

        public function get_envato_api_token()
        {
            return $this->envato_api_token;
        }

        public function show_register_to_access_button()
        {
            return (!$this->unregister_panel || $this->purchase_code || $this->force_register);
        }

        public function show_register_panel()
        {
            $register_panel_condition = (!$this->unregister_panel || $this->purchase_code || $this->force_register);
            return $register_panel_condition;
        }

        public function version_not_set()
        {
            return (version_compare($this->last_version, '0.0.1', '<'));
        }

        public function new_version_available()
        {
            return (version_compare($this->last_version, $this->current_version) > 0);
        }

        public function show_update_button()
        {
            $new_version_available = $this->new_version_available();

            return ($new_version_available && current_user_can('update_plugins'));
        }

        public function get_update_link()
        {
            // plugin slug
            $name = 'Helpie';
            $slug = 'helpie/helpie.php';
            // Upgrade link.
            $upgrade_link = add_query_arg(array(
                'action' => 'upgrade-plugin',
                'plugin' => $slug,
            ), self_admin_url('update.php'));

            return sprintf(
                '<a class="update-now tg-button tg-button-live-update" href="%1$s" aria-label="%2$s" data-name="%3$s %6$s" data-plugin="%4$s" data-slug="%5$s" data-version="%6$s"><button class="positive ui button"><i class="cloud icon"></i>%7$s</button></a>',
                wp_nonce_url($upgrade_link, 'upgrade-plugin_' . $slug),
                esc_attr__('Update %s now', 'envato-market'),
                esc_attr($name),
                esc_attr($slug),
                sanitize_key(dirname($slug)),
                esc_attr($this->last_version),
                esc_html__('Update Now', 'envato-market')
            );
        }
    }
}
