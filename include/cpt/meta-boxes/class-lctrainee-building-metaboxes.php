<?php

/**
 * LcTrainee_Building_Metaboxes
 *
 * Creating custom post types Metaboxes
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Building_Metaboxes
{
    private static $instance = null;

    private  static $metaboxSettings = [];

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Building_Metaboxes();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        // class initialization
        self::$metaboxSettings = self::generateBuildingMetaBoxes();
        $this->init();
    }

    public function load_media_files() {
        wp_enqueue_media();
    }

    private static function generateBuildingMetaBoxes ()
    {
        $buildingInfo =  array(
            ['prefix' => '', 'id' => 'lc_trainee_building_investor', 'label' => __('Investor', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_building_energy_mark_certificate', 'label' => __('Energy mark', 'trainee'), 'type' => 'select', 'options' => ['a_plus'=>'A+', 'a' => 'A', 'b'=>'B', 'c' => 'C', 'd' => 'D', 'e' => 'E', 'f' => 'F', 'g' => 'G']],
            ['prefix' => '', 'id' => 'lc_trainee_building_needed_heating_energy', 'label' => __('Needed heating energy', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_building_primary_energy', 'label' => __('Primary energy', 'trainee'), 'type' => 'text'],
            ['prefix' => '', 'id' => 'lc_trainee_building_certificate', 'label' => __('Certificate', 'trainee'), 'type' => 'file'],
        );

        $buildingMap = array(
            ['prefix' => '', 'id' => 'lc_trainee_building_lat', 'label' => '', 'type' => 'hidden'],
            ['prefix' => '', 'id' => 'lc_trainee_building_long', 'label' => '', 'type' => 'hidden'],
            ['prefix' => '', 'id' => 'lc_trainee_building_map', 'label' => '', 'type' => 'map'],
        );

       return  array(
            ['postType' => 'building', 'id' => 'lc_trainee_building_info', 'title' => __('Building Info', 'trainee'), 'callabackFunction' => 'lctrainee_building_info_render', 'context' => 'normal', 'priority' => 'high', 'fields' => $buildingInfo],
            ['postType' => 'building', 'id' => 'lc_trainee_building_map', 'title' => __('Building Map', 'trainee'), 'callabackFunction' => 'lctrainee_building_map_render', 'context' => 'normal', 'priority' => 'high', 'fields' => $buildingMap],
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

    public static function lctrainee_building_info_render()
    {
        wp_nonce_field( 'lc_trainee_building_info', 'lc_trainee_building_info_nonce' );
        $metaboxes = self::$metaboxSettings;
        $fields = LcTrainee_Metafield_Generator::lc_return_fields('id', 'lc_trainee_building_info', $metaboxes);
        foreach ($fields as $field){
            echo LcTrainee_Metafield_Generator::generate_meta_box_field($field);
        }
    }

    public function lctrainee_building_map_render()
    {
        wp_nonce_field( 'lc_trainee_building_map', 'lc_trainee_building_map_nonce' );
        $metaboxes = self::$metaboxSettings;
        $fields = LcTrainee_Metafield_Generator::lc_return_fields('id', 'lc_trainee_building_map', $metaboxes);
        foreach ($fields as $field){
            echo LcTrainee_Metafield_Generator::generate_meta_box_field($field);
        }
    }

}