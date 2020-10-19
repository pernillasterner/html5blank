<?php
/* HELPER FUNCTIONS */

// Replace &nbsp; with space
function clean_whitespace($str) {
  $literal_html = htmlentities($str);
  $cleaned_html = str_replace("&nbsp;", " ", $literal_html);
  return html_entity_decode($cleaned_html);
}


/**
 * Accepts role name or role slug and returns valid role slug.
 * @param  string $role - Role slug or name
 * @return string - Valid role slug or empty string if could not find any.
 */
function find_role_by_name( $role ) {
  $wp_roles = wp_roles();

  if ( empty($wp_roles) || !isset($wp_roles->roles) ) {
    return '';
  }

  foreach ($wp_roles->roles as $key => $val) {
    if ($key === $role || $val['name'] === $role) {
      return $key;
    }
  }

  return '';
}

/* DATE FORMATS */
function get_weekday($date) {
  return date_i18n( 'l', strtotime($date) );
}

function get_date_format($date) {
  return date_i18n( 'd F Y', strtotime($date) );
}
function get_timestring($date) {
  return date_i18n( 'H:i', strtotime($date) );
}

/**
 * Takes a date time string and formats to 'Y-m-d H:i:s' with Stockholm time zone.
 * @param  string $date_string - any datetime string DateTime accepts.
 * @return string Datetime string in format 'Y-m-d H:i:s' with Stockholm time zone.
 */
function format_datetime($date_string) {
  try {
    $datetime = new DateTime($date_string);
  } catch (Exception $e) {
    return $date_string;
  }

  $datetime->setTimeZone(new DateTimeZone('Europe/Stockholm'));
  return $datetime->format('Y-m-d H:i:s');
}
