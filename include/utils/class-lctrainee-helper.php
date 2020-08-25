<?php
/**
 * LcTrainee_Helper
 *
 * Helper Class
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Helper
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Helper();
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
     *  Compare if value is between two values
     */
    public static function in_between($value, $min, $max)
    {
        return $value >= $min && $value <= $max;
    }

    /**
     *  Return user energy level
     */

    public static function return_energy_level($value, $indicators)
    {
        $level = '';
        foreach ($indicators as $key => $indicator) {
            if(self::in_between($value, $indicator->level_from, $indicator->level_to)) {
                $level = $key;
                break;
            }
        }

        return $level;
    }

    /**
     *  Return post image
     */

    public static function return_post_img($id)
    {
        return $img = get_the_post_thumbnail_url($id) ? get_the_post_thumbnail_url($id) : TRAINEE_PLUGIN_URL . 'assets/images/placeholder.png';
    }

    /**
     *  Custom numeric pagination
     */
    public static function trainee_numeric_posts_nav() {

        if( is_singular() )
            return;

        global $wp_query;

        /** Stop execution if there's only 1 page */
        if( $wp_query->max_num_pages <= 1 )
            return;

        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $wp_query->max_num_pages );

        /** Add current page to the array */
        if ( $paged >= 1 )
            $links[] = $paged;

        /** Add the pages around the current page to the array */
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<nav aria-label="Pagination"><ul class="pagination">' . "\n";

        /** Previous Post Link */
        if ( get_previous_posts_link() )
            printf( '<li class="page-item"><span class="page-link">%s</span></li>' . "\n", get_previous_posts_link() );

        /** Link to first page, plus ellipses if necessary */
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="active page-item"' : ' class="page-item"';

            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

            if ( ! in_array( 2, $links ) )
                echo '<li class="page-item">…</li>';
        }

        /** Link to current page, plus 2 pages in either direction if necessary */
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="active page-item"' : ' class="page-item"';
            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
        }

        /** Link to last page, plus ellipses if necessary */
        if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) )
                echo '<li class="page-item"><span class="page-link">…</span></li>' . "\n";

            $class = $paged == $max ? ' class="active page-item"' : ' class="page-item"';
            printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
        }

        /** Next Post Link */
        if ( get_next_posts_link() )
            printf( '<li class="page-item"><span class="page-link">%s</span></li>' . "\n", get_next_posts_link() );

        echo '</ul></nav>' . "\n";

    }

    public static function city_slug_refactor($slug)
    {
        if ( function_exists('icl_object_id') ) {
            $current_lng = ICL_LANGUAGE_CODE;
            return str_replace($current_lng . '-', '', $slug);
        }
        return $slug;
    }

    public static function generate_pages_dropdown($settings= [])
    {
        if(function_exists('icl_object_id')) {
            global $sitepress;
            $default_lang = $sitepress->get_default_language(); // Get WPML default language
            $current_lang = $sitepress->get_current_language(); //save current language
            $sitepress->switch_lang($default_lang); //temporarily switch to your default langauge
            $query=new WP_Query("showposts=-1&suppress_filters=0&post_type=page&post_status=publish"); //...run query here; if you use WP_Query or get_posts make sure you set suppress_filters=0 ...
            $pages = $query->get_posts();
            $sitepress->switch_lang($current_lang); //restore previous language
        } else {
            $pages = get_pages(['post_status' => 'publish']);
        }
        ?>
        <select name="<?php echo isset($settings['name']) ? $settings['name'] : ''; ?>" id="<?php echo isset($settings['name']) ? $settings['name'] : ''; ?>">
            <option><?php _e('Please Select', 'trainee'); ?></option>

            <?php foreach($pages as $page): ?>
                <option <?php selected(isset($settings['page_id']) ? $settings['page_id'] : '', $page->ID) ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
            <?php endforeach; ?>
        </select>
    <?php
    }
}