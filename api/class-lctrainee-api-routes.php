<?php
/**
 * LcTrainee_Api_Routes
 *
 * Initiate custom wordpress api routes
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Api_Routes
{
    private static $instance = null;
    const METHOD = 'methods';
    const CALLBACK = 'callback';
    const PERMISSION_CALLBACK = 'permission_callback';

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Api_Routes();
        }

        return self::$instance;
    }

    /**
     * @var string Api namespace
     */
    protected $namespace = TRAINEE_PLUGIN_API_NAMESPACE;


    /**
     * class constructor
     */
    public function __construct()
    {
        // plugin initialization
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes()
    {

        /**********  GET Routes  **********/
        // test
        register_rest_route($this->namespace, '/test', array(
            self::METHOD => WP_REST_Server::READABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'test'],
        ));

        // Get buildings
        register_rest_route($this->namespace, '/get-buildings', array(
            self::METHOD => WP_REST_Server::READABLE,
            self::CALLBACK => [new LcTrainee_Profile_Actions, 'trainee_serach_buildings'],
        ));

        // Get Companies
        register_rest_route($this->namespace, '/get-more-companies', array(
            self::METHOD => WP_REST_Server::READABLE,
            self::CALLBACK => [new LcTrainee_Public_Api, 'load_more_companies'],
        ));

        /**********  POST Routes  **********/

        // Login User
        register_rest_route($this->namespace, '/login', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'lctrainee_user_login'],
        ));

        // Register User
        register_rest_route($this->namespace, '/register', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'lctrainee_user_register'],
        ));

        // Forgot Password
        register_rest_route($this->namespace, '/reset-password-request', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'lctrainee_user_forgot_password'],
        ));

        // Reset Password
        register_rest_route($this->namespace, '/reset-password', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'lctrainee_user_reset_password'],
        ));

        // Reset Password Logged
        register_rest_route($this->namespace, '/change-password', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Auth, 'lctrainee_user_change_password'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // save questionnaire data
        register_rest_route($this->namespace, '/save-questionnaire', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Admin_Api, 'save_questionnaire_data'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // save EE indicator data
        register_rest_route($this->namespace, '/save-ee-indicator', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Admin_Api, 'save_ee_indicator_data'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // get Q solutions tabs
        register_rest_route($this->namespace, '/get-q-solutions-tabs', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Admin_Api, 'get_q_solutions_tabs'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // save Q solutions tabs
        register_rest_route($this->namespace, '/save-q-solutions-tabs', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Admin_Api, 'save_q_solutions_tabs'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // save questionnaire data
        register_rest_route($this->namespace, '/save-profile-questionnaire', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Profile_Actions, 'save_profile_questionnaire'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));

        // Save questionnaire profile
        register_rest_route($this->namespace, '/save-profile-questionnaire-certified', array(
            self::METHOD => WP_REST_Server::CREATABLE,
            self::CALLBACK => [new LcTrainee_Profile_Actions, 'save_profile_questionnaire_certified'],
            self::PERMISSION_CALLBACK => function($request){
                return is_user_logged_in();
            }
        ));
    }



}