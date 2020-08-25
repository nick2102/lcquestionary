<?php
/**
 * LcTrainee_Shortcodes
 *
 * Creating custom  Users
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class  LcTrainee_Shortcodes
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Shortcodes();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Login shortcode output
     */
    public static function trainee_user_login () {
        if(is_user_logged_in())
            return false;

        return LcTrainee_Render_View::view('auth/login');
    }

    /**
     * Register shortcode output
     */
    public static function trainee_user_register ($atts , $content = null) {
        if(is_user_logged_in())
            return false;

        $attributes = shortcode_atts(
            array(
                'role' => 'resident',
            ),  $atts);

        $data = [
            'role' => $attributes['role'],
        ];

        return LcTrainee_Render_View::view('auth/register', $data);
    }

    /**
     * Password recovery shortcode output
     */
    public static function trainee_password_recovery () {
        if(is_user_logged_in())
            return false;

        return LcTrainee_Render_View::view('auth/password-recovery');
    }

    /**
     * Password reset shortcode output
     */
    public static function trainee_password_reset () {
        if(is_user_logged_in())
            return false;

        return LcTrainee_Render_View::view('auth/password-reset');
    }

    /**
     * Password change shortcode output
     */
    public static function trainee_password_change () {
        if(!is_user_logged_in())
            return LcTrainee_Render_View::view('auth/login');
        else
            return LcTrainee_Render_View::view('auth/password-change');
    }

    /**
     *  List of shortcodes output
     */
    public function trainee_get_shortcode_list () {

        $shortcodes = [
            [ 'title' => __('User Login Form', 'trainee'), 'shortcode' => '[trainee_user_login]'],
            [ 'title' => __('User Register Form', 'trainee'), 'shortcode' => '[trainee_user_register]'],
            [ 'title' => __('User Password Recovery Form', 'trainee'), 'shortcode' => '[trainee_password_recovery]'],
            [ 'title' => __('User Password Reset Form', 'trainee'), 'shortcode' => '[trainee_password_reset]'],
            [ 'title' => __('User Change Password Form', 'trainee'), 'shortcode' => '[trainee_password_change]'],
            [ 'title' => __('User Energy Profile', 'trainee'), 'shortcode' => '[trainee_energy_profile]'],
            [ 'title' => __('List of companies', 'trainee'), 'shortcode' => '[trainee_list_of_companies]'],
            [ 'title' => __('Modal Shortcode', 'trainee'), 'shortcode' => htmlentities('[trainee_modal modalid="exampleId" modaltitle="Example"] Modal Content here... [/trainee_modal]')],
        ];

        return LcTrainee_Render_View::view('shortcode-list', $shortcodes);
    }

    /**
     *  Modal Shortcode
     */
    public function trainee_modal($atts , $content = null) {

        $attributes = shortcode_atts(
            array(
                'modalid' => '',
                'modaltitle' => '',
            ),  $atts);

        $data = [
            'modalID' => $attributes['modalid'],
            'modalTitle' => $attributes['modaltitle'],
            'modalContent' => do_shortcode($content),
        ];

        return LcTrainee_Render_View::view('trainee-modal', $data);
    }

    /**
     *  Questionnaire Shortcode
     */
    public function trainee_questionnaire( $atts , $content = nul )
    {
        if(!is_user_logged_in())
            return LcTrainee_Render_View::view('auth/login', []);

        $attributes = shortcode_atts(
            array(
                'id' => '',
            ),  $atts);

        $args = [
            'posts_per_page' => -1,
            'nopaging' => true,
            'post_type' => 'building',
            'post_status' => 'publish',
        ];

        $cities = get_terms('lctrainee_building_city', ['hide_empty' => false]);

        $query = new WP_Query($args);
        $buildings = [];

        foreach ($query->get_posts() as $post){
            $post->meta = get_post_meta($post->ID);
            $buildings[] = $post;
        }

        $questionnaireID = function_exists('icl_object_id') ? apply_filters( 'wpml_object_id', $attributes['id'], 'post' ) : $attributes['id'];

        $questionnaire  = LcTrainee::lctrainee_get_post_meta('_lctrainee_questionnaire', $questionnaireID);
        $ranges  = LcTrainee::lctrainee_get_post_meta('_lctrainee_ranges_settings', $questionnaireID);

        $profile = LcTrainee::lctrainee_get_user_meta('_lctrainee_energy_profile', LcTrainee_Users::trainee_user_id()) ?
            [
                'info' => unserialize(LcTrainee::lctrainee_get_user_meta('_lctrainee_energy_profile', LcTrainee_Users::trainee_user_id())),
                'is_certified' => LcTrainee::lctrainee_get_user_meta('_lctrainee_is_certified', LcTrainee_Users::trainee_user_id()),
                'coordinates' => [
                    'lat' => LcTrainee::lctrainee_get_post_meta('lc_trainee_building_lat', LcTrainee::lctrainee_get_user_meta('_lctrainee_certified_building_id', LcTrainee_Users::trainee_user_id())),
                    'lng' => LcTrainee::lctrainee_get_post_meta('lc_trainee_building_long', LcTrainee::lctrainee_get_user_meta('_lctrainee_certified_building_id', LcTrainee_Users::trainee_user_id()))
                ]
            ]
            : false;

        $data = [ 'questionnaire_id' => $attributes['id'], 'questionnaire' => unserialize($questionnaire), 'buildings' => json_encode($buildings), 'cities' => $cities, 'profile' => $profile, 'ranges' =>  unserialize($ranges)];

        return LcTrainee_Render_View::view('questionnaire/questionnaire-wizard', $data);
    }

    /**
     *  Generate energy profile
     */
    public function trainee_energy_profile () {
        if(!is_user_logged_in())
            return LcTrainee_Render_View::view('auth/login', []);


        $userID = LcTrainee_Users::trainee_user_id();
        $is_certified = LcTrainee::lctrainee_get_user_meta('_lctrainee_is_certified', $userID);
        $energyProfile = unserialize(LcTrainee::lctrainee_get_user_meta('_lctrainee_energy_profile', $userID));
        $questionnaireId = function_exists('icl_object_id') ? apply_filters( 'wpml_object_id', LcTrainee::lctrainee_get_user_meta('_lctrainee_questionnaire_id', $userID), 'post' ) : LcTrainee::lctrainee_get_user_meta('_lctrainee_questionnaire_id', $userID);
        $qTabs = unserialize(get_post_meta($questionnaireId,'_lctrainee_questionnaire', true));
        $possibleSolutions = unserialize(LcTrainee::lctrainee_get_user_meta('_lctrainee_energy_possible_solutions', $userID));

        if(!LcTrainee::lctrainee_get_user_meta('_lctrainee_questionnaire_done', $userID))
            return LcTrainee_Render_View::view('energy-profile/finish-questionnaire', []);

        if($is_certified) {
            $buildingID = LcTrainee::lctrainee_get_user_meta('_lctrainee_certified_building_id', $userID);
            $buildingInfo = get_post($buildingID);
            $buildingMeta = get_post_meta($buildingID);
            $city = wp_get_post_terms($buildingID, 'lctrainee_building_city')[0];
            $building = ['info' => $buildingInfo, 'meta' => $buildingMeta, 'city' => $city, 'energyProfile' => $energyProfile];

            return LcTrainee_Render_View::view('energy-profile/certified-profile', $building);
        }

        $energyPoints =  unserialize(LcTrainee::lctrainee_get_user_meta('_lctrainee_energy_profile_points', $userID));
        $solutionSettings = unserialize( LcTrainee::lctrainee_get_post_meta('_lctrainee_solutions_settings', LcTrainee::lctrainee_get_user_meta('_lctrainee_questionnaire_id', $userID)));
        $eeIndicators = unserialize(get_option('_ee_indicator'));

        $post_ids  = ['0'];
        $solutions = [];
        foreach ($energyPoints as $pointsSection=>$points) {
            foreach ($solutionSettings as $setting){
                if (strpos($pointsSection, $setting->section) !== false && (int)$setting->minPoints >= $points ) {
                    if(!$setting->solutions)
                        $setting->solutions = [];

                    $post_ids = array_merge_recursive($post_ids, $setting->solutions );
                }
            }
        }

        $args = [
            'post_type' => 'cause-solution',
            'posts_per_page' => -1,
            'orderby' => 'random',
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
            'post__in' => $post_ids
        ];
        $solutions = new WP_Query($args);

        $level = LcTrainee_Helper::return_energy_level($energyPoints['total'], $eeIndicators);
        $energyMark = LcTrainee_Mapper::lctrainee_energy_marks_by_level($level);
        $data = [
            'energyProfile' => $energyProfile,
            'possibleSolutions' => $possibleSolutions,
            'energyLevel' => $level,
            'energyMark' => $energyMark,
            'energyPoints' => $energyPoints,
            'solutions' => $solutions,
            'qTabs' => json_encode($qTabs)
        ];

        return LcTrainee_Render_View::view('energy-profile/basic-profile', $data );
    }

    /**
     *  List of companies
     */
    public function trainee_list_of_companies () {

        $args = [
            'post_type' => 'company',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'ASC',
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
        ];
        $companies = new WP_Query($args);
        return LcTrainee_Render_View::view('companies/company-list', $companies );
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_shortcode('trainee_user_login',[$this, 'trainee_user_login']);
        add_shortcode('trainee_user_register',[$this, 'trainee_user_register']);
        add_shortcode('trainee_password_recovery',[$this, 'trainee_password_recovery']);
        add_shortcode('trainee_password_reset',[$this, 'trainee_password_reset']);
        add_shortcode('trainee_password_change',[$this, 'trainee_password_change']);
        add_shortcode('trainee_get_shortcode_list',[$this, 'trainee_get_shortcode_list']);
        add_shortcode( 'trainee_modal', [$this, 'trainee_modal'] );
        add_shortcode( 'trainee_questionnaire', [$this, 'trainee_questionnaire'] );
        add_shortcode( 'trainee_energy_profile', [$this, 'trainee_energy_profile'] );
        add_shortcode( 'trainee_list_of_companies', [$this, 'trainee_list_of_companies'] );
    }
}