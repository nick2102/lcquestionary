<?php
/**
 * LcTrainee_Taxonomies
 *
 * Creating custom post types taxonomies
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Taxonomies
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Taxonomies();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        // class initialization
        $this->init();
    }

    /**
     * Register Custom Post Type Taxonomies
     */
    public function create_lc_trainee_taxonomies()
    {

        $settings = array(
            [
                'postType' => ['company'],
                'taxSettings' => [ 'taxonomy'=> 'lctrainee_company_category', 'singularName' => __('Category', 'trainee'), 'pluralName' =>  __('Categories', 'trainee'), 'menuName' => __('Company Category', 'trainee'), 'slug' => 'company-category', 'rest_base' => 'lctrainee_company_category']
            ],

            [
                'postType' => ['cause-solution'],
                'taxSettings' => [ 'taxonomy'=> 'lctrainee_cause_section', 'singularName' => __('Section', 'trainee'), 'pluralName' => __('Sections', 'trainee'), 'menuName' => __('Sections', 'trainee'), 'slug' => 'cause-sections', 'rest_base' => 'lctrainee_cause_sections']
            ],

            [
                'postType' => ['building'],
                'taxSettings' => [ 'taxonomy'=> 'lctrainee_building_city', 'singularName' => __('City', 'trainee'), 'pluralName' => __('Cities', 'trainee'), 'menuName' => __('Cities', 'trainee'), 'slug' => 'building-city', 'rest_base' => 'lctrainee_building_cities']
            ],
        );

        foreach($settings as $setting) {
                $taxonomy = $setting['taxSettings'];
                $labels = array(
                    'name'                       => _x( $taxonomy['pluralName'], 'Taxonomy General Name', 'trainee' ),
                    'singular_name'              => _x( $taxonomy['singularName'], 'Taxonomy Singular Name', 'trainee' ),
                    'menu_name'                  => __( $taxonomy['menuName'], 'trainee' ),
                    'all_items'                  => __( 'All Items', 'trainee' ),
                    'parent_item'                => __( 'Parent Item', 'trainee' ),
                    'parent_item_colon'          => __( 'Parent Item:', 'trainee' ),
                    'new_item_name'              => __( 'New Item Name', 'trainee' ),
                    'add_new_item'               => __( 'Add New Item', 'trainee' ),
                    'edit_item'                  => __( 'Edit Item', 'trainee' ),
                    'update_item'                => __( 'Update Item', 'trainee' ),
                    'view_item'                  => __( 'View Item', 'trainee' ),
                    'separate_items_with_commas' => __( 'Separate items with commas', 'trainee' ),
                    'add_or_remove_items'        => __( 'Add or remove items', 'trainee' ),
                    'choose_from_most_used'      => __( 'Choose from the most used', 'trainee' ),
                    'popular_items'              => __( 'Popular Items', 'trainee' ),
                    'search_items'               => __( 'Search Items', 'trainee' ),
                    'not_found'                  => __( 'Not Found', 'trainee' ),
                    'no_terms'                   => __( 'No Items', 'trainee' ),
                    'items_list'                 => __( 'Items list', 'trainee' ),
                    'items_list_navigation'      => __( 'Items list navigation', 'trainee' ),
                );
                $rewrite = array(
                    'slug'                       => $taxonomy['slug'],
                    'with_front'                 => true,
                    'hierarchical'               => true,
                );
                $args = array(
                    'labels'                     => $labels,
                    'hierarchical'               => true,
                    'public'                     => true,
                    'show_ui'                    => true,
                    'show_admin_column'          => true,
                    'show_in_nav_menus'          => true,
                    'show_tagcloud'              => true,
                    'rewrite'                    => $rewrite,
                    'show_in_rest'               => true,
                    'rest_base'                  => $taxonomy['rest_base'],
                );

                register_taxonomy( $taxonomy['taxonomy'], $setting['postType'], $args );
        }
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_action( 'init', [$this, 'create_lc_trainee_taxonomies'], 0 );
    }

}
