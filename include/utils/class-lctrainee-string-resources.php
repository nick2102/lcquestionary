<?php
/**
 * LcTrainee_String_Resources
 *
 * String resources for js
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class  LcTrainee_String_Resources
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_String_Resources();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {
        add_action('wp_head', [$this, 'lctrainee_js_string_resources']);
        add_action('admin_head', [$this, 'lctrainee_js_string_resources']);
        
    }
    /**
     * Add string translations to js
     */
    public static function lctrainee_js_string_resources()
    {
        $globalSettings = get_option( 'global_settings' );
        
        $questionnairePageId    =   function_exists('icl_object_id') && $globalSettings['questionnaire_page']    ? apply_filters( 'wpml_object_id',  $globalSettings['questionnaire_page'])    : $globalSettings['questionnaire_page'];
        $energyProfilePageId    =   function_exists('icl_object_id') && $globalSettings['energy_profile_page']   ? apply_filters( 'wpml_object_id',  $globalSettings['energy_profile_page'])   : $globalSettings['energy_profile_page'];
        $expertRegisterPageId   =   function_exists('icl_object_id') && $globalSettings['expert_register']       ? apply_filters( 'wpml_object_id',  $globalSettings['expert_register'])       : $globalSettings['expert_register'];
        $residentRegisterPageId =   function_exists('icl_object_id') && $globalSettings['resident_register']     ? apply_filters( 'wpml_object_id',  $globalSettings['resident_register'])     : $globalSettings['resident_register'];
        $resetPwdPageId         =   function_exists('icl_object_id') && $globalSettings['reset_pwd_register']    ? apply_filters( 'wpml_object_id',  $globalSettings['reset_pwd_register'])    : $globalSettings['reset_pwd_register'];
        $recoveryPwdPageId      =   function_exists('icl_object_id') && $globalSettings['recovery_pwd_register'] ? apply_filters( 'wpml_object_id',  $globalSettings['recovery_pwd_register']) : $globalSettings['recovery_pwd_register'];
        $changePwdPageId        =   function_exists('icl_object_id') && $globalSettings['change_pwd_register']   ? apply_filters( 'wpml_object_id',  $globalSettings['change_pwd_register'])   : $globalSettings['change_pwd_register'];

        ?>
        <script>
            window.traineeApiUrl = '<?php echo get_rest_url(null, TRAINEE_PLUGIN_API_NAMESPACE);?>';
            window.hereMapsKey = <?php echo json_encode(TRAINEE_HERE_MAPS_API_KEY); ?>;

            window.traineeTranslations = {
                errorTitle: '<?php  _e('Error', 'trainee') ?>',
                wrongLogin: '<?php  _e('Invalid login details', 'trainee') ?>',
                successTitle: '<?php  _e('Success', 'trainee') ?>',
                requiredField : '<?php _e('This field is required.', 'trainee'); ?>',
                requiredFields : '<?php _e('All fields are required.', 'trainee'); ?>',
                requiredQuestions : '<?php _e('All questions are required.', 'trainee'); ?>',
                validEmail : '<?php _e('Please enter a valid email address.', 'trainee'); ?>',
                digitsOnly : '<?php _e('Please enter only digits.', 'trainee'); ?>',
                validUrl : '<?php _e('Please enter a valid URL.', 'trainee'); ?>',
                validNumber : '<?php _e('Please enter a valid number.', 'trainee'); ?>',
                addQuestion: '<?php _e('Add Question', 'trainee'); ?>',
                question: '<?php _e('Question', 'trainee'); ?>',
                addOption: '<?php _e('Add Option', 'trainee'); ?>',
                option: '<?php _e('Option', 'trainee'); ?>',
                multipleChoice: '<?php _e('Multiple choice', 'trainee'); ?>',
                tip: '<?php _e('Tip', 'trainee'); ?>',
                icon: '<?php _e('Icon', 'trainee'); ?>',
                optionName: '<?php _e('Option Name', 'trainee'); ?>',
                lossIn: '<?php _e('Points', 'trainee'); ?>',
                selectIcon: '<?php _e('Select Icon', 'trainee'); ?>',
                yes: '<?php _e('Yes', 'trainee'); ?>',
                no: '<?php _e('No', 'trainee'); ?>',
                mandatory: '<?php _e('Mandatory', 'trainee'); ?>',
                noEmptyTab: '<?php _e('Tab name can not be empty', 'trainee'); ?>',
                tabExists: '<?php _e('Tab already exists!', 'trainee'); ?>',
                title: '<?php _e('Title', 'trainee'); ?>',
                deleteTab: '<?php _e('Delete tab', 'trainee'); ?>',
                deleteTabText: '<?php _e('Delete this tab', 'trainee'); ?>',
                exportImportEmpty: '<?php _e('Export/Import field can not be empty!', 'trainee'); ?>',
                mapsServerError: '<?php _e('Can not reach the remote server', 'trainee'); ?>',
                energyMark: '<?php _e('Energy Mark', 'trainee'); ?>',
                investor: '<?php _e('Investor', 'trainee'); ?>',
                viewCertificate: '<?php _e('View certificate', 'trainee'); ?>',
                selectAddress: '<?php _e('Select address', 'trainee'); ?>',
                sectionCoverImage: '<?php _e('Select Image', 'trainee'); ?>',
                tabName: '<?php _e('Tab Name', 'trainee'); ?>',
                possibleSolution: '<?php _e('Possible Solution', 'trainee'); ?>',
                tabRegex: '<?php _e('Special characters are not allowed. <br> No white space at the beginning of the name. <br> Use only letters and numbers. <br> Minimum 2 characters.', 'trainee'); ?>',
            }

            window.restNonce = '<?php echo wp_create_nonce('wp_rest'); ?>';
            window.currentLang = '<?php echo ICL_LANGUAGE_CODE; ?>';
            window.questionnairePage = <?php echo json_encode(get_the_permalink($questionnairePageId)); ?>;
            window.energyProfilePage = <?php echo json_encode(get_the_permalink($energyProfilePageId)); ?>;
            window.expertRegisterPage = <?php echo json_encode(get_the_permalink($expertRegisterPageId)); ?>;
            window.residentRegisterPage = <?php echo json_encode(get_the_permalink($residentRegisterPageId)); ?>;
            window.resetPwdPage = <?php echo json_encode(get_the_permalink($resetPwdPageId)); ?>;
            window.recoveryPwdPage = <?php echo json_encode(get_the_permalink($recoveryPwdPageId)); ?>;
            window.changePwdPage = <?php echo json_encode(get_the_permalink($changePwdPageId)); ?>;
            window.homeUrl = '<?php echo get_site_url(); ?>';
        </script>
        <?php

    }
}