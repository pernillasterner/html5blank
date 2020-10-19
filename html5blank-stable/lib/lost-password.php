<?php
/**
 * Add link to login form
 */
function addLinkToLoginForm()
{
    // Needs to be a string because wp_login_form() uses apply_filters()
    return '<p class="lost-password">
    <span>Har du glömt ditt lösenord?</span>
    <span>Återställ lösenordet <a id="lostpassword-link" href="#lostpassword">här</a></span>
</p>';
}
add_filter('login_form_middle', 'addLinkToLoginForm');

/**
 * Enqueue login form script
 */
function enqueueLoginFormJs()
{
    wp_enqueue_script('login-form-js', get_template_directory_uri() . '/assets/js/login-form.js', '', '0.0.1', true);
    wp_localize_script('login-form-js', 'vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueueLoginFormJs');

/**
 * AJAX for lost password form
 */
function lostPasswordForm()
{
    $errors = new WP_Error();

    if (empty($_POST['user_login'])) {
        $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or email address.'));
    } elseif (strpos($_POST['user_login'], '@')) {
        $user_data = get_user_by('email', trim(wp_unslash($_POST['user_login'])));
        if (empty($user_data)) {
            $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
        }
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }

    if ($errors->get_error_code()) {
        echo json_encode([
            'status' => 'NOK',
            'errors' => $errors
        ]);
        exit;
    }

    if (!$user_data) {
        $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or email.'));
        echo json_encode([
            'status' => 'NOK',
            'errors' => $errors
        ]);
        exit;
    }

    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key = get_password_reset_key($user_data);

    if (is_wp_error($key)) {
        echo json_encode([
            'status' => 'NOK',
            'errors' => $errors
        ]);
        exit;
    }

    $message = getLostPasswordMessage($user_login, $key);
    $title = sprintf(__('[%s] Password Reset'), wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
    // Mail it
    if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message)) {
        $errors->add('cannot_send', __('The email could not be sent.'));
        echo json_encode([
            'status' => 'MNOK',
            'errors' => $errors
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'OK'
    ]);
    exit;
}
add_action('wp_ajax_nopriv_lostpassword', 'lostPasswordForm');
add_action('wp_ajax_lostpassword', 'lostPasswordForm');

/**
 * Email text for lost password
 *
 * @param string $user_login - Username or email
 * @param string $key - Password reset key
 */
function getLostPasswordMessage($user_login, $key)
{
    $message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= '<' . network_site_url('#reset-password&key=' . $key . '&login=' . rawurlencode($user_login)) . ">\r\n";

    return $message;
}

/**
 * AJAX for reset password form
 */
function resetPasswordForm()
{
    $login = wp_unslash($_POST['login']);
    $key = wp_unslash($_POST['key']);

    $user = checkPasswordResetKey($key, $login);

    if (!$user || is_wp_error($user)) {
        echo json_encode([
            'status' => 'NOK',
            'errors' => $user
        ]);
        exit;
    }

    $errors = new WP_Error();

    if (isset($_POST['pass1']) && $_POST['pass1'] !== $_POST['pass2']) {
        $errors->add('password_reset_mismatch', __('The passwords do not match.'));
    }

    if (strlen($_POST['pass1']) < 7) {
        $errors->add('password_too_short', __('Lösenordet är för kort. Vänligen ange minst 7 tecken.'));
    }

    do_action('validate_password_reset', $errors, $user);

    if ((!$errors->get_error_code()) && isset($_POST['pass1']) && !empty($_POST['pass1'])) {
        reset_password($user, $_POST['pass1']);
        echo json_encode([
            'status' => 'OK'
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'NOK',
        'errors' => $errors
    ]);
    exit;
}
add_action('wp_ajax_nopriv_resetpassword', 'resetPasswordForm');
add_action('wp_ajax_resetpassword', 'resetPasswordForm');

/**
 * Retrieves a user row based on password reset key and login
 */
function checkPasswordResetKey($key, $login)
{
    global $wpdb;

    include_once get_home_path() . 'wp-includes/class-phpass.php';

    if (empty($key) || !is_string($key)) {
        return new WP_Error('invalid_key', __('Invalid key'));
    }

    if (empty($login) || !is_string($login)) {
        return new WP_Error('invalid_key', __('Invalid key'));
    }

    $row = $wpdb->get_row($wpdb->prepare("SELECT ID, user_activation_key FROM $wpdb->users WHERE user_login = %s", $login));
    if (!$row) {
        return new WP_Error('invalid_key', __('Invalid key'));
    }

    $expiration_duration = apply_filters('password_reset_expiration', DAY_IN_SECONDS);

    if (false !== strpos($row->user_activation_key, ':')) {
        list($pass_request_time, $pass_key) = explode(':', $row->user_activation_key, 2);
        $expiration_time = $pass_request_time + $expiration_duration;
    } else {
        $pass_key = $row->user_activation_key;
        $expiration_time = false;
    }

    if (!$pass_key) {
        return new WP_Error('invalid_key', __('Invalid key'));
    }

    $wp_hasher = new PasswordHash(8, true);
    $hash_is_correct = $wp_hasher->CheckPassword($key, $pass_key);

    if ($hash_is_correct && $expiration_time && time() < $expiration_time) {
        return get_userdata($row->ID);
    } elseif ($hash_is_correct && $expiration_time) {
        return new WP_Error('expired_key', __('Invalid key'));
    }

    if (hash_equals($row->user_activation_key, $key) || ($hash_is_correct && !$expiration_time)) {
        $return = new WP_Error('expired_key', __('Invalid key'));
        $user_id = $row->ID;
        return apply_filters('password_reset_key_expired', $return, $user_id);
    }

    return new WP_Error('invalid_key', __('Invalid key'));
}
