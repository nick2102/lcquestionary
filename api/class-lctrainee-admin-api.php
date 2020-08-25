<?php
/**
 * LcTrainee_Auth
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Admin_Api
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Admin_Api();
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
     * Save Questionnaire data
     */

    public function save_questionnaire_data(WP_REST_Request $request) {
        $formData = json_decode($request->get_param('questionnaireData'));
        update_option( 'lctrainee_questionnaire_data', serialize($formData), false );
        return new WP_REST_Response( ["status" => "OK", 'message' => __('Questionnaire successfully saved!', 'trainee')], 200 );
    }

    /**
     * Save EE indicator data
     */
    public function save_ee_indicator_data(WP_REST_Request $request)
    {
        $formData = json_decode($request->get_param('eeIndicatorData'));
        update_option( '_ee_indicator', serialize($formData), false );
        return new WP_REST_Response( ["status" => "OK", 'message' => __('EE Indicator successfully saved!', 'trainee')], 200 );
    }

    /**
     * Get Q Solution tabs
     */
    public function get_q_solutions_tabs(WP_REST_Request $request)
    {
        $post_id = sanitize_text_field($request->get_param('post_id'));
        $tabs = unserialize(LcTrainee::lctrainee_get_post_meta('_lctrainee_questionnaire', $post_id));
        $solutionsSettings = unserialize(LcTrainee::lctrainee_get_post_meta('_lctrainee_solutions_settings', $post_id));
        $rangesSettings = unserialize(LcTrainee::lctrainee_get_post_meta('_lctrainee_ranges_settings', $post_id));

        $solutionSections = get_terms([
            'taxonomy' => 'lctrainee_cause_section',
            'hide_empty' => true,
        ]);

        $causeSolutions = [];

        foreach ($solutionSections as $section){
            $args = [
                'post_type' => 'cause-solution',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
                'post_status' => 'publish',
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'lctrainee_cause_section',
                        'field'    => 'term_id',
                        'terms'    => array( $section->term_id ),
                    )
                )
            ];

            $query = new WP_Query($args);

            $causeSolutions[$section->slug]['name'] = $section->name;
            $causeSolutions[$section->slug]['solutions'] = $query->get_posts();
        }

        if( !$tabs || count((array)$tabs) < 1 ){
            return new WP_Error(500, __('Please create questions for this questionnaire first', 'trainee'));
        }

        ob_start();
            include TRAINEE_PLUGIN_DIR . '/views/admin/q-solutions-panel.php';
        $tabsTemplate = ob_get_clean();

        return new WP_REST_Response( ["status" => "OK", 'tabs' => $tabsTemplate ], 200 );
    }

    /**
     * Save Q Solution tabs
     */
    public function save_q_solutions_tabs(WP_REST_Request $request)
    {
        $post_id = sanitize_text_field($request->get_param('post_id'));
        $tabs = json_decode($request->get_param('solutions'));
        $ranges = json_decode($request->get_param('ranges'));

//        print_r($tabs);

        update_post_meta( $post_id, '_lctrainee_solutions_settings', serialize($tabs) );
        update_post_meta( $post_id, '_lctrainee_ranges_settings', serialize($ranges) );

        return new WP_REST_Response( ["status" => "OK", 'data'=>[$post_id, $tabs], 'message' => __('Solutions successfully saved!', 'trainee')], 200 );
    }
}