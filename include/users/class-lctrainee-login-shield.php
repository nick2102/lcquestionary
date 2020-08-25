<?php
/**
 * LcTrainee_Login_Shield
 *
 * Creating custom  Users
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class  LcTrainee_Login_Shield
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new LcTrainee_Login_Shield();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct()
    {

    }

    //Handle invalid login attempts
    public static function record_invalid_login($username) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'lctrainee_invalid_login_attempts';

        $result = self::load_attempts_table($wpdb, $table_name, $username);
        $insert = self::insert_in_attempts_table($wpdb, $table_name, $username, $result);
    }

    public static function check_if_blocked_ip($username) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'lctrainee_invalid_login_attempts';
        $blockedIp = self::load_attempts_table($wpdb, $table_name, $username);
        $blockedTill = $blockedIp[0]['blocked_till'];
        $currentTime = current_time('mysql', 1);

        if($blockedTill != null && strtotime($currentTime) > strtotime($blockedTill)) {
            $wpdb->delete( $table_name, array('id' => $blockedIp[0]['id']) );
            return false;
        }

        return $blockedIp[0]['attempts'] >= 3 && $blockedTill;
    }

    //Get results from attempts table
    public static function load_attempts_table ($db, $table, $username) {
        $ip = LcTrainee_Users::get_client_ip();
        $holder = "%s";
        $array = array();
        $result = $db->get_results ( $db->prepare("SELECT * FROM $table WHERE ip_address = '{$holder}' AND username = '$holder'", $ip, $username),ARRAY_A);
        return $result;
    }

    //Insert data in attempts table
    public static function insert_in_attempts_table ($db, $table, $username, $result){
        $ip = LcTrainee_Users::get_client_ip();
        if(empty($result)){
            $db->insert($table, array(
                'ip_address' => $ip,
                'username' => $username,
                'attempts' => 1,
                'last_attempt' => current_time('mysql', 1)
            ));
            if($db->last_error !== '') :
                $db->print_error();
            else:
                return 1;
            endif;

        } else {
            $numberOfAttempts = $result[0]['attempts'];
            $newAttempt = $numberOfAttempts+1;
            $date = new DateTime();
            $date->modify("+2 minutes");
            $currentTime = $date->format('Y-m-d H:i:s');
            $db->update($table, array( 'attempts' => $newAttempt, 'last_attempt' => current_time('mysql', 1)),array('ip_address'=>$ip, 'username' => $username));
            if($newAttempt == 3)
                $db->update($table, array( 'blocked_till' => $currentTime),array('ip_address'=>$ip, 'username' => $username));

            return 2;
        }
    }

    public static function get_remaining_block_minutes ($username) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'lctrainee_invalid_login_attempts';
        $result = self::load_attempts_table($wpdb, $table_name, $username);
        $blocked_till = $result[0]['blocked_till'];
        $currentTime = current_time('mysql', 1);
        $minutes = round(abs(strtotime($currentTime) - strtotime($blocked_till)) / 60,0);
        return $minutes <= 0 ? 1 : $minutes;
    }

    public static function lctrainee_reset_blockip_counter($username)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'lctrainee_invalid_login_attempts';
        $result = self::load_attempts_table($wpdb, $table_name, $username);

        if(!empty($result) && $result[0]['attempts'] > 0) {
            $wpdb->delete( $table_name, array('id' => $result[0]['id']) );
        }
    }
}