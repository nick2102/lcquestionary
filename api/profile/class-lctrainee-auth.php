<?php
/**
 * LcTrainee_Auth
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Auth
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Auth();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
    }

    /**
     * Handle user Login
     */
    public static function lctrainee_user_login(WP_REST_Request $request)
    {
        $username = sanitize_text_field( $request->get_param('username') );
        $password = sanitize_text_field( $request->get_param('password') );

        if(empty($username) || empty($password)){
            return new WP_Error( 'Request failed',  __('All fields are required!', 'trainee'), array( 'status' => 500, "error" =>  __('All fields are required!', 'trainee') ."<br>"));
        }

        $user_status = get_user_by('login', $username)->user_status;

        if( ! $user_status ) {
            return new WP_Error( 'Request failed',  __('Your account is not activated please check your activation mail and click the activation link.', 'trainee'), array( 'status' => 500, "error" =>  __('Your account is not activated please check your activation mail and click the activation link.', 'trainee') ."<br>"));
        }

        if(LcTrainee_Login_Shield::check_if_blocked_ip($username)){
            $minutes = LcTrainee_Login_Shield::get_remaining_block_minutes($username);
            $minText = $minutes > 1 ? 'minutes' : 'minute';
            return new WP_Error( "Request failed", __("You have been blocked because of to many invalid logins. Please try in {$minutes} ", 'trainee') . __("{$minText}.", 'trainee'), array( 'status' => 500, "error" =>  __("You have been blocked because of to many invalid logins. Please try in {$minutes} " . __("{$minText}.", 'trainee'), 'trainee')));
        }

        $user = wp_authenticate( $username, $password );
        if(!$user->ID) {
            LcTrainee_Login_Shield::record_invalid_login($username);
            return new WP_Error( 'Request failed',  __('Invalid login details.', 'trainee'), array( 'status' => 500, "error" =>  __("Invalid login details", 'trainee') . "<br>"));
        }

        //cookies for wordpress login
        wp_set_auth_cookie($user->ID, false);
        LcTrainee_Login_Shield::lctrainee_reset_blockip_counter($username);
        $redirectURl = get_site_url();
        return new WP_REST_Response( ["status" => "OK", "redirectURL" => "$redirectURl"], 200 );
    }

    /**
     * Handle register user
     */
    public static function lctrainee_user_register(WP_REST_Request $request)
    {
        $name = sanitize_text_field($request->get_param('name'));
        $lastName = sanitize_text_field($request->get_param('lastName'));
        $email = sanitize_text_field($request->get_param('email'));
        $password = sanitize_text_field($request->get_param('password'));
        $website = sanitize_text_field($request->get_param('website'));
        $userRole = sanitize_text_field($request->get_param('role'));

        if(email_exists($email)){
            return new WP_Error(500, __('User already is registered. Please check your registration mail.', 'trainee'));
        }

        if(username_exists($email)){
            return new WP_Error(500, __('User already is registered. Please check your registration mail.', 'trainee'));
        }

        $userData = [
            'user_pass'             => $password,   //(string) The plain-text user password.
            'user_login'            => $email,   //(string) The user's login username.
            'user_nicename'         => $name,   //(string) The URL-friendly user name.
            'user_email'            => $email,   //(string) The user email address.
            'display_name'          => $name,   //(string) The user's display name. Default is the user's username.
            'nickname'              => $name,   //(string) The user's nickname. Default is the user's username.
            'first_name'            => $name,   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
            'last_name'             => $lastName,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
            'user_url'              => $website,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
            'role'                  => $userRole,   //(string) User's role.
        ];

        if($userRole === 'resident' ){
            $userData['user_nicename'] = $email;
            $userData['display_name'] = $email;
            $userData['nickname'] = $email;
        }

        $user = wp_insert_user($userData);

        if(is_wp_error($user)) {
            return $user;
        }

        $code = sha1( $user . time() );
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';
        $wpdb->update(
            $table_name, //table name
            array( 'user_activation_key' => $code),
                array( 'ID' => $user ),
                array( '%s')
                );

        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user ), get_site_url() . '/account-activation');

        wp_mail( $email, __('Activate your account', 'trainee'), __('Activation link', 'trainee') . ': ' . $activation_link );

        return new WP_REST_Response( ["status" => "OK", "message" => __('Please check your email, and confirm your account', 'trainee')], 200 );
    }

    /**
     * Handle  user forgot password
     */
    public static function lctrainee_user_forgot_password(WP_REST_Request $request)
    {

        $mail = sanitize_text_field($request->get_param('email'));
        if(empty($mail)){
            return new WP_Error( 'Request failed',  __('Please enter your mail.', 'trainee'), array( 'status' => 500, "error" =>  __("Please enter your mail.", 'trainee') . "<br>"));
        }

        $userdata = get_user_by( 'email', $mail);

        if(empty($userdata)){
            $userdata = get_user_by( 'login', $mail);
        }

        if(empty($userdata)){
            return new WP_Error( 'Request failed',  __('User not found.', 'trainee'), array( 'status' => 404, "error" =>  __("User not found.", 'trainee') . "<br>"));
        }

        $user = new WP_User( intval($userdata->ID) );
        $userName = $user->user_login;
        $reset_key = get_password_reset_key( $user );

        //SEND MAIL FOR SUCCESSFUL PROFILE CREATION
        $to = $mail;
        $subject = __('Reset password', 'trainee');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $mailBody = "<h4>Hello {$userName}!</h4> <br>";
        $mailBody .= __('Your reset password link is', 'trainee'). ': ' . get_site_url() . '/reset-password/?key=' . $reset_key.'&login='.$userName;
        $mailRequest = wp_mail( $to, $subject, $mailBody, $headers );

        if(!$mailRequest){
            return new WP_Error( 'Bad Request', __ ( 'Error sending reset password email.', 'trainee' ));
        }


        return new WP_REST_Response( ["status" => "OK", "message" => __('Password reset link has been sent to your registered email', 'trainee')], 200 );
    }

    /**
     * Handle  user reset password
     */
    public static function lctrainee_user_reset_password(WP_REST_Request $request)
    {
        $key = sanitize_text_field($request->get_param('key'));
        $login = sanitize_text_field($request->get_param('login'));
        $password = sanitize_text_field($request->get_param('password'));

        if(empty($password)){
            return new WP_Error( 'Bad Request', __ ( 'The password field is required!', 'trainee' ));
        }

        if(empty($login)){
            return new WP_Error( 'Bad Request', __ ( 'Invalid reset password link. Reload the link from your reset password email', 'trainee' ));
        }

        $user = check_password_reset_key( $key, $login );

        if(!$user->ID){
            return $user;
        }

        wp_set_password($password, $user->ID);

        return new WP_REST_Response( ["status" => "OK", "message" => __('Password has been changed!', 'trainee')], 200 );
    }

    /**
     * Handle  user change password
     */
    public static function lctrainee_user_change_password(WP_REST_Request $request)
    {

        $oldPassword = sanitize_text_field($request->get_param('oldPassword'));
        $password = sanitize_text_field($request->get_param('password'));
        $userId = get_current_user_id();

        if(empty($oldPassword)) {
            return new WP_Error( 'Bad Request', __ ( 'The old password field is required!', 'trainee' ));
        }

        if(empty($password)) {
            return new WP_Error( 'Bad Request', __ ( 'The password field is required!', 'trainee' ));
        }

        $user = get_user_by('ID', $userId);

        if ( !wp_check_password( $oldPassword, $user->data->user_pass, $userId ) ) {
            return new WP_Error( 'Bad Request', __ ( 'Your old password did not match!', 'trainee' ));
        }

        wp_set_password($password, $userId);

        wp_set_auth_cookie($userId, false);

        return new WP_REST_Response( ["status" => "OK", "message" => __('Password has been changed!', 'trainee')], 200 );
    }
}