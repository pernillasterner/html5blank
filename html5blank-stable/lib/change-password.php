<?php
/**
 * Enqueue change password script
 */
function enqueueChangePasswordJs()
{
    if (is_page_template('template-minasidor.php')) {
        $user = wp_get_current_user();

        wp_enqueue_script('change-password-js', get_template_directory_uri() . '/assets/js/change-password.js', '', '0.0.1', true);
        wp_localize_script('change-password-js', 'cvars', [
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);
    }
}
add_action('wp_enqueue_scripts', 'enqueueChangePasswordJs');

/**
 * AJAX for change password form
 */
function changePasswordForm()
{
    $errors = new WP_Error();

    $loggedInUser = wp_get_current_user();
    $user = get_userdata($loggedInUser->ID);
    if (!$user || empty($user)) {
        echo 0;
        exit;
    }

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
add_action('wp_ajax_nopriv_changepassword', 'changePasswordForm');
add_action('wp_ajax_changepassword', 'changePasswordForm');
