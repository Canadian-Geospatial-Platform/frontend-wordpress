<?php

namespace Helpie\Includes;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! class_exists('\Helpie\Includes\PAUPLE_HELPIE_USER_CAPABILITIES')) :
    class PAUPLE_HELPIE_USER_CAPABILITIES
    {
        public function __construct()
        {
            add_action('admin_init', array( $this, 'add_role_caps' ));
        }

        public function add_role_caps()
        {
            // We use 'default_review_roles' to set default capabilities for main roles
            $kb_user = new \Helpie\Features\Domain\Models\Kb_User();
            $roles = $kb_user->get_default_review_roles();

            foreach ($roles as $the_role) {
                $role = get_role($the_role);

                $caps = array(
                    'read_pauple_helpie_article',
                    'read_private_pauple_helpie_articles',
                    'edit_pauple_helpie_article',
                    'edit_pauple_helpie_articles',
                    'edit_others_pauple_helpie_articles',
                    'edit_published_pauple_helpie_articles',
                    'publish_pauple_helpie_articles',
                    'manage_pauple_helpie_article',
                    'delete_others_pauple_helpie_articles',
                    'delete_private_pauple_helpie_articles',
                    'delete_published_pauple_helpie_articles',
                );

                foreach ($caps as $cap) {
                    $role->add_cap($cap);
                }
            }
        }
    }

    new PAUPLE_HELPIE_USER_CAPABILITIES();

endif;
