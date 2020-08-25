<?php

class LcTrainee_Dashboard_Page {

    private static $instance = null;
    private $trainee_dashboard_options;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {
        if ( null == self::$instance &&  is_admin()) {
            self::$instance = new LcTrainee_Dashboard_Page();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'trainee_dashboard_add_plugin_page' ) );
    }

    public function trainee_dashboard_add_plugin_page()
    {
        add_menu_page(
            __('Control Panel', 'trainee'), // page_title
            __('Control Panel', 'trainee'), // menu_title
            'manage_options', // capability
            'trainee-control-panel', // menu_slug
            array( $this, 'trainee_dashboard_create_admin_page' ), // function
            'dashicons-dashboard', // icon_url
            3 // position
        );

        add_submenu_page(
            'edit.php?post_type=questionnaire',
            __('Energy efficiency indicator', 'trainee'), // page_title
            __('EE indicator', 'trainee'), // menu_title
            'manage_options', // capability
            'trainee-ee-indicator', // menu_slug
            array( $this, 'trainee_ee_indicator_page' ), // function
            5// position
        );

        add_submenu_page(
            'edit.php?post_type=questionnaire',
            __('Questionnaire solutions', 'trainee'), // page_title
            __('Questionnaire solutions', 'trainee'), // menu_title
            'manage_options', // capability
            'q-solutions', // menu_slug
            array( $this, 'trainee_q_solution_page' ), // function
            6// position
        );

        add_menu_page(
            __('Shortcode List', 'trainee'), // page_title
            __('Shortcode List', 'trainee'), // menu_title
            'manage_options', // capability
            'trainee-shortcode-list', // menu_slug
            array( $this, 'trainee_shortcode_list_page' ), // function
            'dashicons-plugins-checked', // icon_url
            7// position
        );
    }

    public function trainee_dashboard_create_admin_page()
    {
        $args = [
            'post_type' => 'cause-solution',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'date',
            'post_status' => 'pending'
        ];

        $userArgs = [
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => '_lctrainee_questionnaire_done',
                    'value'   => '1',
                    'compare' => 'LIKE'
                ),
            )
        ];

        // Create the WP_User_Query object
        $wp_user_query = new WP_User_Query($userArgs);

        $query = new WP_Query($args);
        $causes = $query->get_posts();
        $causesCount = $query->post_count;
        $questionnaires_number = $wp_user_query->get_results();

        include TRAINEE_PLUGIN_DIR . '/views/admin/control-panel.php';

    }

    public function trainee_shortcode_list_page() {
        echo do_shortcode('[trainee_get_shortcode_list]');
    }

    public function trainee_ee_indicator_page()
    {
        $indicator = (array)unserialize(get_option('_ee_indicator'));
        include TRAINEE_PLUGIN_DIR . '/views/admin/ee-indicator.php';
    }

    public function trainee_q_solution_page()
    {
        $args = [
            'post_type' => 'questionnaire',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'date',
            'post_status' => 'publish'
        ];

        $query = new WP_Query($args);
        $questionnaires = $query->get_posts();
        $solutions = (array)unserialize(get_option('_questionnaire_solutions'));
        include TRAINEE_PLUGIN_DIR . '/views/admin/q-solutions.php';
    }
}
