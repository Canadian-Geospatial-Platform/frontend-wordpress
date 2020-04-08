<?php

namespace Helpie\Features\Components\Onboarding;

if (!class_exists('\Helpie\Features\Components\Onboarding\Controller')) {
    class Controller
    {
        public function __construct()
        {
            $this->imports = new \Helpie\Features\Components\Imports\Controller();
            $this->model = new \Helpie\Features\Components\Onboarding\Model();

            $this->args = $this->imports->get_demos_categories($this->model->get_args());

            add_action('admin_menu', array($this, 'add_onboard_page'));
            add_action('admin_head', function () {
                remove_submenu_page('edit.php?post_type=pauple_helpie', 'onboarding');
            });
        }

        public function add_onboard_page()
        {
            $page_title = __('Onboarding', 'pauple-helpie');
            // This page will be under "Settings"
            add_submenu_page(
                'edit.php?post_type=pauple_helpie',
                $page_title,
                $page_title,
                'manage_options',
                'onboarding',
                array($this, 'render_view')
            );
        }

        public function render_view()
        {
            $view = new \Helpie\Features\Components\Onboarding\View($this->args);
            echo $view->get();
        }

        public function get_demos_categories()
        {
            return $this->args['demos'];
        }

        public function run_importer()
        {
            $args = [];

            if (isset($_POST['items']) && !empty($_POST['items'])) {
                $args['items'] = $_POST['items'];
            }
            if (isset($_POST['demo']) && !empty($_POST['demo'])) {
                $args['demo'] = $_POST['demo'];
            }
            if (isset($_POST['page']) && !empty($_POST['page'])) {
                $args['page'] = $_POST['page'];
            }

            $imported = $this->imports->run_import($args);

            if (isset($imported) && !empty($imported)) {
                $this->model->set_page_info($args);
            }

            return $imported;
        }
    }
}
