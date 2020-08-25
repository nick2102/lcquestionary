<?php

/**
 * LcTrainee_Questionnaire_Metaboxes
 *
 * Creating custom post types Metaboxes
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Questionnaire_Metaboxes
{
    private static $instance = null;

    private static $metaboxSettings = [];

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Questionnaire_Metaboxes();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {
        // class initialization
        $this->init();
    }

    /**
     * Register metaboxes
     */

    public function lctrainee_register_questionnaire_metaboxes()
    {

        add_meta_box(
            'trainee_questionnaire',
            __('Questionnaire content', 'trainee'),
            [$this, 'lctrainee_questionnaire_content_html'],
            'questionnaire',
            'normal',
            'default'
        );

        add_meta_box(
            'trainee_questionnaire_export',
            __('Questionnaire content export/import', 'trainee'),
            [$this, 'lctrainee_questionnaire_export_html'],
            'questionnaire',
            'normal',
            'default'
        );
    }

    /**
     * Questionnaire Content Html
     */
    public function lctrainee_questionnaire_content_html()
    {
        $qMeta = LcTrainee::lctrainee_get_post_meta('_lctrainee_questionnaire');
        include TRAINEE_PLUGIN_DIR . '/views/admin/questionnaire-panel.php';
        echo '<input type="hidden" name="lctrainee_questionnaire" value="' . htmlspecialchars(json_encode(unserialize($qMeta), JSON_UNESCAPED_SLASHES)) . '">';
        wp_nonce_field('_lctrainee_questionnaire_nonce', 'lctrainee_questionnaire_nonce');
        echo '<style>#publish{ display: none; } </style>';
    }

    /**
     * EE Indicator Content Html
     */
    public function lctrainee_ee_indicator_html()
    {

    }

    /**
     * Export/Import Html
     */
    public function lctrainee_questionnaire_export_html()
    {
        ?>

        <div class="tabLongTitle">
            <div>
                <label for="exportedJson">Export/Import</label>
                <textarea id="exportedJson" class="longTitle" type="text" placeholder=""></textarea>
            </div>

            <div style="margin: 15px 0;">
                <a class="button trainee-q-export button-primary customize load-customize hide-if-no-customize"><?php _e('Export content', 'trainee') ?></a>
                <a class="button trainee-q-import button-primary customize load-customize hide-if-no-customize"><?php _e('Import content', 'trainee') ?></a>
            </div>
        </div>
    <?php
    }

    /**
     * Questionnaire Content Html
     */
    public function lctrainee_save_questionnaire($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! isset( $_POST['lctrainee_questionnaire_nonce'] ) || ! wp_verify_nonce( $_POST['lctrainee_questionnaire_nonce'], '_lctrainee_questionnaire_nonce' ) ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        if ( isset( $_POST['lctrainee_questionnaire'] ) ){
            $formData = json_decode(stripslashes($_POST['lctrainee_questionnaire']));
            update_post_meta( $post_id, '_lctrainee_questionnaire', serialize($formData) );
        }

    }

    public function init()
    {
        add_action( 'add_meta_boxes', [ $this, 'lctrainee_register_questionnaire_metaboxes' ] );
        add_action( 'save_post', [ $this, 'lctrainee_save_questionnaire' ] );
    }
}