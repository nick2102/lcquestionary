<?php
/**
 * LcTrainee_Profile_Actions
 *
 * User related methods for profile actions
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Profile_Actions
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Auth();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {
        add_filter( 'posts_where', [$this, 'street_slug_filter'], 10, 2 );
    }

    /**
     * Get Building Addresses
     */
    public function trainee_serach_buildings(WP_REST_Request $request)
    {
        $args = [
            'posts_per_page' => -1,
            'nopaging' => true,
            'post_type' => 'building',
            'post_status' => 'publish',
            'street_slug' => sanitize_text_field($request->get_param('street_slug')),
        ];

        if($request->get_param('city') && $request->get_param('city') !== '') {
            $args['tax_query'] = [
                'relation' => 'AND',
                array(
                    'taxonomy' => 'lctrainee_building_city',
                    'field' => 'slug',
                    'terms' => array(sanitize_text_field($request->get_param('city'))),
                    'operator' => 'IN'
                ),
            ];
        }

        if ( function_exists('icl_object_id') ) {
            global $sitepress;
            $lang = $request->get_param('l');
            $sitepress->switch_lang($lang);
        }

        $query = new WP_Query($args);
        $buildings = [];

        if($query->have_posts()) {
            foreach ($query->get_posts() as $key => $post) {
                $buildings[$key]['label'] = $post->post_title;
                $buildings[$key]['value'] = [ 'id'=> $post->ID, 'certificate'=> get_post_meta($post->ID,'lc_trainee_building_energy_mark_certificate', true), 'long' => get_post_meta($post->ID,'lc_trainee_building_long', true), 'lat' => get_post_meta($post->ID,'lc_trainee_building_lat', true)];
            }
        }

        return new WP_REST_Response( $buildings, 200 );
    }

    /**
     * Save profile questionnaire
     */
    public function save_profile_questionnaire(WP_REST_Request $request)
    {
        if(!is_user_logged_in()) {
            return new WP_Error( 'Operation failed',  __('You are not logged in!', 'trainee'), array( 'status' => 500, "error" =>  __('You are not logged in!', 'trainee') ."<br>"));
        }

        $userID = LcTrainee_Users::trainee_user_id();
        $questionnaire_id = sanitize_text_field($request->get_param('questionnaire_id'));
        $formData = $request->get_param('questionnaireData');

        $energyProfile = [];

        foreach ($formData as $input){
            if($input['name'] === 'have_certificate' || $input['name'] ==='building_id' && $input['value'] === ""){
                $energyProfile[$input['name']] = false;
            } else {
                $energyProfile[$input['name']] = $input['value'];
            }
        }

        $questionnaire  = unserialize(LcTrainee::lctrainee_get_post_meta('_lctrainee_questionnaire', $questionnaire_id));
        $buildingInfoPoints = (int)$energyProfile['yearOfConstructionPoints'] + (int)$energyProfile['sizeInSquarePoints'] + (int)$energyProfile['occupantsPoints'];

        $energyPoints = [
            'building_info' => $buildingInfoPoints,
        ];

        $possibleSolutions = [];

        foreach ($questionnaire as $key => $tabs) {
            $questionName = $key.'_q_';
            $solutionName = '_possible_solution';

            foreach ($energyProfile as $name=>$value) {
                if (strpos($name, $questionName) !== false && strpos($name, $solutionName) === false) {
                    $energyPoints[$key] = isset($energyPoints[$key]) ? (int)$energyPoints[$key] + (int)$value : (int)$value;
                }

                if (strpos($name, $solutionName) !== false && strpos($name, $questionName) !== false && $value !== "") {
                    $solution = json_decode($value);
                    if (!empty($solution->hasSolution))
                        $possibleSolutions[$key][] = $solution;
                }
            }
        }

        foreach ($energyPoints as $value) {
            $energyPoints['total'] = isset($energyPoints['total']) ? (int)$energyPoints['total'] + (int)$value : (int)$value;
        }

        update_user_meta($userID, '_lctrainee_is_certified', false);
        update_user_meta($userID, '_lctrainee_certified_building_id', sanitize_text_field($request->get_param('building_id')));
        update_user_meta($userID, '_lctrainee_questionnaire_done', true);
        update_user_meta($userID, '_lctrainee_questionnaire_id', $questionnaire_id);
        update_user_meta($userID, '_lctrainee_energy_profile', serialize($energyProfile));
        update_user_meta($userID, '_lctrainee_energy_profile_points', serialize($energyPoints));
        update_user_meta($userID, '_lctrainee_energy_possible_solutions', serialize($possibleSolutions));

        return new WP_REST_Response( ["status" => "OK", 'message' => __('Questionnaire successfully saved!', 'trainee')], 200 );
    }

    /**
     * Save profile questionnaire When certified building is selected
     */
    public function save_profile_questionnaire_certified(WP_REST_Request $request) {

        if(!is_user_logged_in()) {
            return new WP_Error( 'Operation failed',  __('You are not logged in!', 'trainee'), array( 'status' => 500, "error" =>  __('You are not logged in!', 'trainee') ."<br>"));
        }

       $userID = LcTrainee_Users::trainee_user_id();
       $is_certified = sanitize_text_field($request->get_param('is_certified'));
       $questionnaire_id = sanitize_text_field($request->get_param('questionnaire_id'));

       if($is_certified && $is_certified === 'true'){

           $energyProfile = [
                  'residence_type' => sanitize_text_field($request->get_param('residence_type')),
                  'residence_city' => sanitize_text_field($request->get_param('residence_city')),
                  'address' => sanitize_text_field($request->get_param('address')),
                  'yearOfConstruction' => sanitize_text_field($request->get_param('yearOfConstruction')),
                  'sizeInSquare' => sanitize_text_field($request->get_param('sizeInSquare')),
                  'occupants' => sanitize_text_field($request->get_param('occupants')),
                  'building_id' => sanitize_text_field($request->get_param('building_id')),
           ];

           update_user_meta($userID, '_lctrainee_is_certified', true);
           update_user_meta($userID, '_lctrainee_certified_building_id', sanitize_text_field($request->get_param('building_id')));
           update_user_meta($userID, '_lctrainee_questionnaire_done', true);
           update_user_meta($userID, '_lctrainee_questionnaire_id', $questionnaire_id);
           update_user_meta($userID, '_lctrainee_energy_profile', serialize($energyProfile));
           return new WP_REST_Response( ["status" => "OK",'message' => __('Questionnaire successfully saved!', 'trainee')], 200 );
       }

        return new WP_REST_Response( ["status" => "OK",'message' => __('Questionnaire successfully saved!', 'trainee')], 200 );
    }

    /**
     * Search by term substring filter
     */
    public function street_slug_filter($where, $query) {
        $label = $query->query['street_slug'] ?? '';
        if($label !== '') {
            global $wpdb;

            $where .= ' AND ' . $wpdb->posts . '.post_name LIKE '. '\'%'.$label .'%\'';
        }

        return $where;
    }
}

