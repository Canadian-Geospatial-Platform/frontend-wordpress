<?php

// the function
function get_sorter_terms()
{

    if (!is_admin()) {
        return;
    } // let's avoid to run this query in front end.

    $enabled = array();
    $disabled = array();

    $args = array(
        "taxonomy" => 'helpdesk_category',
        "parent" => 0,
    );

    remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
    $terms = get_terms($args);
    add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter

    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $key = (string) "term-id_" . $term->term_id;
            $enabled[$key] = $term->name;
        }
    }

    return array(
        'enabled' => $enabled,
        'disabled' => $disabled,
    );
}

function get_dynamic_caps_roles()
{
    // error_log('get_dynamic_caps_roles');
    global $wp_roles;

    $all_roles = $wp_roles->roles;

    // $all_roles = \get_editable_roles();
    // $editable_roles = apply_filters('editable_roles', $all_roles);
    $roles = array();

    foreach ($all_roles as $key => $role) {
        $roles[$key] = $role['name'];
    }

    $roles['guest'] = 'Guest';
    unset($roles['administrator']);
    // error_log('$roles : ' . print_r($roles, true));
    return $roles;

    // return [
    //     'roles' => 'Hello'
    // ];
}