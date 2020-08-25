<?php
/**
 * LcTrainee
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        // autoload classes
        spl_autoload_register ( [ $this, 'autoload' ] );

        //plugin activation/deactivation scripts in /install/
        LcTrainee_Install::init();
//        $admin_role_set = get_role( 'administrator' )->capabilities;
//        var_dump($admin_role_set);
//         plugin initialization
        add_action ( 'plugins_loaded', [ $this, 'init' ], 1 );

    }

    // Remove posts from admin area
    public function trainee_remove_default_post_type($args, $postType)
    {
        if ($postType === 'post' || $postType === 'comments') {
            $args['public']                = false;
            $args['show_ui']               = false;
            $args['show_in_menu']          = false;
            $args['show_in_admin_bar']     = false;
            $args['show_in_nav_menus']     = false;
            $args['can_export']            = false;
            $args['has_archive']           = false;
            $args['exclude_from_search']   = true;
            $args['publicly_queryable']    = false;
            $args['show_in_rest']          = false;
        }

        return $args;
    }

    // Removes from admin menu
    public function lctrainee_comments_remove_admin_menus()
    {
        remove_menu_page( 'edit-comments.php' );
    }

    // Removes from post and pages
    public function lctrainee_remove_comment_support()
    {
        remove_post_type_support( 'post', 'comments' );
        remove_post_type_support( 'page', 'comments' );
    }

    // Removes from admin bar
    public function lctrainee_admin_bar_render_no_comments()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    }

    /**
     * Autoload plugin classes
     */
    public static function autoload ( $class )
    {
        // exit, if not a trainee class
        if ( 0 !== strncmp ( 'LcTrainee_', $class, 10 ) ) {
            return;
        }

        $class = 'class-' . str_replace ( '_', '-', strtolower ( $class ) );

        //locations of all trainee plugin class files
        $dirs = array(
            TRAINEE_PLUGIN_DIR . "include/install",
            TRAINEE_PLUGIN_DIR . "/api",
            TRAINEE_PLUGIN_DIR . "/api/profile",
            TRAINEE_PLUGIN_DIR . "include/cpt",
            TRAINEE_PLUGIN_DIR . "include/admin",
            TRAINEE_PLUGIN_DIR . "include/users",
            TRAINEE_PLUGIN_DIR . "include/shortcodes",
            TRAINEE_PLUGIN_DIR . "include/cpt/meta-boxes",
            TRAINEE_PLUGIN_DIR . "include/utils",
            TRAINEE_PLUGIN_DIR . "include/models",
            TRAINEE_PLUGIN_DIR . "include/widgets",
        );



        //autoload requested class
        foreach ( $dirs as $dir ) {
            if ( is_file ( $file = "$dir/$class.php" ) ) {
                require_once ( $file );
                return;
            }
        }
    }

    // Show admin bar only for admins

    public function remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    // Admin footer modification

    public function remove_footer_admin ()
    {
        echo '';
    }

    public function lctrainee_remove_dashboard_menu_items()
    {
        $admin = wp_get_current_user();

        if(!current_user_can('administrator') || $admin->user_login !== 'epg_super'){
            remove_menu_page( 'index.php', 'update-core.php' );
        }
    }

    public function annointed_admin_bar_remove() {
        global $wp_admin_bar;
        /* Remove their stuff */
//        var_dump($wp_admin_bar);
        $wp_admin_bar->remove_menu('wp-logo');
    }

    public function add_my_own_logo( $wp_admin_bar ) {
        $args = array(
            'id'    => 'trainee-bar-logo',
            'meta'  => array( 'class' => 'trainee-bar-logo', 'title' => 'trainee' )
        );
        $wp_admin_bar->add_node( $args );
    }

    /**
     * Load Plugin assets
     */
    public function lctrainee_public_assets()
    {
        // Registering scripts and styles
        wp_register_script('lctrainee-js',TRAINEE_PLUGIN_URL . '/assets/dist/trainee.min.js', ['jquery'], '1.0.0', true);
        wp_register_style('sweet-alert-2', TRAINEE_PLUGIN_URL. '/assets/css/plugins/sweet-alert.min.css', false, '1.0.0');
        wp_register_style('trainee-chart', TRAINEE_PLUGIN_URL. 'assets/css/plugins/Chart.min.css', false, '1.0.0');
        wp_register_style('trainee_base_plugin', TRAINEE_PLUGIN_URL. '/assets/css/public/trainee-base.css', false, '1.0.0');
        wp_register_style('bootstrap-css', TRAINEE_PLUGIN_URL. '/assets/css/plugins/bootstrap/bootstrap.min.css', false, '1.0.0');
        wp_register_style('bootstrap-grid-css', TRAINEE_PLUGIN_URL. '/assets/css/plugins/bootstrap/public/bootstrap-grid.min.css', false, '1.0.0');
        wp_register_style('bootstrap-reboot-css', TRAINEE_PLUGIN_URL. '/assets/css/plugins/bootstrap/public/bootstrap-reboot.min.css', false, '1.0.0');

        // Enqueue scripts and styles
        wp_enqueue_script('lctrainee-js');
        wp_enqueue_style('sweet-alert-2');
        wp_enqueue_style('trainee-chart');
        wp_enqueue_style('bootstrap-css');
        wp_enqueue_style('bootstrap-grid-css');
        wp_enqueue_style('bootstrap-reboot-css');
        wp_enqueue_style('trainee_base_plugin');

        // HERE MAPS
        wp_register_script('trainee_here_maps', 'https://js.api.here.com/v3/3.1/mapsjs-core.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_service','https://js.api.here.com/v3/3.1/mapsjs-service.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_ui','https://js.api.here.com/v3/3.1/mapsjs-ui.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_mapevents','https://js.api.here.com/v3/3.1/mapsjs-mapevents.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);

        wp_enqueue_script('trainee_here_maps');
        wp_enqueue_script('trainee_here_service');
        wp_enqueue_script('trainee_here_ui');
        wp_enqueue_script('trainee_here_mapevents');
    }

    /**
     * Add content after body tag
     */
    public function trainee_add_content_after_body_tag() {

        ?>
            <div class="loadingScreen">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
        <?php

    }


    public function trainee_add_modals() {
        if(!is_user_logged_in()){
            $loginTitle = __('Login', 'trainee');
            $forgotTitle = __('Password Recovery', 'trainee');
            echo do_shortcode("[trainee_modal modalid=\"trLoginModal\" modaltitle=\"{$loginTitle}\"] [trainee_user_login] [/trainee_modal]");
            echo do_shortcode("[trainee_modal modalid=\"trRecoveryModal\" modaltitle=\"{$forgotTitle}\"] [trainee_password_recovery]     [/trainee_modal]");
        }

    }

    /**
     * Return post meta
     */
    public static function lctrainee_get_post_meta( $value, $post_id=false )
    {
        global $post;
        $id = !$post_id ? $post->ID : $post_id;
        $field = get_post_meta( $id, $value, true );
        if ( ! empty( $field ) ) {
            return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
        } else {
            return false;
        }
    }

    /**
     * Return user meta
     */
    public static function lctrainee_get_user_meta( $value, $user_id )
    {

        $field = get_user_meta( $user_id, $value, true );
        if ( ! empty( $field ) ) {
            return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
        } else {
            return false;
        }
    }

    /**
     * Register indicator setting
     */
    public function register_trainee_setting() {
        $args = array(
            'type' => 'object',
            'sanitize_callback' => null,
            'default' => NULL,
            'show_in_rest' => false,
        );
        register_setting( '_trainee_energy_setting', '_ee_indicator', $args );
    }

    // Custom Sidebars
    function trainee_custom_sidebars() {
        register_sidebar(
            array(
                'name'          => esc_html__( 'Cause/Solutions Sidebar', 'trainee' ),
                'id'            => 'cause-solution-sidebar',
                'description'   => esc_html__( 'Add widgets here.', 'trainee' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }

    // GLOBAL SETTINGS

    //Register settings
    public function global_options_add(){
        register_setting( 'global_settings', 'global_settings' );
    }
    //Initialize options page
    public function add_global_options() {
        add_menu_page( __( 'Global Options' ), __( 'Global Options' ), 'manage_options', 'settings', [$this, 'global_options_page']);
    }
    //Restrict page for non admins
    public function restrict_admin(){
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __('You are not allowed to access this part of the site') );
        }
    }
    //Initialize options page
    public function global_options_page() {
        if ( ! isset( $_REQUEST['updated'] ) )
            $_REQUEST['updated'] = false;

            include TRAINEE_PLUGIN_DIR . '/views/admin/global-settings.php';
    }



    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {

        add_filter('register_post_type_args', [$this, 'trainee_remove_default_post_type'], 0, 2);
        add_action( 'admin_menu', [$this, 'lctrainee_comments_remove_admin_menus'] );
        add_action('init', [$this, 'lctrainee_remove_comment_support'], 100);
        add_action( 'admin_init', [$this, 'register_trainee_setting'] );
        add_action( 'wp_before_admin_bar_render', [$this, 'lctrainee_admin_bar_render_no_comments'] );
        add_filter('admin_footer_text', [$this, 'remove_footer_admin']);
        add_action( 'admin_menu', [$this, 'lctrainee_remove_dashboard_menu_items']);
        add_action('wp_before_admin_bar_render', [$this, 'annointed_admin_bar_remove'], 0);
        add_action( 'admin_bar_menu', [$this, 'add_my_own_logo'], 1 );
        add_action( 'wp_enqueue_scripts', [$this, 'lctrainee_public_assets'], 1 );
        add_action('wp_body_open', [$this, 'trainee_add_content_after_body_tag']);
        add_action('wp_footer', [$this, 'trainee_add_modals']);
        add_action( 'widgets_init', [$this, 'trainee_custom_sidebars'] );
        add_action('after_setup_theme', [$this, 'remove_admin_bar']);

        //Grant access to options page
        add_action( 'admin_init', [$this, 'global_options_add'] );
        add_action( 'admin_menu', [$this, 'add_global_options'] );
        //Restrict admin
        add_action( 'admin_init', [$this, 'restrict_admin']);


        //string Resources and global js variables
        LcTrainee_String_Resources::getInstance();

        //Get custom posts
        LcTrainee_Cpt::getInstance();
        LcTrainee_Taxonomies::getInstance();
        LcTrainee_Metaboxes::getInstance();

        //Manage custom users
        LcTrainee_Users::getInstance();

        //Login protect
        LcTrainee_Login_Shield::getInstance();

        //Api routes
        LcTrainee_Api_Routes::getInstance();

        //Init shortcodes
        LcTrainee_Shortcodes::getInstance();

        // Street filter
        LcTrainee_Profile_Actions::getInstance();

        // Load admin assets
        LcTrainee_Admin_Scripts::getInstance();

        //widgets init
        LcTrainee_Widgets::getInstance();

        //Dashboard page
        LcTrainee_Dashboard_Page::getInstance();
    }
}
