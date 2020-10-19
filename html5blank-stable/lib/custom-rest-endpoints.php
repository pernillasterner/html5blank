<?php
/**
 * Register endpoints
 */
add_action( 'rest_api_init', function () {
  register_rest_route( 'custom/v1', '/volunteer_shifts', array(
    'methods' => 'GET',
    'callback' => 'get_shifts',
    'args' => array(
      'start' => array(
        'required' => true,
        'validate_callback' => 'is_valid_date',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'end' => array(
        'required' => true,
        'validate_callback' => 'is_valid_date',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'training' => array()
    ),
    'permission_callback' => 'is_user_permitted',
  ) );

  register_rest_route( 'custom/v1', '/volunteer_shift', array(
    'methods' => 'GET',
    'callback' => 'get_shift',
    'args' => array(
      'sf_id' => array(
        'required' => true,
        'sanitize_callback' => 'sanitize_text_field'
      ),
    ),
    'permission_callback' => 'is_user_permitted',
  ) );

  register_rest_route( 'custom/v1', '/book_shift', array(
    array(
      'methods' => 'POST',
      'callback' => 'create_volunteer_booking',
      'args' => array(
        'sf_id' => array(
          'required' => true,
          'validate_callback' => 'is_not_empty',
          'sanitize_callback' => 'sanitize_text_field'
        ),
      ),
      'permission_callback' => 'is_user_permitted'
    ),
    array(
      'methods' => 'DELETE',
      'callback' => 'delete_volunteer_booking',
      'args' => array(
        'sf_id' => array(
          'required' => true,
          'validate_callback' => 'is_not_empty',
          'sanitize_callback' => 'sanitize_text_field'
        ),
        'wp_id' => array(
          'required' => true,
          'validate_callback' => 'is_not_empty',
          'sanitize_callback' => 'sanitize_text_field'
        ),
      ),
      'permission_callback' => 'is_user_permitted'
    )
  ) );

  register_rest_route( 'custom/v1', '/book_shift_teacher', array(
    'methods' => 'POST',
    'callback' => 'create_teacher_booking',
    'args' => array(
      'sf_id' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'wp_id' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'BM_Klass_Arskurs__c' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'BM_Klass_Namn__c' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'BM_Klass_Antal_Studenter__c' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
    ),
    'permission_callback' => 'is_user_permitted',
  ) );

  register_rest_route( 'custom/v1', '/unbook_shift_teacher', array(
    'methods' => 'POST',
    'callback' => 'delete_teacher_booking',
    'args' => array(
      'sf_id' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'wp_id' => array(
        'required' => true,
        'validate_callback' => 'is_not_empty',
        'sanitize_callback' => 'sanitize_text_field'
      ),
    ),
    'permission_callback' => 'is_user_permitted',
  ) );

  // Route for registering volunteers and teachers
  // Uses custom validation to be able to return custom error messages and not WP defaults.
  register_rest_route( 'custom/v1', '/register_user', array(
    'methods' => 'POST',
    'callback' => 'register_user',
    'args' => array(
      'FirstName' => array(
        'is_required' => true,
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'LastName' => array(
        'is_required' => true,
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'Email' => array(
        'is_required' => true,
        'validate_func' => 'is_valid_unique_user_email',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'Phone' => array(
        'is_required' => true,
        'validate_func' => 'is_numeric',
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'Personnummer__c' => array(
        'is_required' => function($request) {
          return $request['role'] === 'volunteer';
        },
        'validate_func' => 'is_numeric',
        'max_length' => 6,
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'samtyckeGDPRContact__c' => array(
        'is_required' => true,
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'program_center' => array(
        'is_required' => true,
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'npsp__Primary_Affiliation__c' => array(
        'is_required' => function($request) {
          return $request['role'] === 'teacher';
        },
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'role' => array(
        'sanitize_callback' => 'sanitize_text_field'
      ),
      'g-recaptcha-response' => array(
        'is_required' => true,
        'validate_func' => 'validate_recaptcha',
        'sanitize_callback' => 'sanitize_text_field'
      )
    ),
  ));
});

/**
 * Custom endpoint for getting shifts at certain time periods
 * Expects '_wpnonce', 'start' and 'end' as query params with date formatted Y-m-d
 * Example uri: GET /wp-json/custom/v1/volunteer_shift?_wpnonce=0383d5f3c8&start=2019-01-27&end=2019-03-10
 *
 * @param WP_REST_Request $request
 * @return array(WP_Post)
 */
function get_shifts(WP_REST_Request $request) {

  $user = wp_get_current_user();
  if (!$user->exists()) {
    wp_send_json_error(NULL, 401);
  }

  $current_user_role = $user->roles[0];
  $user_role = override_admin_role($current_user_role); // for testing when logged in as admin
  $start_date = $request['start'];

  // if start date is before current date, set current date. should only show events in future
  if (days_until($start_date) < 0) {
    $start_date = date('Y-m-d');
  }

  $record_types = get_record_types_for_object('GW_Volunteers__Volunteer_Shift__c');
  $training_record_type_id = '';

  if (!empty($record_types) && isset($record_types['Grundutbildning'])) {
    $training_record_type_id = $record_types['Grundutbildning'];
  } else {
    return wp_send_json_error($error_handler->get_error('could_not_find', "record type ID för grundutbildning"));
  }

  $is_booking_training = $request['training'];

  $meta_query = array(
    // Select shifts between the given date params (add time stamp for matching start_date format)
    array(
      'key'        => 'sf_start_date_'.$user_role,
      'compare'    => 'BETWEEN',
      'value'      => array( ($start_date  . ' 00:00:00'), ($request['end'] . ' 23:59:59') ),
      'type'       => 'DATETIME'
    ),
    // Show only record type "Grundutbildning" if training is set as query param, otherwise show everything but
    array(
      'key'        => 'sf_record_type_id',
      'compare'    => ($is_booking_training ? '=' : '!='),
      'value'      => $training_record_type_id,
    ),

  );

  // Show only shifts where a teacher is signed up if role is volunteer and is not booking "Grundutbildning"
  // if (!$is_booking_training && $user_role === 'volunteer') {
  //   array_push($meta_query, array(
  //     'key'        => 'sf_teacher_id',
  //     'compare'    => '!=',
  //     'value'      => ''
  //   ));
  // }

  $posts = get_posts(array(
    'numberposts'  => -1,
    'post_type'    => 'volunteer_shift',
    'meta_query'  => $meta_query
  ));

  // Add advanced custom fields to result
  $posts = get_acf_fields($posts, $user_role);

  foreach ($posts as $post) {

    if($user_role == "teacher") {
      $sf_post_content = !empty($post->acf['sf_description_teacher']) ? $post->acf['sf_description_teacher'] : '';
    } else {
      $sf_post_content = $post->post_content;
    }

    // If teacher - Hide 'Kreativ onsdag' & posts with a teacher id assigned.
    if ($user_role == 'teacher') {
      if ($post->title == 'Kreativ onsdag' || !empty($post->acf['sf_teacher_id'])) {
        $post->start = '';
        $post->end = '';
      } else {
        $post->post_content_clean = $sf_post_content;
      }
    }

    if ($user_role == 'volunteer' && !$is_booking_training ) {
      if( !empty($post->acf['sf_teacher_id']) || $post->title == 'Kreativ onsdag') {
        $post->post_content_clean = $sf_post_content;
      } else {
        $post->start = '';
        $post->end = '';
      }
    }
  }

  return rest_ensure_response($posts);
}

function get_shift(WP_REST_Request $request) {
  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $sf_id = $request['sf_id'];

  // get shift from db to make sure it exists
  $volunteer_shift = get_shift_by_sf_id($sf_id);

  if ($volunteer_shift) {
    $volunteer_shift = get_acf_fields($volunteer_shift, $user->roles[0]);
  }

  return $volunteer_shift;
}

function get_acf_fields($posts, $user_role) {
  $user_role = override_admin_role($user_role); // for testing when logged in as admin
  $user_is_volunteer = $user_role === 'volunteer';

  // Add advanced custom fields to result
  foreach ($posts as $key => $post) {
    $acf_fields = get_fields($post->ID);

    $acf_fields['sf_id'] = get_field('sf_id', $post->ID);

    if ($acf_fields && isset($acf_fields['sf_id']) && isset($acf_fields['sf_start_date_'.$user_role]) && isset($acf_fields['sf_program_center'])) {
      // Fullcalendar.js expects fields: 'start', 'end' and 'title' when rendering events in calendar
      $post->id = $acf_fields['sf_id'];
      $start_date = $acf_fields['sf_start_date_'.$user_role];
      $post->start = $start_date;
      $duration = !empty($acf_fields['sf_duration']) ? str_replace(',', '.', $acf_fields['sf_duration']) : 0; // get duration with dot as decimal separator (Swedish locale uses decimal which makes end time incorrect)
      $post->end = date('Y-m-d H:i', strtotime($start_date) + 60*60*$duration);
      $post->title = $post->post_title;
      $post->program_center_slug = sanitize_title($acf_fields['sf_program_center']); // add slug for program center for filter option

      // remove attributes to clear inline styles visible in modal
      $content = $user_is_volunteer ? $post->post_content : (isset($acf_fields['sf_description_teacher']) ? $acf_fields['sf_description_teacher'] : '');
      $post->post_content_clean = !empty($content) ? preg_replace('/ ([a-zA-Z]+)=("|\')(.*?)("|\')/','', $content) : '<em>Detta pass saknar beskrivning.</em>';
      $post->status = get_event_status($acf_fields, $start_date, $user_role);
      $post->backgroundColor = get_event_color($post->status);
      $post->textColor = $post->backgroundColor === '#e6e6e6' ? '#676666' : '#ffffff';
    } else {
      // if no acf fields saved, dont show in calendar
      $post->start = null;
      $post->end = null;
      $post->title = null;
    }

    // store all acf values in field used in frontend
    $post->acf = $acf_fields;
  }

  return $posts;
}

/* CREATE/DELETE TEACHER BOOKING */
function create_teacher_booking(WP_REST_Request $request) {
  global $error_handler;

  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $user_role = $user->roles[0];
  $user_role = override_admin_role($user_role); // for testing when logged in as admin

  if ($user_role !== 'teacher') {
    return wp_send_json_error($error_handler->get_error('must_be_teacher'), 500);
  }

  $user_sf_id = get_field('sf_id', 'user_'.$user->ID);

  if (!$user_sf_id) {
    return wp_send_json_error($error_handler->get_error('missing_user_sf_id'), 500);
  }

  // sanitize inputs
  $sanitize_params = $request->sanitize_params();
  if (!$sanitize_params) {
    return $sanitize_params;
  }

  $body_params = $request->get_body_params();

  $sf_id = $body_params['sf_id'];
  $wp_id = $body_params['wp_id'];
  unset($body_params['sf_id'], $body_params['wp_id']);

  $body_params['BM_Larare__c'] = $user_sf_id;

  $data = array(
    'object_type' => 'GW_Volunteers__Volunteer_Shift__c',
    'sf_id' => $sf_id,
    'params' => $body_params,
  );

  $salesforce_res = update_salesforce_object($data);

  if (!$salesforce_res || !$salesforce_res['data'] || !$salesforce_res['data']['success']) {
    return wp_send_json_error($salesforce_res, 500);
  }

  if ($wp_id) {
    return update_acf_fields(array(
      'sf_teacher_id' => $user_sf_id,
      'sf_class' => $body_params['BM_Klass_Arskurs__c'],
      'sf_class_name' => $body_params['BM_Klass_Namn__c'],
      'sf_student_count' => $body_params['BM_Klass_Antal_Studenter__c'],
    ), $wp_id);
  }

  return wp_send_json_error($error_handler->get_error('missing_shift_wp_id'), 500);
}

function delete_teacher_booking(WP_REST_Request $request) {
  global $error_handler;

  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $user_role = $user->roles[0];
  $user_role = override_admin_role($user_role); // for testing when logged in as admin

  if ($user_role !== 'teacher') {
    return wp_send_json_error($error_handler->get_error('must_be_teacher'), 500);
  }

  $user_sf_id = get_field('sf_id', 'user_'.$user->ID);

  if (!$user_sf_id) {
    return wp_send_json_error($error_handler->get_error('missing_user_sf_id'), 500);
  }

  $condition = array('BM_Larare__c' => $user_sf_id);
  $data = array(
    'object_type' => 'GW_Volunteers__Volunteer_Shift__c',
    'sf_id' => $request['sf_id'],
    'params' => array(
      'BM_Larare__c' => '',
      'BM_Klass_Namn__c' => '',
      'BM_Klass_Arskurs__c' => '',
      'BM_Klass_Antal_Studenter__c' => '',
    )
  );
  $salesforce_res = update_salesforce_object($data, $condition);

  if (!$salesforce_res || !isset($salesforce_res['data']) || !isset($salesforce_res['data']['success']) || !$salesforce_res['data']['success']) {
    return wp_send_json_error($salesforce_res, 500);
  }

  $wp_id = $request['wp_id'];
  if ($wp_id) {
    return update_acf_fields(array(
      'sf_teacher_id' => '',
      'sf_class' => '',
      'sf_class_name' => '',
      'sf_student_count' => '',
    ), $wp_id);
  }

  return wp_send_json_error($error_handler->get_error('missing_shift_wp_id'), 500);
}

/**
 * Update ACF fields of a Wordpress object.
 *
 * @param Array $data - array with key = fieldname, value = fieldvalue
 * @param String $wp_id - string with wordpress id
 *
 * @return WP_REST_Response/wp_send_json_error - rest response on success, wp_send_json_error on fail with error message
 */
function update_acf_fields($data, $wp_id) {
  global $error_handler;

  foreach ($data as $key => $value) {
    if ( !update_field( $key, $value, $wp_id ) ) {
      return wp_send_json_error($error_handler->get_error('could_not_update_wp_field', $key), 500);
    }
  }

  return rest_ensure_response($wp_id);
}

/* CREATE/DELETE VOLUNTEER BOOKING */

/**
 * Custom endpoint for creating a booking
 * Expects '_wpnonce', 'sf_id' (id of shift) as query params
 * POST /wp-json/custom/v1/book_shift
 *
 * @param WP_REST_Request $request
 * @return (int)post_id / (string)error message
 */
function create_volunteer_booking(WP_REST_Request $request) {
  global $error_handler;

  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $user_sf_id = get_field('sf_id', 'user_'.$user->ID);

  if (!$user_sf_id) {
    return wp_send_json_error($error_handler->get_error('missing_user_sf_id'), 500);
  }

  $sf_id = $request['sf_id'];

  // get shift from db to make sure it exists
  $volunteer_shifts = get_shift_by_sf_id($sf_id);

  if (!$volunteer_shifts) {
    return $volunteer_shifts;
  }

  $result = [];

  foreach ($volunteer_shifts as $key => $volunteer_shift) {
    $shift_wp_id = $volunteer_shift->ID;
    $shift_title = $volunteer_shift->post_title;

    $sf_program_id = get_field('sf_program_id', $shift_wp_id);
    if (empty($sf_program_id)) {
      return wp_send_json_error($error_handler->get_error('missing_shift_field', array($shift_wp_id, 'program ID', 'sf_program_id')), 500);
    }

    $sf_start_date = get_field('sf_start_date_volunteer', $shift_wp_id);
    if (empty($sf_start_date)) {
      return wp_send_json_error($error_handler->get_error('missing_shift_field', array($shift_wp_id, 'startdatum', 'sf_start_date_volunteer')), 500);
    }

    $sf_duration = get_field('sf_duration', $shift_wp_id) ?: 0;
    $sf_duration = str_replace(',', '.', $sf_duration); // convert decimal character to dot. Swedish locale defaults to comma which causes error response from SF.

    $sf_result = create_salesforce_object(
      array(
        'object_type' => 'GW_Volunteers__Volunteer_Hours__c',
        'params' => array(
          'GW_Volunteers__Contact__c' => $user_sf_id,
          'GW_Volunteers__Volunteer_Shift__c' => $sf_id,
          'GW_Volunteers__Volunteer_Job__c' => $sf_program_id,
          'GW_Volunteers__Start_Date__c' => date('Y-m-d', strtotime($sf_start_date)),
          'GW_Volunteers__Status__c' => 'Confirmed',
          'GW_Volunteers__Number_of_Volunteers__c' => 1,
          'GW_Volunteers__Hours_Worked__c' => $sf_duration
        ),
      ),
      // Check if already exists a booking by looking for a booking in SF with same shift and contact id.
      // Seems like we need to select those fields for correct results. If only selecting Id and we have another booking for a shift with same title, we get a result that says it's already booked.
      array(
        'query' => "SELECT Id,GW_Volunteers__Contact__c,GW_Volunteers__Volunteer_Shift__c FROM GW_Volunteers__Volunteer_Hours__c WHERE GW_Volunteers__Contact__c='$user_sf_id' AND GW_Volunteers__Volunteer_Shift__c='$sf_id'",
      )
    );

    // Check if the Salesforce request went OK (either booking existed in SF before or it was created), create the corresponding WP object.
    if ($sf_result && isset($sf_result['data']) && isset($sf_result['data']['id'])) {
      $sf_booking_id = $sf_result['data']['id'];

      // Check if booking does not already exist in WP
      $existing_wp_booking = get_user_booking_id_for_volunteer_shift($user_sf_id, $sf_booking_id);

      if (empty($existing_wp_booking)) {
        // Create a post with post type 'booked_shift'
        $wp_result = wp_insert_post(array(
          'post_title'   => $shift_title,
          'post_content' => '',
          'post_status'  => 'publish',
          'post_author'  => $user->ID,
          'post_type'    => 'booked_shift',
          'meta_input'   => array(
            'sf_id' => $sf_booking_id,
            'sf_contact_id' => $user_sf_id,
            'sf_program_id' => $sf_program_id,
            'sf_volunteer_shift' => $sf_id,
            'sf_start_date' => date('Y-m-d', strtotime($sf_start_date)),
            'sf_status' => 'Confirmed',
            'sf_number_of_volunteers' => 1,
            'sf_hours_worked' => $sf_duration
          ),
        ));

        if (!$wp_result) {
          return wp_send_json_error($error_handler->get_error('could_not_create_booking', $shift_wp_id), 500);
        }

        // Push to array of results
        array_push($result, $wp_result);
      } else {
        // Push to array of results
        array_push($result, $existing_wp_booking);
      }

      // Add object map for object sync for salesforce plugin
      $booking_id = !empty($existing_wp_booking) ? $existing_wp_booking : $wp_result;

      $object_map = add_object_sync_for_salesforce_object_map(array(
        'wordpress_id' => $booking_id,
        'salesforce_id' => $sf_booking_id,
        'wordpress_object' => 'booked_shift'
      ));

      if (!$object_map) {
        return wp_send_json_error($error_handler->get_error('could_not_create_object_map', $sf_booking_id, $booking_id), 500);
      }

      // Increase shift's volunteer count if booking did not exist in SF before (success will in that case be set to true)
      // This is just for user to immediatly see the updated value. The value will be synced again once WP does pull of SF objects.
      if (isset($sf_result['data']['success'])) {
        update_shifts_total_volunteers($shift_wp_id, 1);
      }
    } else {
      return wp_send_json_error($sf_result, 500);
    }
  }

  return rest_ensure_response($result);
}

/**
 * Custom endpoint for deleting a booking
 * Expects '_wpnonce', 'sf_id' (shift's salesforce id) and 'wp_id' (wordpress id of booking) as query params
 * DELETE /wp-json/custom/v1/book_shift
 *
 * @param WP_REST_Request $request
 * @return WP_Post or error message
 */
function delete_volunteer_booking(WP_REST_Request $request) {
  global $error_handler;

  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $user_sf_id = get_field('sf_id', 'user_'.$user->ID);

  if (!$user_sf_id) {
    return wp_send_json_error($error_handler->get_error('missing_user_sf_id'), 500);
  }

  $wp_id = $request['wp_id']; // booking's WP id
  $sf_id = get_field('sf_id', $wp_id); // booking's SF id
  if (empty($sf_id)) {
    return wp_send_json_error($error_handler->get_error('missing_booking_field', array($wp_id, 'SF ID')), 500);
  }

  $sf_result = delete_salesforce_object(
    array(
      'object_type' => 'GW_Volunteers__Volunteer_Hours__c',
      'sf_id' => $sf_id
    ),
    array(
      'GW_Volunteers__Contact__c' => $user_sf_id
    )
  );

  if ($sf_result && isset($sf_result['data']) && (isset($sf_result['data']['success']) && $sf_result['data']['success'])) {
    $wp_result = wp_trash_post($wp_id);

    if (!$wp_result) {
      return wp_send_json_error($error_handler->get_error('could_not_delete_booking', array($wp_id, $sf_id)), 500);
    }

    // Decrease shift's volunteer count
    // This is just for user to immediatly see the updated value. The value will be synced again once WP does pull of SF objects.
    $sf_shift_id = $request['sf_id'];
    $volunteer_shifts = get_shift_by_sf_id($sf_shift_id);

    if (!empty($volunteer_shifts)) {
      update_shifts_total_volunteers($volunteer_shifts[0]->ID, -1);
    }

    // Remove object map for object sync for salesforce plugin
    delete_object_sync_for_salesforce_object_map(array(
      'wordpress_id' => $wp_id,
      'salesforce_id' => $sf_id,
      'wordpress_object' => 'booked_shift'
    ));

    return rest_ensure_response($wp_result);
  }

  return wp_send_json_error($sf_result, 500);
}

/* REGISTER USER */

/**
 * Create a user
 * @param  WP_REST_Request $request
 * @return [type]                   [description]
 */
function register_user(WP_REST_Request $request) {
  global $error_handler;

  $params = $request->get_body_params();

  $attributes = $request->get_attributes();
  $param_arguments = isset($attributes) && isset($attributes['args']) ? $attributes['args'] : array();

  $validation_errors = array();

  if ($param_arguments) {
    foreach ($param_arguments as $fieldkey => $arg) {
      $error_msg = validate_param($arg, $fieldkey, $params, $request);
      if (!empty($error_msg)) {
        $validation_errors[$fieldkey] = $error_msg;
      }
    }
  }

  if (!empty($validation_errors)) {
    return wp_send_json_error(array('params' => $validation_errors), 400);
  }

  // remove recaptacha from params (already validated, should not send to SF)
  unset($params['g-recaptcha-response']);

  // Set 'område' and 'utbildningscenter' based on json encoded program_center param (contains 'title' and 'sf_id').
  $program_center = json_decode(htmlspecialchars_decode($params['program_center']), true);
  $params['BM_Utbildningscenter__c'] = $program_center['sf_id'];
  unset($params['program_center']); // remove json object from params (should not send to SF)

  // Get user role/type depending on hidden input value for role.
  $user_role = $params['role'];
  unset($params['role']); // remove from params (should not send to SF)

  // Set SF user role/record type ID
  $role_in_swedish = translate_role_to_swedish($user_role); // Record type name is saved in Swedish in SF.
  $record_types = get_record_types_for_object('Contact');
  if (!empty($record_types) && isset($record_types[$role_in_swedish])) {
    $params['RecordTypeId'] = $record_types[$role_in_swedish];
  } else {
    return wp_send_json_error($error_handler->get_error('could_not_find', "record type ID för $role_in_swedish", 500));
  }

  // Set utbildningsledare/owner id based on given program center title and role.
  $params['OwnerId'] = get_program_center_owner_sf_id($program_center['title'], $user_role);

  // Make SOQL query to Salesforce to create Contact.
  $sf_result = create_salesforce_object(array(
    'object_type' => 'Contact',
    'params' => $params
  ));

  if ($sf_result && isset($sf_result['data']) && isset($sf_result['data']['id'])) {
    // Create a user in WP
    $wp_result = wp_insert_user(array(
      'user_login'  => $params['Email'],
      'user_email'  => $params['Email'],
      'user_pass'   => NULL,
      'first_name'  => $params['FirstName'],
      'last_name'   => $params['LastName'],
      'role'        => $user_role
    ));

    if (!$wp_result || !is_numeric($wp_result)) {
      return wp_send_json_error($wp_result, 500);
    }

    $sf_id = $sf_result['data']['id'];

    // Add object map for object sync for salesforce plugin
    $object_map = add_object_sync_for_salesforce_object_map(array(
      'wordpress_id' => $wp_result,
      'salesforce_id' => $sf_id,
      'wordpress_object' => 'user'
    ));

    wp_new_user_notification($wp_result, null, 'user');

    $meta_data = array(
      'sf_id' => $sf_result['data']['id'],
      'sf_phone' => $params['Phone'],
      'sf_record_type_id' => $params['RecordTypeId'],
      'sf_gdpr_agreement' => $params['samtyckeGDPRContact__c'],
      'sf_program_center' => $params['BM_Utbildningscenter__c'],
      'sf_owner_id' => $params['OwnerId'],
    );

    if ($user_role === 'teacher') {
      $meta_data['sf_school'] = $params['npsp__Primary_Affiliation__c'];
    } else {
      $meta_data['sf_social_security_number'] = $params['Personnummer__c'];
    }

    return update_acf_fields($meta_data, "user_$wp_result");
  } else {
    $error_code = (!empty($sf_result) && !empty($sf_result['code'])) ? $sf_result['code'] : 500;
    return wp_send_json_error($sf_result, $error_code);
  }
}

/* SALESFORCE API */
/**
 * Create an object in Salesforce.
 * @param  array  $data - Associative array with (string) 'object_type', (array) 'params' holding the object data to create.
 *  Ex: array(
 *    'object_type' => 'GW_Volunteers__Volunteer_Hours__c',
 *    'params' => array(
 *      'GW_Volunteers__Status__c' => 'Confirmed',
 *      ...
 *    )
 *  );
 * @param  array  $query_check_exists - OPTIONAL Salesforce SOQL query to run before creating the object. If this query returns any results, the object will not be created. Useful for checking duplicates.
 *  Ex: array(
 *   'query' => 'SELECT Id,GW_Volunteers__Contact__c,GW_Volunteers__Volunteer_Shift__c FROM GW_Volunteers__Volunteer_Hours__c',
 *   'error_message' => 'Resource exists.' // OPTIONAL error message if query found something. If no error message supplied, will return Id of the found object(s), otherwise return wp_send_json_error with the error message.
 *  );
 * @return object/boolean/wp_send_json_error - Object with api response or false if api instance was not found.
 */
function create_salesforce_object($data, $query_check_exists = array()) {
  $sf_objectname = $data['object_type'];
  $salesforce_api = get_salesforce_api_instance();

  if ($salesforce_api) {
    if (!empty($query_check_exists) && isset($query_check_exists['query'])) {
      $query_result = $salesforce_api->query($query_check_exists['query'], array('cache' => false));

      if ($query_result && isset($query_result['data']) && isset($query_result['data']['done']) && isset($query_result['data']['totalSize'])) {
        if ($query_result['data']['done'] && $query_result['data']['records'] && count($query_result['data']['records'])) {
          // If should return error, send json error
          if (!empty($query_check_exists['error_message'])) {
            return wp_send_json_error($query_check_exists['error_message'], 500);
          }

          // Otherwise return Id of found object (to match response of object_create)
          return array('data' => array(
            'id' => $query_result['data']['records'][0]['Id']
          ));
        }
      } else {
        return wp_send_json_error($query_result, 500);
      }
    }

    return $salesforce_api->object_create($sf_objectname, $data['params']);
  }

  return false;
}

/**
 * Update an existing object in Salesforce.
 * @param  array  $data - Associative array with (string) 'object_type', (string) 'sf_id' the object id to update, and (array) 'params' holding the object data to create.
 *  Ex: array(
 *    'object_type' => 'GW_Volunteers__Volunteer_Hours__c',
 *    'sf_id' => 'a0S0C000000Cl2eUAC',
 *    'params' => array(
 *      'GW_Volunteers__Status__c' => 'Confirmed',
 *      ...
 *    )
 *  );
 * @param  array $current_object_condition - OPTIONAL associative array with key => values to check of existing object before updating.
 * @return object/boolean/wp_send_json_error - Object with api response or false if api instance was not found.
 */
function update_salesforce_object($data, $current_object_condition = array()) {
  global $error_handler;

  $salesforce_api = get_salesforce_api_instance();

  if ($salesforce_api) {
    $sf_objectname = $data['object_type'];
    $sf_id = $data['sf_id'];

    if (!empty($current_object_condition)) {
      $object_data = get_salesforce_object($sf_objectname, $sf_id, $salesforce_api);

      foreach ($current_object_condition as $key => $value) {
        if (!isset($object_data[$key]) || $object_data[$key] !== $value) {
          return wp_send_json_error($error_handler->get_error('object_field_condition_not_satisfied', array($key, $value, (!isset($object_data[$key]) ? NULL : $object_data[$key]))), 500);
        }
      }
    }

    return $salesforce_api->object_update($sf_objectname, $data['sf_id'], $data['params']);
  }

  return false;
}

/**
 * Delete an existing object from Salesforce.
 * @param  array  $data - Associative array with (string) 'object_type' and (string) 'sf_id' the object id to delete.
 *  Ex: array(
 *    'object_type' => 'GW_Volunteers__Volunteer_Hours__c',
 *    'sf_id' => 'a0S0C000000Cl2eUAC',
 *  );
 * @param  array $current_object_condition - OPTIONAL associative array with key => values to check of existing object before updating.
 * @return object/boolean/wp_send_json_error - Object with api response or false if api instance was not found.
 */
function delete_salesforce_object($data, $current_object_condition = array()) {
  global $error_handler;

  $salesforce_api = get_salesforce_api_instance();

  if ($salesforce_api) {
    $sf_objectname = $data['object_type'];
    $sf_id = $data['sf_id'];

    if (!empty($current_object_condition)) {
      $object_data = get_salesforce_object($sf_objectname, $sf_id, $salesforce_api);

      // If already deleted (= response code is not found) treat as success and return a response matching object_delete()'s response.
      if (!empty($object_data) && isset($object_data['errorCode']) && $object_data['errorCode'] === 'NOT_FOUND') {
        return array('data' => array(
          'success' => true,
          'message' => 'Resource was already deleted.'
        ));
      }

      foreach ($current_object_condition as $key => $value) {
        if (!isset($object_data[$key]) || $object_data[$key] !== $value) {
          return wp_send_json_error($error_handler->get_error('object_field_condition_not_satisfied', array($key, $value, (!isset($object_data[$key]) ? NULL : $object_data[$key]))), 500);
        }
      }
    }

    return $salesforce_api->object_delete($sf_objectname, $sf_id);
  }

  return false;
}

/**
 * Retrieve an object from Salesforce.
 * @param  string $sf_objectname - The Salesforce object name.
 * @param  string $sf_id - The Salesforce object ID.
 * @param  Object_Sync_Sf_Salesforce $salesforce_api - sfapi method from Object_Sync_Salesforce instance. If not supplied as argument, will try to fetch from get_salesforce_api_instance().
 * @return array/wp_send_json_error - Object data of found object or error.
 */
function get_salesforce_object($sf_objectname, $sf_id, $salesforce_api = null) {
  global $error_handler;

  $salesforce_api = isset($salesforce_api) ? $salesforce_api : get_salesforce_api_instance();

  if ($salesforce_api) {
    $object = $salesforce_api->object_read($sf_objectname, $sf_id, array('cache' => false));
    $object_data = $object && isset($object['data']) ? $object['data'] : false;

    if (!$object_data) {
      return wp_send_json_error($error_handler->get_error('could_not_get_sf_object', array($sf_objectname, $sf_id)), 500);
    }

    return $object_data;
  }

  return wp_send_json_error($error_handler->get_error('could_not_find_sf_api'), 500);
}

/**
 * Do Salesforce SOQL query and return result
 * @param  string $query - SOQL query see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/dome_query.htm for examples.
 * @return array/wp_send_json_error - Result or Error
 */
function query_salesforce_object($query, $salesforce_api = null) {
  global $error_handler;

  $salesforce_api = isset($salesforce_api) ? $salesforce_api : get_salesforce_api_instance();

  if ($salesforce_api) {
    if (!empty($query)) {
      return $salesforce_api->query($query, array('cache' => false));
    } else {
      return wp_send_json_error($error_handler->get_error('missing_query'), 400);
    }
  }

  return wp_send_json_error($error_handler->get_error('could_not_find_sf_api'), 500);
}

/**
 * Return sfapi method from Object_Sync_Salesforce plugin instance for communicating with SF.
 * @return Object_Sync_Sf_Salesforce/boolean - Method or false if error.
 */
function get_salesforce_api_instance() {
  if (!function_exists( 'is_plugin_active')) {
    require_once ABSPATH . '/wp-admin/includes/plugin.php';
  }

  if (is_plugin_active('object-sync-for-salesforce/object-sync-for-salesforce.php')) {
    require_once WP_PLUGIN_DIR . '/object-sync-for-salesforce/object-sync-for-salesforce.php';
    $salesforce = Object_Sync_Salesforce::get_instance();
    return $salesforce->salesforce['sfapi'];
  }

  return false;
}

/**
 * Retrieve available record types for sObject
 * @param  string $object_name - name of sObject
 * @return array/wp_send_json_error - On success: Associative array with record type name as key and record type id as value. On fail: Error message.
 */
function get_record_types_for_object($object_name) {
  global $cache_handler, $error_handler;

  $cache_file = "record-types_$object_name.json";

  // Keep for a week. Maybe should keep longer? Record type IDs does not change very often..
  if ($cache_handler->is_cached($cache_file, 604800)) {
  	return json_decode(($cache_handler->read_cache($cache_file)), true);
  }

  $query = "SELECT Id,Name FROM RecordType WHERE sObjectType='$object_name'";
  $query_result = query_salesforce_object($query);

  if ($query_result && isset($query_result['data']) && isset($query_result['data']['done']) && isset($query_result['data']['totalSize'])) {
    if ($query_result['data']['done'] && $query_result['data']['records'] && count($query_result['data']['records'])) {
      $result = array();

      foreach ($query_result['data']['records'] as $key => $value) {
        $result[$value['Name']] = $value['Id'];
      }

      $cache_handler->write_cache($cache_file, json_encode($result));
      return $result;
    }

    // Could not find match
    return wp_send_json_error($error_handler->get_error("could_not_find", "record type för $object_name"), 500);
  } else {
    // Could not communicate with SF
    return wp_send_json_error($error_handler->get_error("could_not_connect_to_sf"), 500);
  }
}
/* end SALESFORCE API */

/* VALIDATION */
// check correct role
function is_user_permitted() {
  $user = wp_get_current_user();

  if (!$user->exists()) {
    return wp_send_json_error(NULL, 401);
  }

  $user_roles = $user->roles;
  $permitted_roles = array('administrator', 'teacher', 'volunteer');

  return (!empty(array_intersect($user_roles, $permitted_roles)));
}

// validate date param from request
function is_valid_date($param, $request, $key) {
  return !!strtotime($param);
}

// check is not empty
function is_not_empty($param, $request, $key) {
  return !empty($param);
}

/**
 * Checks wether email is valid and does not exist as user email in WP or as contact email in SF
 * @param  string $param - Email param value
 * @param  WP_REST_Request $request
 * @param  string $key - Param key name
 * @return boolean - true if valid, false if invalid
 */
function is_valid_unique_user_email($value) {
  global $error_handler;

  if (empty($value) || !is_email($value)) {
    // Invalid or empty email address
    return $error_handler->get_error('invalid_field_email');
  }

  $existsInWP = email_exists($value);

  if ($existsInWP) {
    return $error_handler->get_error('invalid_field_email_duplicate');
  }

  $query_result = query_salesforce_object("SELECT Email FROM Contact WHERE Email='$value'");
  if ($query_result && isset($query_result['data']) && isset($query_result['data']['done']) && isset($query_result['data']['totalSize'])) {
    if ($query_result['data']['done'] && $query_result['data']['records'] && count($query_result['data']['records'])) {
      // Found an exisiting Account with same email address
      return $error_handler->get_error('invalid_field_email_duplicate');
    }
  } else {
    // Could not communicate with SF
    return $error_handler->get_error('could_not_connect_to_sf');
  }

  return true;
}

function validate_recaptcha($value) {
  global $recaptcha;

  $response = $recaptcha->verifyResponse(
    $_SERVER['REMOTE_ADDR'],
    $value
  );

  if ($response->success) {
    return true;
  }

  return false;
}

/**
 * Validate a request param and return error message if invalid, void if valid.
 * This is used in favour for wp's 'validate_callback' and 'required' to be able to return a custom error message.
 * @param  array $arg - Arguments for the param.
 *  'is_required' => bool or callable which takes request as argument,
 *  'validate_func' => callable which takes the param value as argument,
 *  'max_length' => int.
 * @param  string $key - Param field name/key.
 * @param  array $params - All params given in request as returned by WP_REST_Request::get_body_params().
 * @return string/void - Error message if invalid, void if valid.
 */
function validate_param($arg, $key, $params, $request) {
  global $error_handler;

  $value = isset($params[$key]) ? $params[$key] : '';

  if (isset($arg['is_required']) &&
    ($arg['is_required'] === true || (is_callable($arg['is_required']) && call_user_func($arg['is_required'], $request) === true)) &&
    (empty($value) || empty(trim($value)))
  ) {
    return $error_handler->get_error('invalid_field_empty');
  }

  if ($value && isset($arg['validate_func'])) {
    $is_valid = call_user_func($arg['validate_func'], $value);

    // returns boolean (true if success, false if fail OR error message)
    if ($is_valid === false || is_string($is_valid)) {
     return is_string($is_valid) ? $is_valid : $error_handler->get_error('invalid_field_'.strtolower($key));
    }
  }

  if ($value && isset($arg['max_length'])) {
    $max_length = $arg['max_length'];

    if (strlen((string) $value) > $max_length) {
      return $error_handler->get_error('invalid_field_too_long', $max_length);
    }
  }
}
/* end VALIDATION */

/* HELPER FUNCTIONS */
function get_shift_by_sf_id($sf_id) {
  global $error_handler;

  $volunteer_shift = get_posts(array(
    'numberposts'  => 1,
    'post_type'    => 'volunteer_shift',
    'meta_query'  => array(
      array(
        'key'        => 'sf_id',
        'value'      => $sf_id,
      ),
    ),
  ));

  if (!is_array($volunteer_shift) || empty($volunteer_shift)) {
    return wp_send_json_error($error_handler->get_error('could_not_find_object', array('Passet', $sf_id)), 404);
  }

  return $volunteer_shift;
}

/**
 * Find a booked_shift with given user sf id (sf_contact_id) and shift sf id (sf_volunteer_shift)
 * @param  string $sf_contact_id - User's SF id.
 * @param  string $sf_volunteer_shift - Shift's SF id.
 * @return array - List of found bookings' WP ids.
 */
function get_user_booking_id_for_volunteer_shift($sf_contact_id, $sf_volunteer_shift) {
  return get_posts(array(
    'numberposts'  => 1,
    'post_type'    => 'booked_shift',
    'fields'      => 'ids',
    'meta_query'  => array(
      array(
        'key'        => 'sf_contact_id',
        'value'      => $sf_contact_id,
      ),
      array(
        'key'        => 'sf_volunteer_shift',
        'value'      => $sf_volunteer_shift,
      ),
    ),
  ));
}

/**
 * Increase/Decrease volunteer_shift's meta data for total number of volunteers
 * @param  string $shift_id - WP id of the volunteer_shift to update.
 * @param  int $diff - Number to add or subtract from current value. Supply a negative number to subtract.
 * @return void
 */
function update_shifts_total_volunteers($shift_id, $diff) {
  if ($shift_id) {
    // get current count value
    $volunteer_count = (int) get_field('sf_total_volunteers', $shift_id);
    $volunteer_count = $volunteer_count <= 0 ? ($diff < 0 ? 0 : $diff) : ($volunteer_count + $diff);
    update_field('sf_total_volunteers', $volunteer_count, $shift_id);
  }
}

// calculate days until now, will return days with two decimals (ex. 3.5 if three days and 12 hours)
function days_until($date) {
  return isset($date) ? round((strtotime($date) - time())/60/60/24, 2) : NULL;
}

function get_event_status($acf_fields, $start_date, $user_role) {
  // Check 'urgent need' status
  if ($user_role === 'volunteer' && isset($acf_fields['sf_urgent_need']) && isset($acf_fields['sf_desired_number_of_volunteers']) && isset($acf_fields['sf_total_volunteers'])) {
    $days_from_now = days_until($start_date);

    if (
      $days_from_now != false && $days_from_now >= 0 && // Date of the event is after or is current date
      isset($acf_fields['sf_urgent_need']) && filter_var($acf_fields['sf_urgent_need'], FILTER_VALIDATE_BOOLEAN) && // Akut Behov is checked (SF field: AK_Akut_Beho__c)
      (intval($acf_fields['sf_desired_number_of_volunteers']) - intval($acf_fields['sf_total_volunteers'])) > 0 // Need volunteers
    ) {
      return 'urgent-need';
    }
  }

  return '';
}

// get event color from state
function get_event_color($status) {
  if ($status === 'urgent-need') {
    return '#f56060';
  }

  return '#22a9f1'; // default color blue
}

// get Swedish role name (capitalized)
function translate_role_to_swedish($role) {
  switch ($role) {
    case 'volunteer':
      return 'Volontär';
      break;
    case 'teacher':
      return 'Lärare';
      break;
    default:
      return '';
      break;
  }
}

/**
 * Get 'utbildningsledare' for program center and user role. Uses cache to save result in json file.
 * @param  string $program_center_name - capitalized program center name ex. Södertälje
 * @param  string $user_role - teacher or volunteer
 * @return string/wp_send_json_error - sf id of utbildningledare/owner id or error message
 */
function get_program_center_owner_sf_id($program_center_name, $user_role) {
  global $error_handler, $cache_handler;

  if (empty($program_center_name)) {
    return wp_send_json_error($error_handler->get_error('missing_required_param', 'utbildningscenter'), 400);
  }

  $cache_file = "program-center-owner-ids.json";

  if ($cache_handler->is_cached($cache_file)) {
    $program_center_owners = json_decode(($cache_handler->read_cache($cache_file)), true);

    if (!empty($program_center_owners[$program_center_name][$user_role])) {
      return $program_center_owners[$program_center_name][$user_role];
    } else if ($user_role === 'teacher' && !empty($program_center_owners[$program_center_name]['volunteer'])) {
      // Default to utbildningsledare for volunteers if unset for teachers
      return $program_center_owners[$program_center_name]['volunteer'];
    }
  }

  $query_result = query_salesforce_object("SELECT Id,Profile.Name,Division FROM User WHERE Profile.Name LIKE '%Utbildningsledare'");

  if ($query_result && isset($query_result['data']) && isset($query_result['data']['done']) && isset($query_result['data']['totalSize'])) {
    if ($query_result['data']['done'] && $query_result['data']['records'] && count($query_result['data']['records'])) {

      $result = array();

      foreach ($query_result['data']['records'] as $key => $value) {
        if (!empty($value['Division']) && !empty($value['Id']) && !empty($value['Profile']) && !empty($value['Profile']['Name'])) {
          $role = strpos($value['Profile']['Name'], 'Lärare') !== false ? 'teacher' : 'volunteer'; // Change 'Lärare Utbildningsledare' -> 'teacher' and 'Utbildningsledare' -> 'volunteer'
          $result[$value['Division']][$role] = $value['Id'];
        }
      }

      if (!empty($result)) {
        $cache_handler->write_cache($cache_file, json_encode($result));

        if (!empty($result[$program_center_name][$user_role])) {
          return $result[$program_center_name][$user_role];
        } else if ($user_role === 'teacher' && !empty($result[$program_center_name]['volunteer'])) {
          // Default to utbildningsledare for volunteers if unset for teachers
          return $result[$program_center_name]['volunteer'];
        }
      }
    }

    // Could not find match
    return wp_send_json_error($error_handler->get_error("could_not_find", "utbildningsledaren för $program_center_name"), 500);
  } else {
    // Could not communicate with SF
    return wp_send_json_error($error_handler->get_error("could_not_connect_to_sf"), 500);
  }
}

// Override user role for testing purpose
function override_admin_role($user_role) {
  return $user_role === 'administrator' ? 'volunteer' : $user_role;
}
/* end HELPER FUNCTIONS */
