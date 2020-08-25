<?php
/**
 * LcTrainee
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Admin_Scripts
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Admin_Scripts();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        $this->init();
    }

    /**
     * Load admin scripts
     */

    public function lctrainee_enqueue_admin_scripts ()
    {
        global $pagenow;
        if(is_user_logged_in() && ( current_user_can('administrator') || current_user_can('expert') ) ) {
            wp_register_style( 'trainee_admin_style', TRAINEE_PLUGIN_URL . 'assets/css/admin/admin-style.css', ['wp-mediaelement'], '1.0.0' );
            wp_register_style( 'multi-select', TRAINEE_PLUGIN_URL . 'assets/css/admin/multi-select.dist.css', ['wp-mediaelement'], '1.0.0' );
            wp_register_style( 'here_ui_css',  'https://js.api.here.com/v3/3.1/mapsjs-ui.css', ['wp-mediaelement'], '1.0.0' );
            wp_enqueue_style( 'multi-select' );
            wp_enqueue_style( 'trainee_admin_style' );
            wp_enqueue_style( 'here_ui_css' );
        }

        wp_register_script('trainee_admin_dist', TRAINEE_PLUGIN_URL . 'assets/js/admin_dist/admin-trainee.min.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
        wp_register_script('trainee_here_maps', 'https://js.api.here.com/v3/3.1/mapsjs-core.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_service','https://js.api.here.com/v3/3.1/mapsjs-service.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_ui','https://js.api.here.com/v3/3.1/mapsjs-ui.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_mapevents','https://js.api.here.com/v3/3.1/mapsjs-mapevents.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', false);
        wp_register_script('trainee_here_init',TRAINEE_PLUGIN_URL . 'assets/js/admin/map-init.js', ['jquery', 'jquery-ui-sortable', 'trainee_here_maps', 'trainee_here_service'], '1.0.0', false);
        wp_enqueue_script('trainee_admin_dist');

        if(isset($_GET['post_type']) && $_GET['post_type'] === 'building' || isset($_GET['post']) && get_post_type($_GET['post']) === 'building' ) {
            if($pagenow === 'post-new.php' || ($pagenow === 'post.php' && $_GET['action'] === 'edit')) {
                wp_enqueue_script('trainee_here_maps');
                wp_enqueue_script('trainee_here_service');
                wp_enqueue_script('trainee_here_ui');
                wp_enqueue_script('trainee_here_mapevents');
                wp_enqueue_script('trainee_here_init');

                $dataToBePassed = array(
                    'home'            => get_stylesheet_directory_uri(),
                    'buildings' => [
                        'lng' => isset($_GET['post']) ? get_post_meta($_GET['post'], 'lc_trainee_building_long', true) : 21.43141,
                        'lat' => isset($_GET['post']) ? get_post_meta($_GET['post'], 'lc_trainee_building_lat', true) : 41.99646
                    ],
                    'traineeApiUrl' => get_rest_url(null, TRAINEE_PLUGIN_API_NAMESPACE),
                    'hereMapsKey' => TRAINEE_HERE_MAPS_API_KEY,
                    'translations' => [
                        'errorTitle'=> __('Error', 'trainee'),
                        'requiredFields'=> __('All fields are required.', 'trainee'),
                        'mapsServerError'=> __('Can not reach the remote server', 'trainee'),
                    ],
                );
                wp_localize_script( 'trainee_here_init', 'wpVars', $dataToBePassed );
            }
        }
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_action( 'admin_enqueue_scripts', [$this, 'lctrainee_enqueue_admin_scripts'] );
        add_action( 'wp_enqueue_scripts', [$this, 'lctrainee_enqueue_admin_scripts'] );
    }
}