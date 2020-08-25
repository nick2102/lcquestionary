<?php
/**
 * LcTrainee_Public_Api
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Public_Api
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Public_Api();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {

    }

    /**
     *  Load More Companies
     */

    public function load_more_companies (WP_REST_Request $request)
    {
        $offset = sanitize_text_field($request->get_param('offset'));

        $args = [
            'post_type' => 'company',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'ASC',
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
            'offset' => $offset
        ];
        $companies = new WP_Query($args);

        ob_start();
        while ($companies->have_posts()) : $companies->the_post();
            include TRAINEE_PLUGIN_DIR . 'views/shortcodes/companies/company.php';
        endwhile;
        wp_reset_postdata();

        $response = ob_get_clean();

        return new WP_REST_Response( ["status" => "OK",'html' => $response], 200 );
    }

}