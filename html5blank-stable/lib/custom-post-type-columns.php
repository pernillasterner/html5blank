<?php
/* VOLUNTEER SHIFT */

// Add custom fields to sort columns in admin
function add_volunteer_shift_admin_column($column) {
    $column['sf_start_date_volunteer'] = 'Startdatum';
    $column['sf_id'] = 'Externt ID';
    $column['sf_program_center'] = 'Programcenter';

    return $column;
}
add_filter('manage_volunteer_shift_posts_columns', 'add_volunteer_shift_admin_column');

function add_volunteer_shift_admin_column_show_value($column_name, $post_ID) {
    if ($column_name == 'sf_id') {
        $sf_id = get_field( 'sf_id', $post_ID );
        echo $sf_id;
    } else if ($column_name == 'sf_start_date_volunteer') {
        $sf_start_date_volunteer = get_field( 'sf_start_date_volunteer', $post_ID );
        $sf_start_date_volunteer = date( "d/m Y", strtotime($sf_start_date_volunteer));
        echo $sf_start_date_volunteer;
    } else if ($column_name == 'sf_program_center') {
        $sf_program_center = get_field( 'sf_program_center', $post_ID );
        echo $sf_program_center;
    }
}
add_action('manage_volunteer_shift_posts_custom_column', 'add_volunteer_shift_admin_column_show_value', 10, 2);

add_filter( 'manage_edit-volunteer_shift_sortable_columns', 'volunteer_shift_column' );
function volunteer_shift_column( $columns ) {
    $columns['sf_start_date_volunteer'] = 'sf_start_date_volunteer';
    $columns['sf_program_center'] = 'sf_program_center';

    return $columns;
}

function volunteer_shift_column_orderby( $query ) {
    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');

    if ( 'sf_start_date_volunteer' == $orderby ) {
        $query->set('meta_key', 'sf_start_date_volunteer');
        $query->set('orderby', 'meta_value');
    } else if ( 'sf_program_center' == $orderby ) {
        $query->set('meta_key', 'sf_program_center');
        $query->set('orderby', 'meta_value');
    }
}
add_filter( 'pre_get_posts', 'volunteer_shift_column_orderby' );

/* CONTACTS */
// Add custom fields to sort columns in admin
function add_contacts_admin_column($column) {
    $column['sf_id'] = 'Externt ID';
    $column['sf_type_of_volunteer'] = 'Volontärtyp';

    return $column;
}
add_filter('manage_contacts_posts_columns', 'add_contacts_admin_column');

function add_contacts_admin_column_show_value($column_name, $post_ID) {
    if ($column_name == 'sf_id') {
        $sf_id = get_field( 'sf_id', $post_ID );
        echo $sf_id;
    } else if ($column_name == 'sf_type_of_volunteer') {
        $sf_type_of_volunteer = get_field( 'sf_type_of_volunteer', $post_ID );
        echo $sf_type_of_volunteer;
    }
}
add_action('manage_contacts_posts_custom_column', 'add_contacts_admin_column_show_value', 10, 2);

add_filter( 'manage_edit-contacts_sortable_columns', 'contacts_column' );

function contacts_column( $columns ) {
    $columns['sf_type_of_volunteer'] = 'sf_type_of_volunteer';

    return $columns;
}

function contacts_column_orderby( $query ) {
    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');

    if ( 'sf_type_of_volunteer' == $orderby ) {
        $query->set('meta_key', 'sf_type_of_volunteer');
        $query->set('orderby', 'meta_value');
    }
}
add_filter( 'pre_get_posts', 'contacts_column_orderby' );
