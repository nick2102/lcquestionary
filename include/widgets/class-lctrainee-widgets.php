<?php
/**
 * LcTrainee_Widgets
 * Initiate custom widgets
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Widgets
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Widgets();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {
        add_action( 'widgets_init', [$this, 'auto_load_widgets' ]);
    }

    public function auto_load_widgets( )
    {

        $dir = TRAINEE_PLUGIN_DIR . "include/widgets/classes/";
        if(is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            //autoload requested class
            foreach ( $files as $file ) {
                if( is_file($dir . $file) ) {
                    require_once $dir . $file;
                    $class = str_replace(['class-', '.php'], ['', ''], $file);
                    register_widget( $class );
                }
            }
        }
    }
}