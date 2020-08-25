<?php

/**
 * LcTrainee_Company_Metaboxes
 *
 * Creating custom post types Metaboxes
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Company_Metaboxes
{
    private static $instance = null;

    private  static $metaboxSettings = [];

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Company_Metaboxes();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        // class initialization
        self::$metaboxSettings = self::generateCompanyMetaBoxes();
        $this->init();
    }

    public function load_media_files() {
        wp_enqueue_media();
    }

    private static function generateCompanyMetaBoxes ()
    {
        $logoFields = array(
            ['prefix' => '', 'id' => 'lc_trainee_company_logo', 'label' => '', 'type' => 'media']
        );

        $shortDesc = array(
            ['prefix' => '', 'id' => 'lc_trainee_company_short_description', 'label' => __('Enter short description about the company', 'trainee'), 'type' => 'textarea']
        );

        $contact =  array(
            ['prefix' => '', 'id' => 'lc_trainee_company_phone', 'label' => __('Phone', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_company_fax', 'label' => __('Fax', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_company_mobile', 'label' => __('Mobile', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_company_email', 'label' => __('Email', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_company_website', 'label' => __('Website', 'trainee'), 'type' => 'text'],
        );

       return  array(
            ['postType' => 'company', 'id' => 'lc_trainee_company_logo', 'title' => __('Company Logo', 'trainee'), 'callabackFunction' => 'lctrainee_company_logo_render', 'context' => 'side', 'priority' => 'high', 'fields' => $logoFields],
            ['postType' => 'company', 'id' => 'lc_trainee_company_short_description', 'title' => __('Company Short Description', 'trainee'), 'callabackFunction' => 'lctrainee_company_short_description_render', 'context' => 'normal', 'priority' => 'high', 'fields' => $shortDesc],
            ['postType' => 'company', 'id' => 'lc_trainee_company_contact', 'title' => __('Company Contact', 'trainee'), 'callabackFunction' => 'lctrainee_company_contact_render', 'context' => 'normal', 'priority' => 'high', 'fields' => $contact ],
        );
    }


    /**
     * Function to register the metaboxes in companys CPT
     */
    public function lc_trainee_register_company_metaboxes()
    {

        foreach (self::$metaboxSettings as $key => $metabox) {
            add_meta_box(
                $metabox['id'],
                $metabox['title'],
                [ $this,  $metabox['callabackFunction'] ],
                $metabox['postType'],
                $metabox['context'],
                $metabox['priority']
            );
        }
    }

    /**
     * Functions to save metabox
     */

    public function lc_trainee_company_metabox_save( $post_id )
    {
        return LcTrainee_Metafield_Generator::lc_save_meta_fields_value($post_id, self::$metaboxSettings);
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_action( 'add_meta_boxes', [ $this, 'lc_trainee_register_company_metaboxes' ] );
        add_action( 'admin_enqueue_scripts',  [ $this, 'load_media_files' ]);
        add_action( 'save_post', [ $this, 'lc_trainee_company_metabox_save' ] );
        LcTrainee_Metafield_Generator::getInstance();
    }

    /**
     * HTML Rendering for meta boxes
     */
    public static function lctrainee_company_logo_render()
    {
        wp_nonce_field( 'lc_trainee_company_logo', 'lc_trainee_company_logo_nonce' );

        $metaboxes = self::$metaboxSettings;
        $fields = LcTrainee_Metafield_Generator::lc_return_fields('id', 'lc_trainee_company_logo', $metaboxes);
        foreach ($fields as $field){
            echo LcTrainee_Metafield_Generator::generate_meta_box_field($field);
        }

    }

    public static function lctrainee_company_contact_render()
    {
        wp_nonce_field( 'lc_trainee_company_contact', 'lc_trainee_company_contact_nonce' );
        $metaboxes = self::$metaboxSettings;
        $fields = LcTrainee_Metafield_Generator::lc_return_fields('id', 'lc_trainee_company_contact', $metaboxes);
        foreach ($fields as $field){
            echo LcTrainee_Metafield_Generator::generate_meta_box_field($field);
        }
    }

    public static function lctrainee_company_short_description_render()
    {
        wp_nonce_field( 'lc_trainee_company_short_description', 'lc_trainee_company_short_description_nonce' );
        $metaboxes = self::$metaboxSettings;
        $fields = LcTrainee_Metafield_Generator::lc_return_fields('id', 'lc_trainee_company_short_description', $metaboxes);
        foreach ($fields as $field){
            echo LcTrainee_Metafield_Generator::generate_meta_box_field($field);
        }
    }

}