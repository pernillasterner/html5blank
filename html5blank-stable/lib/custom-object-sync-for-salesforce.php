<?php

/* Object sync for Salesforce hooks */

// Modify Wordpress object to save
function change_pull_params( $params, $mapping, $object, $sf_sync_trigger, $use_soap, $is_new ) {
  // Save posts from SF as published instead of default state draft
  $params['post_status'] = array(
    'value' => 'publish',
    'method_modify' => 'wp_update_post',
    'method_read' => 'get_posts'
  );

  if ($mapping['salesforce_object'] === 'GW_Volunteers__Volunteer_Shift__c') {
    // Set volunteer shift start dates to correct datetime format ('Y-m-d H:i:s') so that WP can read and query them correctly.
    $start_date_volunteer = '';

    if (isset($params['sf_start_date_volunteer']) && !empty($object['GW_Volunteers__Start_Date_Time__c'])) {
      $start_date_volunteer = format_datetime($object['GW_Volunteers__Start_Date_Time__c']);
      $params['sf_start_date_volunteer']['value'] = $start_date_volunteer;
    }

    // Format teacher's start date or default to volunteer's start date if unset.
    if (!empty($object['BM_Klass_Start_Date_Time__c']) || !empty($start_date_volunteer)) {
      $start_date_teacher = !empty($object['BM_Klass_Start_Date_Time__c']) ? format_datetime($object['BM_Klass_Start_Date_Time__c']) : $start_date_volunteer;

      if (isset($params['sf_start_date_teacher'])) {
        $params['sf_start_date_teacher']['value'] = $start_date_teacher;
      } else {
        $params['sf_start_date_teacher'] = array(
          'value' => $start_date_teacher,
          'method_modify' => 'update_post_meta_acf',
          'method_read' => 'get_post_meta'
        );
      }
    }

    if (isset($params['sf_associated_shift_date']) && !empty($object['BM_Associerat_Programtillf_lle_Date__c'])) {
      $params['sf_associated_shift_date']['value'] = format_datetime($object['BM_Associerat_Programtillf_lle_Date__c']);
    }

    // Default empty record type value to empty string for correct query results.
    // We are using meta value compare "!=" or "=" in custom-rest-endpoints.php and it does not work when value is null. Must be set to something.
    if (isset($params['sf_record_type_id']) && !$object['RecordTypeId']) {
      $params['sf_record_type_id']['value'] = '';
    }
  }

  // If syncing users (SF Contact) set WP role depending on the RecordTypeId.
  if ($mapping['salesforce_object'] === 'Contact') {
    if (!empty($object['RecordTypeId'])) {
      $role = get_role_by_sf_record_type_id($object['RecordTypeId']);

      if ($role) {
        $params['role'] = array(
          'value' => $role,
          'method_modify' => 'wp_update_user'
        );
      }
    }
  }

  // When updating ACF fields, use ACF's method update_field() to make sure the value is set correctly.
  foreach ($params as $param => $p) {
    if (isset($p['method_modify'])) {
      $method_modify = $p['method_modify'];

      if (strpos($param, 'sf_') === 0) {
        if ($method_modify === 'update_user_meta' || $method_modify === 'add_user_meta') {
          $params[$param]['method_modify'] = 'update_user_meta_acf';
        } else if ($method_modify === 'update_post_meta' || $method_modify === 'add_post_meta') {
          $params[$param]['method_modify'] = 'update_post_meta_acf';
        }
      }
    }
  }

  return $params;
}
add_filter( 'object_sync_for_salesforce_pull_params_modify', 'change_pull_params', 10, 6 );

function update_user_meta_acf($post_id, $meta_key, $meta_value) {
  return update_field($meta_key, $meta_value, "user_$post_id");
}

function update_post_meta_acf($post_id, $meta_key, $meta_value) {
  return update_field($meta_key, $meta_value, $post_id);
}

/**
 * Find WP role slug by SF record type id.
 * @param  string $record_type_id
 * @return string - Role slug on success, empty string on error
 */
function get_role_by_sf_record_type_id($record_type_id) {
  $record_types = get_record_types_for_object('Contact');

  // returns wp_send_json_error with success=false if error, therefor check that 'success' is not set
  if (!empty($record_types) && is_array($record_types) && !isset($record_types['success'])) {
    $role_name = array_search($record_type_id, $record_types);

    if ($role_name) {
      return find_role_by_name($role_name);
    }
  }

  return '';
}

/**
 * Add object mapping for Object_Sync_Salesforce plugin
 * @param array $object_map - array(
 *   'wordpress_id' - this is the ID of the item that should be mapped from WordPress. So it might be a user, a post, a custom object type, whatever.
 *   'salesforce_id' - this is the Salesforce ID value. It is case sensitive.
 *   'wordpress_object' - this is the WordPress object type's name. Not the label that allows spacing, but the name. So user, post, etc.
 * )
 * @return int/boolean - if fail: false, if success: int for number of rows affected
 */
function add_object_sync_for_salesforce_object_map( $object_map ) {
  if ( empty($object_map) || !isset($object_map['wordpress_id']) || !isset($object_map['salesforce_id']) || !isset($object_map['wordpress_object']) ) {
    return false;
  }

  global $wpdb;

  $table_name = 'wp_object_sync_sf_object_map';

  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

  if ( $wpdb->get_var( $query ) != $table_name ) {
    return false;
  }

  $query = "INSERT INTO $table_name (wordpress_id, salesforce_id, wordpress_object) VALUES ";
  $query .= $wpdb->prepare( "(%d, %s, %s)", $object_map['wordpress_id'], $object_map['salesforce_id'], $object_map['wordpress_object'] );
  $query .= 'ON DUPLICATE KEY UPDATE wordpress_id = VALUES(wordpress_id), salesforce_id = VALUES(salesforce_id), wordpress_object = VALUES(wordpress_object)';

  $result = $wpdb->query( $query );

  return $result;
}
/**
 * Delete object mapping for Object_Sync_Salesforce plugin
 * @param array $object_map - WHERE clause to find the row to delete. Ex: array(
 *   'wordpress_id' - this is the ID of the item that should be mapped from WordPress. So it might be a user, a post, a custom object type, whatever.
 *   'salesforce_id' - this is the Salesforce ID value. It is case sensitive.
 *   'wordpress_object' - this is the WordPress object type's name. Not the label that allows spacing, but the name. So user, post, etc.
 * )
 * @return int/boolean - if fail: false, if success: int for number of rows affected
 */
function delete_object_sync_for_salesforce_object_map($object_map) {
  global $wpdb;

  $table_name = 'wp_object_sync_sf_object_map';

  $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

  if ( $wpdb->get_var( $query ) != $table_name ) {
    return false;
  }

  return $wpdb->delete( $table_name, $object_map, array('%d', '%s', '%s') );
}
