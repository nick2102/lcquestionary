<?php

/**
 * LcTrainee_Metaboxes
 *
 * Creating custom post types Metaboxes
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Metaboxes
{
    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Metaboxes();
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
     * Initializes WordPress hooks
     */
    public function init ()
    {
        LcTrainee_Company_Metaboxes::getInstance();
        LcTrainee_Questionnaire_Metaboxes::getInstance();
        LcTrainee_Building_Metaboxes::getInstance();
    }

}
