<?php
/**
 * LcTrainee_Install
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Install
{
    /**
     * Register plugin activation and deactiivation hooks
     */
    public static function init() {
        register_activation_hook( TRAINEE_PLUGIN_FILE, [ 'LcTrainee_Install', 'pluginActivation' ] );
        register_deactivation_hook( TRAINEE_PLUGIN_FILE, [ 'LcTrainee_Install', 'pluginDeactivation' ] );
    }


    /**
     * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
     * @static
     */
    public static function pluginActivation () {
        // gets the administrator role
        $subscriber  = get_role('subscriber');
        add_role( 'expert', __('Expert', 'trainee'));
        add_role( 'resident', __('Resident', 'trainee'), $subscriber->capabilities);

        $adminRole = get_role('administrator');
        $expertRole = get_role('expert');


        $adminCap = LcTrainee_Cpt::lctrainee_cause_cap(true);
        $expertCap = LcTrainee_Cpt::lctrainee_cause_cap(false);

        $expertRole->add_cap('read');
        $expertRole->add_cap('upload_files');

        foreach ($adminCap as $capability) {
            $adminRole->add_cap($capability);
        }

        foreach ($expertCap as $capability) {
            $expertRole->add_cap($capability);
        }

        //Create login block table
        global $wpdb;
        $table_name = $wpdb->prefix . 'lctrainee_invalid_login_attempts';
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              ip_address VARCHAR( 20 ) NOT NULL,
              username VARCHAR( 255 ) NOT NULL,
              attempts INT NOT NULL,
              last_attempt datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              blocked_till datetime NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * Removes all connection options
     * @static
     */
    public static function pluginDeactivation () {
        // gets the administrator role
        $adminRole = get_role('administrator');
        $expertRole = get_role('expert');
        $residentCap = get_role('resident');

        $adminCap = LcTrainee_Cpt::lctrainee_cause_cap(true);
        $expertCap = LcTrainee_Cpt::lctrainee_cause_cap(false);

        $expertRole->remove_cap('read');
        $expertRole->remove_cap('upload_files');


        foreach ($adminCap as $capability) {
            $adminRole->remove_cap($capability);
        }

        foreach ($expertCap as $capability) {
            $expertRole->remove_cap($capability);
        }

        foreach ($residentCap->capabilities as $key => $value) {
            $residentCap->remove_cap($key);
        }

        // Remove roles
        remove_role('expert');
        remove_role('resident');
    }


}