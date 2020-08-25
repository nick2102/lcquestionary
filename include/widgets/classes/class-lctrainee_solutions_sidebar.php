<?php
/**
 * lctrainee_solutions_sidebar
 *
 * Creating custom widget
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class lctrainee_solutions_sidebar extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'trainee_solutions_sidebar', // Base ID
            esc_html__( 'Solutions sidebar menu', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Displaying cause/solution menu', 'trainee' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $sections = get_terms([
            'taxonomy' => 'lctrainee_cause_section',
            'hide_empty' => false,
        ]);

        foreach ($sections as $section) {
            $posts_array = get_posts(
                array(
                    'posts_per_page' => -1,
                    'post_type' => 'cause-solution',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'lctrainee_cause_section',
                            'field' => 'term_id',
                            'terms' => $section->term_id,
                        )
                    )
                )
            );

            $section->posts = $posts_array;
        }




        echo $args['before_widget'];
            include TRAINEE_PLUGIN_DIR . 'include/widgets/views/solution-sidebar/solution-menu.php';
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        return;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }

}