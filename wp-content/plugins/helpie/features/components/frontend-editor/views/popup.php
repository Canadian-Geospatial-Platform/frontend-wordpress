<?php

namespace Helpie\Features\Components\Frontend_Editor\Views;

if (!class_exists('\Helpie\Features\Components\Frontend_Editor\Views\Popup')) {
    class Popup
    {
        public function get_view($props)
        {
            $html = "<div class='pauple_helpie " . $props['type'] . " ui modal longer'>";
            $html .= "<div class='header'><i class='fa fa-gift' aria-hidden='true'></i><br><span class='text'>" . $props['title'] . "</span></div>";

            $html .= "<div class='scrolling item-content' data-post-id='" . $props['post_id'] . "'>";
            $html .= "<div class='wrapper'>";

            if (isset($props['content']) && !empty($props['content'])) {
                $html .= $props['content'];
            }

            $html .= "</div>";
            $html .= "<div class='clear'></div>";
            $html .= "</div>";

            $html .= "<div class='actions'>";
            $html .= "<div class='ui black deny button'>Cancel</div>";
            $html .= "<div class='ui positive right labeled icon button'>";
            $html .= "Publish<i class='checkmark icon'></i></div>";
            $html .= "</div>";

            $html .= "<div class='clear'></div>";
            $html .= "</div>";

            return $html;
        }

        public function render_delete_popup()
        {
            $publishing_service = new \Helpie\Features\Services\Publishing\Publishing();
            $is_admin = current_user_can('administrator');
            $post_id = get_the_ID();
            $capability = $publishing_service->get_current_user_publishing_capability($post_id);
            $article_id = get_the_ID();

            if ($is_admin || $capability['can_approve']) {

                $delete = ($is_admin) ? __("Delete", "pauple-helpie") : __("Trash", "pauple-helpie");
                $html = "<div class='ui dimmer modals page' style='display: none;'>";
                $html .= " <div id='helpie-remove-info-modal' class='pauple_helpie ui modal tiny' style='display: none;'>";
                $html .= " <div class='header'>Are you sure you want to " . $delete . " ?</div>";
                $html .= " <div class='actions'> ";
                $html .= " <div class='ui negative basic button remove-article'
                            data-revision-id=" . $article_id . "
                            data-remove-option='trash'>";
                $html .= __('Trash', 'pauple-helpie') . "</div>";
                if ($is_admin) {
                    $html .= " <div class='negative ui button remove-article'
                    data-revision-id=" . $article_id . "
                    data-remove-option='delete'>";
                    $html .= __('Delete', 'pauple-helpie') . "</div>";
                }
                $html .= " <div class='ui cancel button'>Cancel</div>";
                $html .= " </div>";
                $html .= " <div class='clear'></div>";
                $html .= " </div>";
                $html .= " </div>";

                echo $html;
            }
        }

        // public function render_delete_popup()
        // {
        //     $html = "<div class='pauple_helpie delete-article ui modal'>";
        //     $html .= "<div class='header'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i><br>Trash Article</div>";

        //     $html .= "<div class='scrolling item-content' data-post-id='".get_the_ID()."'>";
        //     $html .= "<div class='wrapper'>";
        //     echo $html;

        //     $html = "Are you sure you want to trash this article?";
        //     echo $html;

        //     $html = "</div>";
        //     $html .= "<div class='clear'></div>";
        //     $html .= "</div>";

        //     $html .= "<div class='actions'>";
        //     $html .= "<div class='ui black deny button'>Cancel</div>";
        //     $html .= "<div class='ui positive right labeled icon button'>";
        //     $html .= "Trash<i class='remove icon'></i></div>";
        //     $html .= "</div>";

        //     $html .= "<div class='clear'></div>";
        //     $html .= "</div>";

        //     echo $html;
        // }
    } // END CLASS
}
