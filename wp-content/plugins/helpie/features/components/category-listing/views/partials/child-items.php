<?php
namespace Helpie\Features\Components\Category_Listing\Views\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly



if (!class_exists('\Helpie\Features\Components\Category_Listing\Views\Partials\Child_Items')) {
    class Child_Items
    {
        public function get_view($props)
        {   
            $href = ($props['link'])?'href = "'.$props['link'].'"': '';

            // HTML
            $li_html = $this->get_li_tag_html($props);

            if (!$props['is_password_permitted']) {
                $li_html .= "<i class='ui lock icon' aria-hidden='true'></i>";
            }

            $li_html .= "<a ".$href." >".ucfirst($props['title'])."</a>";
            $li_html .= $this->get_tags_html($props);
            $li_html .= '</li>';

            return $li_html;
        }

        protected function get_li_tag_html($props)
        {
            $li_id = "li-id-".$props['id'];            
            
            // For Sub Category
            $classes = isset($props['taxonomy']) ? "term-id-".$props['id'] : "term-id-".$props['term_id'];
            $classes .= ' '.$props['lock_class'];            

            $article = (!isset($props['taxonomy'])) ? 'data-article = "true"' : '';

            return "<li id='".$li_id."' ".$article." data-post-id='".$props['id']."' data-term-id='".$props['term_id']."' class='".$classes."'>";
        }

        protected function get_tags_html($props)
        {
            $tags_html = '';

            if (isset($props['permitted_added_tag']) && !empty($props['permitted_added_tag'])) {
                $tags_html .= "<span class='added_tag'>".$props['permitted_added_tag'].'</span>';
            }

            if (isset($props['permitted_updated_tag']) && !empty($props['permitted_updated_tag'])) {
                $tags_html .= "<span class='updated_tag'>".$props['permitted_updated_tag'].'</span>';
            }

            return $tags_html;
        }
    } // END CLASS
}
