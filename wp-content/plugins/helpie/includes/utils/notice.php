<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Utils\Notice')) {
    class Notice
    {
        public function __construct($args)
        {
            $page_name = $args['name'];

            $this->page_id_option_name = $page_name . '_page_id';
            $this->restore_state = $page_name . '_restore_state';
            $this->page_slug = $page_name . '_page';
            $this->page_title = $args['title'];
            $this->page_content = isset($args['page_content']) ? $args['page_content'] : '';
            $this->dismiss_status = $args['dismiss_status']; // 'skip' or 'dismiss permanently'
            $this->content = $args['content'];
            $this->type = $args['type'];

            $this->show_notice();
            add_action('wp_loaded', array($this, 'wp_loaded_actions'));
        }

        public function wp_loaded_actions()
        {
            $this->restore_page();
            $this->notice_dismissed_handler();
        }

        public function show_notice()
        {
            if (!get_option($this->dismiss_status)) {
                $page_id = get_option($this->page_id_option_name);
                $published = (get_post_status($page_id) == 'publish');
                // show admin warning notice to restore the page
                if (!$published) {
                    $notice_html = ($this->type !== 'warning') ? 'onboard_notice' : 'get_notice_html';
                    add_action('admin_notices', array($this, $notice_html));
                }
            }

            // Redirect to helpie-settings page imported done or notice skipped already
            $this->redirect_onboard_page();
        }

        public function notice_dismissed_handler()
        {
            if (isset($_GET[$this->dismiss_status])) {
                update_option($this->dismiss_status, true);
                if ($this->dismiss_status == 'onboarding_setup_notice_dismissed') {
                    $activator = new \Helpie\Includes\Core\Kb_Activator();
                    $activator::setup_dummy_content();
                }
                $this->redirect_page();
            }

        }

        public function restore_page()
        {
            if (isset($_GET[$this->restore_state])) {
                $page_id = get_option($this->page_id_option_name);
                $trashed = get_post_status($page_id) == 'trash';
                // Untrash the page.
                if ($trashed) {
                    wp_untrash_post($page_id);
                }
                // To Create page if Deleted.
                else {
                    $create_pages = new \Helpie\Includes\Core\Create_Pages();
                    $create_pages->create($this->page_slug, $this->page_id_option_name, $this->page_title, $this->page_content);
                }
                // Refresh page after restored
                $this->redirect_page();
            }
        }

        // has to be 'public' as its a hook
        public function get_notice_html()
        {
            $param1 = array($this->restore_state => 'true');
            $param2 = array($this->dismiss_status => 'true');

            $html = "<div class='notice notice-warning is-dismissible'>";
            $html .= "<p><strong>" . $this->content;
            $html .= "<a href='" . add_query_arg($param1) . "'> restore ";
            $html .= "</a>";
            $html .= "</strong> the page ?</p>";
            $html .= "<a href='" . add_query_arg($param2) . "' class='button' style='color: #f46842; margin-bottom: 5px;'>Dismiss Permanently</a>";
            $html .= "<button type='button' class='notice-dismiss'>";
            $html .= "<span class='screen-reader-text'>Dismiss this notice.</span>";
            $html .= "</button>";
            $html .= "</div>";

            echo $html;
        }

        public function onboard_notice()
        {
            $html = '';
            $queried = new \WP_Query(['post_type' => HELPIE_POST_TYPE, 'post_status' => ['publish', 'trash']]);
            $imported = get_option('helpiekb_imported_entries');
            $skipped = get_option('onboarding_setup_notice_dismissed');

            $is_article_present = $queried->post_count < 1;
            $is_importing_completed_once = (isset($imported) && !empty($imported));
            $is_notice_skipped = (isset($skipped) && !empty($skipped));
            $is_onboarding_page = (isset($_GET['page']) && $_GET['page'] == 'onboarding');

            if ($is_article_present == true
                && !($is_importing_completed_once || $is_notice_skipped)
                && $is_onboarding_page == false
            ) {
                $html .= $this->get_notice_html_v2();
            }

            echo $html;
        }

        public function get_notice_html_v2()
        {
            // $param1 = array($this->restore_state => 'true');
            $param = array($this->dismiss_status => 'true');

            $html = '<div class="notice notice-info helpiekb-notice is-dismissible">';
            $html .= '<div class="message-inner">';

            $html .= '<div class="message-icon">';
            $html .= '<img src="' . HELPIE_PLUGIN_URL . '/includes/asset-files/assets/helpie-logo.png' . '"/>';
            $html .= '</div>';

            $html .= '<div class="message-content">';
            $html .= '<strong>' . __('Welcome to Helpie KB Wiki', HELPIE_DOMAIN) . '!</strong>';
            $html .= '<p>' . __($this->content, HELPIE_DOMAIN) . '</p>';
            $html .= '<div class="message-action">';
            $html .= '<a href="edit.php?post_type=pauple_helpie&page=onboarding" class="button button-primary">';
            $html .= __('Go to Setup Page', HELPIE_DOMAIN);
            $html .= '</a>&nbsp;&nbsp;';
            $html .= '<a href="' . add_query_arg($param) . '" class="button button-secondary">' . __('Skip', HELPIE_DOMAIN) . '</a>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function redirect_onboard_page()
        {
            $imported = get_option('helpiekb_imported_entries');
            $skipped = get_option('onboarding_setup_notice_dismissed');

            $is_importing_completed_once = (isset($imported) && !empty($imported));
            $is_notice_skipped = (isset($skipped) && !empty($skipped));
            $is_onboarding_page = (isset($_GET['page']) && $_GET['page'] == 'onboarding');

            if ($is_onboarding_page && ($is_importing_completed_once || $is_notice_skipped)) {
                $uri = '?post_type=pauple_helpie&page=helpie-kb-settings';
                $this->redirect_page($uri);
            }
        }

        protected function redirect_page($escape_uri = '?post_type=page')
        {
            echo "<script type='text/javascript'>
               window.location=document.location.href='" . $escape_uri . "';
            </script>";
        }
    } // END CLASS
}
