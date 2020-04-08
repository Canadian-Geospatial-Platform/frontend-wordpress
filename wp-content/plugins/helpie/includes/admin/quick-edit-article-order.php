<?php

namespace Helpie\Includes\Admin;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class PAUPLE_HELPIE_ARTICLE_ORDERING
{
    public static function add_new_columns($columns)
    {
        $new_columns = array(
            'order_in_cat' => __('Order in Category', 'pauple-helpie'),
        );

        return array_merge($columns, $new_columns);
    }

    public static function display_custom_quickedit_pauple_helpie($column_name, $post_type)
    {
        static $printNonce = true;
        if ($printNonce) {
            $printNonce = false;
            wp_nonce_field(plugin_basename(__FILE__), 'pauple_helpie_edit_nonce');
        }?>
<fieldset class="inline-edit-col-right inline-edit-book">
    <div class="inline-edit-col column-<?php echo $column_name; ?>">
        <label class="inline-edit-group">
            <?php
switch ($column_name) {
            case 'order_in_cat':

                ?><span class="title">Order in Category</span><input name="pauple_helpie_order_in_cat" /><?php
break;

        }?>
        </label>
    </div>
</fieldset>
<?php

    }

    public static function save_pauple_helpie_meta($post_id)
    {
        /* in production code, $slug should be set only once in the plugin,
        preferably as a class property, rather than in each function that needs it.
         */

        $slug = 'pauple_helpie';
        if ($slug !== $_POST['post_type']) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        $_POST += array("{$slug}_edit_nonce" => '');
        if (!wp_verify_nonce($_POST["{$slug}_edit_nonce"],
            plugin_basename(__FILE__))) {
            return;
        }

        if (isset($_REQUEST['order_in_cat'])) {
            update_post_meta($post_id, 'order_in_cat', $_REQUEST['order_in_cat']);
        }
    }
}

// add_action( 'quick_edit_custom_box', 'display_custom_quickedit_book', 10, 2 );
add_filter('manage_pauple_helpie_posts_columns', array('Helpie\Includes\Admin\PAUPLE_HELPIE_ARTICLE_ORDERING', 'add_new_columns'));
add_action('quick_edit_custom_box', array('Helpie\Includes\Admin\PAUPLE_HELPIE_ARTICLE_ORDERING', 'display_custom_quickedit_pauple_helpie'), 10, 2);
add_action('save_post', array('Helpie\Includes\Admin\PAUPLE_HELPIE_ARTICLE_ORDERING', 'save_pauple_helpie_meta'));

?>