<?php
/**
 * LcTrainee_Cpt
 *
 * Creating custom post types
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Cpt
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Cpt();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        // plugin initialization
        $this->init();
    }

    /**
     * Register Custom Post Type
     */
    public function lc_trainee_company_cpt()
    {

        $labels = array(
            'name'                  => _x( 'Companies', 'Post Type General Name', 'trainee' ),
            'singular_name'         => _x( 'Company', 'Post Type Singular Name', 'trainee' ),
            'menu_name'             => __( 'Companies', 'trainee' ),
            'name_admin_bar'        => __( 'Company', 'trainee' ),
            'archives'              => __( 'Companies Archives', 'trainee' ),
            'attributes'            => __( 'Companies Attributes', 'trainee' ),
            'parent_item_colon'     => __( 'Companies Parent Item:', 'trainee' ),
            'all_items'             => __( 'All Companies', 'trainee' ),
            'add_new_item'          => __( 'Add New Company', 'trainee' ),
            'add_new'               => __( 'Add New Company', 'trainee' ),
            'new_item'              => __( 'New Company', 'trainee' ),
            'edit_item'             => __( 'Edit Company', 'trainee' ),
            'update_item'           => __( 'Update Company', 'trainee' ),
            'view_item'             => __( 'View Company', 'trainee' ),
            'view_items'            => __( 'View Companies', 'trainee' ),
            'search_items'          => __( 'Search Company', 'trainee' ),
            'not_found'             => __( 'Not found', 'trainee' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'trainee' ),
            'featured_image'        => __( 'Featured Image', 'trainee' ),
            'set_featured_image'    => __( 'Set featured image', 'trainee' ),
            'remove_featured_image' => __( 'Remove featured image', 'trainee' ),
            'use_featured_image'    => __( 'Use as featured image', 'trainee' ),
            'insert_into_item'      => __( 'Insert into item', 'trainee' ),
            'uploaded_to_this_item' => __( 'Uploaded to this company', 'trainee' ),
            'items_list'            => __( 'Companies list', 'trainee' ),
            'items_list_navigation' => __( 'Companies list navigation', 'trainee' ),
            'filter_items_list'     => __( 'Filter Company list', 'trainee' ),
        );
        $args = array(
            'label'                 => __( 'Company', 'trainee' ),
            'description'           => __( 'Company Posts', 'trainee' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-businessman',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'lctrainee_companies',
        );
        register_post_type( 'company', $args );


        $labels = array(
            'name'                  => _x( 'Causes/Solutions', 'Post Type General Name', 'trainee' ),
            'singular_name'         => _x( 'Cause/Solution', 'Post Type Singular Name', 'trainee' ),
            'menu_name'             => __( 'Causes/Solutions', 'trainee' ),
            'name_admin_bar'        => __( 'Cause/Solution', 'trainee' ),
            'archives'              => __( 'Cause/Solution Archives', 'trainee' ),
            'attributes'            => __( 'Cause/Solution Attributes', 'trainee' ),
            'parent_item_colon'     => __( 'Cause/Solution Parent Item:', 'trainee' ),
            'all_items'             => __( 'All Causes/Solutions', 'trainee' ),
            'add_new_item'          => __( 'Add Cause/Solution', 'trainee' ),
            'add_new'               => __( 'Add New Cause/Solution', 'trainee' ),
            'new_item'              => __( 'New Cause/Solution', 'trainee' ),
            'edit_item'             => __( 'Edit Cause/Solution', 'trainee' ),
            'update_item'           => __( 'Update Cause/Solution', 'trainee' ),
            'view_item'             => __( 'View Cause/Solution', 'trainee' ),
            'view_items'            => __( 'View Causes/Solutions', 'trainee' ),
            'search_items'          => __( 'Search Cause/Solution', 'trainee' ),
            'not_found'             => __( 'Not found', 'trainee' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'trainee' ),
            'featured_image'        => __( 'Featured Image', 'trainee' ),
            'set_featured_image'    => __( 'Set featured image', 'trainee' ),
            'remove_featured_image' => __( 'Remove featured image', 'trainee' ),
            'use_featured_image'    => __( 'Use as featured image', 'trainee' ),
            'insert_into_item'      => __( 'Insert into item', 'trainee' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Cause/Solution', 'trainee' ),
            'items_list'            => __( 'Causes/Solutions list', 'trainee' ),
            'items_list_navigation' => __( 'Cause/Solution list navigation', 'trainee' ),
            'filter_items_list'     => __( 'Filter Cause/Solution list', 'trainee' ),
        );
        $args = array(
            'label'                 => __( 'Cause/Solution', 'trainee' ),
            'description'           => __( 'Cause/Solution posts', 'trainee' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 7,
            'menu_icon'             => 'dashicons-lightbulb',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'map_meta_cap' => true,
            'capability_type'       => 'cause',
            'capabilities' => array(
                'publish_posts' => 'publish_causes',
                'edit_posts' => 'edit_causes',
                'edit_others_posts' => 'edit_others_causes',
                'edit_published_posts' => 'edit_published_causes',
                'delete_posts' => 'delete_causes',
                'delete_published_posts' => 'delete_published_causes',
                'delete_others_posts' => 'delete_others_causes',
                'read_private_posts' => 'read_private_causes',
                'edit_post' => 'edit_cause',
                'delete_post' => 'delete_cause',
                'read_post' => 'read_cause',
                'create_posts'  => 'create_causes'
            ),
            'show_in_rest'          => true,
            'rest_base'             => 'lctrainee_cause_solution',
        );
        register_post_type( 'cause-solution', $args );


        $labels = array(
            'name'                  => _x( 'Questionnaires', 'Post Type General Name', 'trainee' ),
            'singular_name'         => _x( 'Questionnaire', 'Post Type Singular Name', 'trainee' ),
            'menu_name'             => __( 'Questionnaires', 'trainee' ),
            'name_admin_bar'        => __( 'Questionnaire', 'trainee' ),
            'archives'              => __( 'Questionnaire Archives', 'trainee' ),
            'attributes'            => __( 'Questionnaires Attributes', 'trainee' ),
            'parent_item_colon'     => __( 'Questionnaire Parent Item:', 'trainee' ),
            'all_items'             => __( 'All Questionnaires', 'trainee' ),
            'add_new_item'          => __( 'Add New Questionnaire', 'trainee' ),
            'add_new'               => __( 'Add New Questionnaire', 'trainee' ),
            'new_item'              => __( 'New Questionnaire', 'trainee' ),
            'edit_item'             => __( 'Edit Questionnaire', 'trainee' ),
            'update_item'           => __( 'Update Questionnaire', 'trainee' ),
            'view_item'             => __( 'View Questionnaire', 'trainee' ),
            'view_items'            => __( 'View Questionnaires', 'trainee' ),
            'search_items'          => __( 'Search Questionnaire', 'trainee' ),
            'not_found'             => __( 'Not found', 'trainee' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'trainee' ),
            'featured_image'        => __( 'Featured Image', 'trainee' ),
            'set_featured_image'    => __( 'Set featured image', 'trainee' ),
            'remove_featured_image' => __( 'Remove featured image', 'trainee' ),
            'use_featured_image'    => __( 'Use as featured image', 'trainee' ),
            'insert_into_item'      => __( 'Insert into item', 'trainee' ),
            'uploaded_to_this_item' => __( 'Uploaded to this questionnaire', 'trainee' ),
            'items_list'            => __( 'Questionnaires list', 'trainee' ),
            'items_list_navigation' => __( 'Questionnaires list navigation', 'trainee' ),
            'filter_items_list'     => __( 'Filter Questionnaire list', 'trainee' ),
        );
        $args = array(
            'label'                 => __( 'Questionnaire', 'trainee' ),
            'description'           => __( 'Questionnaires', 'trainee' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 4,
            'menu_icon'             => 'dashicons-edit-large',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'lctrainee_questionnaires',
        );
        register_post_type( 'questionnaire', $args );

        $labels = array(
            'name'                  => _x( 'Buildings', 'Post Type General Name', 'trainee' ),
            'singular_name'         => _x( 'Building', 'Post Type Singular Name', 'trainee' ),
            'menu_name'             => __( 'Buildings', 'trainee' ),
            'name_admin_bar'        => __( 'Building', 'trainee' ),
            'archives'              => __( 'Building Archives', 'trainee' ),
            'attributes'            => __( 'Buildings Attributes', 'trainee' ),
            'parent_item_colon'     => __( 'Building Parent Item:', 'trainee' ),
            'all_items'             => __( 'All Buildings', 'trainee' ),
            'add_new_item'          => __( 'Add New Building', 'trainee' ),
            'add_new'               => __( 'Add New Building', 'trainee' ),
            'new_item'              => __( 'New Building', 'trainee' ),
            'edit_item'             => __( 'Edit Building', 'trainee' ),
            'update_item'           => __( 'Update Building', 'trainee' ),
            'view_item'             => __( 'View Building', 'trainee' ),
            'view_items'            => __( 'View Buildings', 'trainee' ),
            'search_items'          => __( 'Search Building', 'trainee' ),
            'not_found'             => __( 'Not found', 'trainee' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'trainee' ),
            'featured_image'        => __( 'Featured Image', 'trainee' ),
            'set_featured_image'    => __( 'Set featured image', 'trainee' ),
            'remove_featured_image' => __( 'Remove featured image', 'trainee' ),
            'use_featured_image'    => __( 'Use as featured image', 'trainee' ),
            'insert_into_item'      => __( 'Insert into item', 'trainee' ),
            'uploaded_to_this_item' => __( 'Uploaded to this questionnaire', 'trainee' ),
            'items_list'            => __( 'Buildings list', 'trainee' ),
            'items_list_navigation' => __( 'Buildings list navigation', 'trainee' ),
            'filter_items_list'     => __( 'Filter Building list', 'trainee' ),
        );
        $args = array(
            'label'                 => __( 'Building', 'trainee' ),
            'description'           => __( 'Buildings', 'trainee' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-building',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'lctrainee_questionnaires',
        );
        register_post_type( 'building', $args );

    }

    /**
     * Change default title placeholder for cpt
     */

    public function lc_title_place_holder($title , $post){

        if( $post->post_type == 'company' ){
            $company_title = __('Company Name', 'trainee');
            return $company_title;
        }

        if($post->post_type === 'cause-solution') {
            $csTitle = __('Enter Cause', 'trainee');
            return $csTitle;
        }

        if( $post->post_type == 'building' ){
            $company_title = __('Building Address', 'trainee');
            return $company_title;
        }
        return $title;
    }

    /**
     * Capabilities for causes
     * @param bool $isAdmin
     * @return string[]
     */

    public static function lctrainee_cause_cap ($isAdmin = false)
    {
       $adminCapabilities = [
            'publish_causes',
            'edit_causes',
            'edit_others_causes',
            'edit_published_causes',
            'delete_causes',
            'delete_others_causes',
            'delete_published_causes',
            'read_private_causes',
            'edit_cause',
            'delete_cause',
            'read_cause',
            'create_causes',
        ];

       $expertCapabilities = [
           'publish_causes',
           'edit_causes',
           'edit_published_causes',
           'delete_causes',
           'read_private_causes',
           'edit_cause',
           'delete_cause',
           'read_cause',
           'create_causes',
       ];

       return $isAdmin ? $adminCapabilities : $expertCapabilities;
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_action( 'init', [$this, 'lc_trainee_company_cpt'], 0 );
        add_filter('enter_title_here', [$this, 'lc_title_place_holder' ] , 20 , 2 );
    }

}
