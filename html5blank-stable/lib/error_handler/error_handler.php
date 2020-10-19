<?php
class errorHandler {
  public $errors;
  public $data;
  public $default_error;

  public function __construct() {
    $this->errors = file_get_contents(dirname(__FILE__) . '/error_messages.json');
    $this->data = json_decode($this->errors, true);
    $this->default_error = 'Något gick fel.';
  }

  function get_error($id, $params = '') {
    $error_msg = isset($this->data[$id]) ? $this->data[$id] : $this->default_error;

    if (!empty($params)) {
      return is_array($params) ? sprintf($error_msg, ...$params) : sprintf($error_msg, $params);
    }

    return $error_msg;
  }
}
