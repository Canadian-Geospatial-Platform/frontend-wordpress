<?php

namespace Helpie\Vendor_Custom;

class PAUPLE_RADIO_TAXONOMY
{
    private $taxonomy; //Slug of taxonomy
    private $post_type; //Post type for meta-box

    public function __construct($taxonomy, $post_type)
    {
        $this->taxonomy = $taxonomy;
        $this->post_type = $post_type;
    }
    public function load()
    {
        add_action('admin_menu', array($this, 'remove_meta_box'));
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
    }

    //Remove taxonomy meta box
    public function remove_meta_box()
    {
        //The taxonomy metabox ID. This is different for non-hierarchical taxonomies
        $tax_mb_id = $this->taxonomy.'div';
        remove_meta_box($tax_mb_id, $this->post_type, 'normal');
    }

    //Add new taxonomy meta box
    public function add_meta_box()
    {
        add_meta_box($this->taxonomy, 'My taxonomy', array($this, 'metabox_inner'), $this->post_type, 'side', 'core');
    }

    //Callback to set up metabox
    public function metabox_inner($post)
    {
        //Get taxonomy and terms
        $taxonomy = $this->taxonomy;
        $tax = get_taxonomy($taxonomy);
        $name = 'tax_input['.$taxonomy.']';
        $terms = get_terms($taxonomy, array('hide_empty' => 0));

        $postterms = get_the_terms($post->ID, $taxonomy);
        $current = ($postterms ? array_pop($postterms) : false);
        $current = ($current ? $current->term_id : 0);

        $metabox_html = $this->get_metabox_html($taxonomy, $terms, $current, $name);

        echo $metabox_html;
    }

    public function get_metabox_html($taxonomy, $terms, $current, $name)
    {
        $metabox_html = "<div id='taxonomy-".$taxonomy."' class='categorydiv'>";
        $metabox_html .= "<div id='".$taxonomy."-all' class='tabs-panel'>";
        $metabox_html .= "<div id='".$taxonomy."-all' class='tabs-panel'>";
        $metabox_html .= "<ul id='".$taxonomy."checklist' class='list:".$taxonomy." categorychecklist form-no-clear'>";
        foreach ($terms as $term) {
            $id = "id='in-event-category-$term->term_id'";
            $metabox_html .= "<li id='event-category-$taxonomy-$term->term_id'><label class='selectit'>";
            $metabox_html .= "<input type='radio' {$id} name='{$name}'".checked($current, $term->term_id, false)."value='$term->term_id' />$term->name<br />";
            $metabox_html .= '</label></li>';
        }
        $metabox_html .= '</ul></div></div></div>';

        return $metabox_html;
    }
}
