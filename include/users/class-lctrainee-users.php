<?php
/**
 * LcTrainee_Users
 *
 * Creating custom  Users
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class  LcTrainee_Users
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Users();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
        $this->init();
    }


    /**
     * Restrict user dashboard
     */
    public function lctrainee_restirct_wp_dashboard()
    {
        if( is_admin() && (!current_user_can('expert') && !current_user_can('administrator'))){
            wp_redirect(home_url()); exit;
        }
    }

    /**
     * Redirect from default dahsboard page
     */
    public function lctrainee_redirect_from_wp_dashboard()
    {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;

        if(in_array('expert', $roles)){
            wp_redirect(admin_url('edit.php?post_type=cause-solution'));
            exit;
        }

            if(in_array('administrator', $roles) && $user->user_login !== 'epg_super'){
                wp_redirect(admin_url('admin.php?page=trainee-control-panel'));
                exit;
            }
    }

    /**
     * Redirect to cause/solution after login
     */
    public function lctrainee_login_redirect( $redirect_to, $request, $user ){
        $_user = wp_get_current_user();
        $roles = ( array ) $_user->roles;

        if(in_array('expert', $roles)){
            return admin_url('edit.php?post_type=cause-solution');
        }

        return $redirect_to;
    }

    /**
     * Remove unnecesary menus
     */
    public function lc_trainee_remove_menus () {
        global $menu;
        $restricted = array(__('Dashboard'),  __('Tools'));
        //$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
        end($menu);

        $_user = wp_get_current_user();
        $roles = ( array ) $_user->roles;

        if(in_array('expert', $roles)){
            while(prev($menu)){
                $value = explode(' ',$menu[key($menu)][0]);
                if(in_array($value[0]!= NULL?$value[0]:'',$restricted)){unset($menu[key($menu)]);}
            }
        }
    }


    /**
     * Hide some profile fields
     */

    public function lctrainee_remove_profile_fields()
    {
        global $pagenow;

        // apply only to user profile or user edit pages
        if( $pagenow !=='profile.php' && $pagenow !=='user-edit.php' )
        {
            return;
        }

        // Make it happen for all except Administrators
        if( current_user_can( 'manage_options' ) )
        {
            return;
        }

        add_action( 'admin_footer', [$this, 'wpse273289_remove_profile_fields_js'] );
    }

    /**
     * Remove (below)selected fields on user profile
     * This function belongs to the wpse273289_remove_profile_fields function!
     *
     */
    public function wpse273289_remove_profile_fields_js()
    {
        ?>
        <script>
            jQuery(document).ready( function($) {
                // $('input#nickname').closest('tr').remove();   // Nickname (required)
                $('input#comment_shortcuts').closest('tr').remove();   // Nickname (required)
                $('input#rich_editing').closest('tr').remove();   // Nickname (required)
                $('#color-picker').closest('tr').remove();   // Nickname (required)
                $('input#admin_bar_front').closest('tr').remove();   // Nickname (required)
                $('select#display_name').closest('tr').remove();   // Nickname (required)
                $('#first_name').parent().parent().parent().parent().prev().remove();
                $('#description').parent().parent().parent().parent().prev().remove();
                $('#description').closest('table').remove();   // Nickname (required)
            });
        </script>
        <?php
    }

    /**
     * Non admins will always publish post with pending status
     */
    public function lctrainee_always_pending_causes($post_id)
    {
        $isExpert = current_user_can("expert");

        if ($isExpert) {
            if(get_post_status($post_id) === 'publish' && 'trash' !== get_post_status($post_id) ) {
                $post = array( 'ID' => $post_id, 'post_status' => 'pending' );
                wp_update_post($post);
            }
        }
    }

    /**
     * Redirect from wp login screen
     */

    public function lctrainee_custom_login(){
        global $pagenow;
        if( 'wp-login.php' == $pagenow && !is_user_logged_in()) {
            wp_redirect(site_url(). '/login');
            exit();
        }
    }

    /**
     * Redirect after logout
     */
    public function trainee_auto_redirect_after_logout(){
        wp_safe_redirect( home_url() );
        exit;
    }

    /**
     * Admin bar control
     */
    public function lctrainee_admin_bar_control() {
        $showBar = current_user_can('administrator');
        show_admin_bar($showBar);
    }

    /**
     * Get user IP
     */
    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function trainee_user_id()
    {
        return get_current_user_id();
    }

    /**
     * Initializes WordPress hooks
     */
    public function init ()
    {
        add_action( 'init', [$this, 'lctrainee_restirct_wp_dashboard'] );
        add_action( 'load-index.php', [$this, 'lctrainee_redirect_from_wp_dashboard'] );
        add_action( 'admin_menu', [$this, 'lc_trainee_remove_menus'] );
        add_action( 'admin_init',  [$this, 'lctrainee_remove_profile_fields'] );
        add_filter( 'login_redirect',  [$this, 'lctrainee_login_redirect'],10,3 );
        add_action( 'edit_post', [$this, 'lctrainee_always_pending_causes'] );
        add_action('after_setup_theme', [$this, 'lctrainee_admin_bar_control']);
        add_action('init', [$this, 'lctrainee_custom_login']);
        add_action('wp_logout', [$this, 'trainee_auto_redirect_after_logout']);
    }

}