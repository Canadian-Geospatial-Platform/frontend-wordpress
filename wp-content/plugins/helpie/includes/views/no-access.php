<?php if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly
echo "You DO NOT have access. Login to get access: <a class='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";