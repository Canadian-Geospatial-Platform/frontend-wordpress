<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Utils\Email')) {
    class Email
    {
        public function __construct()
        {
            add_action('helpie_create_new_ticket_email_notification', array($this, 'send_new_ticket_email_notification'), 10, 3);
            add_action('helpie_new_message_email_notification', array($this, 'send_new_message_email_notification'), 10, 3);
        }

        public function send_new_ticket_email_notification($post_id, $ticket_customer_id, $ticket_agent_id)
        {
            error_log('send_email called');

            if (isset($ticket_customer_id) && !empty($ticket_customer_id)) {
                $this->send_email_to_user($post_id, $ticket_customer_id); // Send email to Customer
            }

            if (isset($ticket_agent_id) && !empty($ticket_agent_id)) {
                $this->send_email_to_user($post_id, $ticket_agent_id); // Send email to Agent
            }

        }

        protected function send_email_to_user($post_id, $user_id)
        {
            $post = get_post($post_id);

            $title = $post->post_title;
            $content = $post->post_content;
            $permalink = get_post_permalink($post_id);

            $user_wp_obj = get_userdata($user_id);
            $to_email = $user_wp_obj->user_email;
            $user_display_name = $user_wp_obj->display_name;

            error_log('user_display_name: ' . $user_display_name);

            $headers[] = 'From: Pauple Helpie <support@pauple.com>';
            $headers[] = 'Cc: ' . $user_display_name . ' <' . $to_email . '>';
            $headers[] = 'Cc: ' . $to_email; // note you can just use a simple email address

            $subject = "New Ticket: " . $title;
            $message = "<p>" . $subject . "</p>";
            $message .= $content;
            $message .= "<p>See your ticket here: <a href='" . $permalink . "'>#" . $post_id . "</a>";

            add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
            wp_mail($to_email, $subject, $message, $headers);
        }

        public function send_new_message_email_notification($post_id, $ticket_customer_id, $ticket_agent_id)
        {
            error_log('send_new_message_email_notification called');
            $this->send_new_message_email_to_user($post_id, $ticket_customer_id); // Send email to Customer
            $this->send_new_message_email_to_user($post_id, $ticket_agent_id); // Send email to Agent
        }

        protected function send_new_message_email_to_user($post_id, $user_id)
        {
            $post = get_post($post_id);

            $title = $post->post_title;
            $content = $post->post_content;
            $permalink = get_post_permalink($post_id);

            $user_wp_obj = get_userdata($user_id);
            if (isset($user_wp_obj) && !empty($user_wp_obj)) {
                $to_email = $user_wp_obj->user_email;
                $user_display_name = $user_wp_obj->display_name;

                error_log('user_display_name: ' . $user_display_name);
                error_log('to_email: ' . $to_email);

                $headers[] = 'From: Pauple Helpie <support@pauple.com>';
                $headers[] = 'Cc: ' . $user_display_name . ' <' . $to_email . '>';
                $headers[] = 'Cc: ' . $to_email; // note you can just use a simple email address

                $subject = "New Responses: " . $title;
                $message = "<p>" . $subject . "</p>";
                $message .= $content;
                $message .= "<p>See your ticket here: <a href='" . $permalink . "'>#" . $post_id . "</a>";

                add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                wp_mail($to_email, $subject, $message, $headers);
            }

        }
    } // END CLASS
}