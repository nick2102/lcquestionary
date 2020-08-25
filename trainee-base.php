<?php

/*
    Plugin Name: Trainee Base
    Version: 1.0.0
    Plugin URI: https://labscreative.com
    Author: Nikola Nikoloski
    Author URI: https://labscreative.com
    Text Domain: trainee
    Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // don't access directly
}

//disable file edit from admin panel
define('DISALLOW_FILE_EDIT', true);

/**
 * define plugin constants
 */

define('TRAINEE_PLUGIN_DIR', str_replace(['\\\\', '\\'], '/', plugin_dir_path(__FILE__)));
define('TRAINEE_PLUGIN_RELATIVE_DIR', dirname(plugin_basename(__FILE__)));
define('TRAINEE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TRAINEE_PLUGIN_FILE', str_replace(['\\\\', '\\'], '/', __FILE__));
define('TRAINEE_PLUGIN_API_NAMESPACE', 'trainee-api/v1');

//JWT Settings
define('TRAINEE_PLUGIN_JWT_NAMESPACE', 'jwt-auth/v1');

//HERE MAPS API KEY
define('TRAINEE_HERE_MAPS_API_KEY', 'QDtsb4FXjnNwfjeEvdPh5mNe8WFTl8tdb4HJX4GIcNU');


/**
 * Set Language direcotory
 */
//add_action('plugins_loaded', function () {
load_plugin_textdomain('trainee', false, 'trainee-base/languages/');
//}, 2);

/**
 * Get instance of main Class
 */
require_once(TRAINEE_PLUGIN_DIR . 'include/class-lctrainee.php');
LcTrainee::getInstance();
