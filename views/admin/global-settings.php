<div><!--Start of Options Page Wrap -->
    <form method="post" action="options.php">
        <h2><?php _e('Global Settings', 'trainee'); ?></h2>
        <hr>
        <?php settings_fields( 'global_settings' ); ?>
        <?php $options = get_option( 'global_settings' ); ?>
        <table>
            <tr valign="top">
                <th scope="row"><?php _e( 'Select questionnaire page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[questionnaire_page]', 'page_id' => isset($options['questionnaire_page']) ? $options['questionnaire_page'] : '']); ?>
                    <br />
                    <label for="global_settings[questionnaire_page]"><?php _e( 'Select the default questionnaire page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select energy profile page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[energy_profile_page]', 'page_id' => isset($options['energy_profile_page']) ? $options['energy_profile_page'] : '']); ?>
                    <br />
                    <label for="global_settings[energy_profile_page]"><?php _e( 'Select the default energy profile page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select expert registration page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[expert_register]', 'page_id' => isset($options['expert_register']) ? $options['expert_register'] : '']); ?>
                    <br />
                    <label for="global_settings[expert_register]"><?php _e( 'Select the default expert registration  page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select resident registration page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[resident_register]', 'page_id' => isset($options['resident_register']) ? $options['resident_register'] : '']); ?>
                    <br />
                    <label for="global_settings[resident_register]"><?php _e( 'Select the default resident registration  page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select Reset Password page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[reset_pwd_register]', 'page_id' => isset($options['reset_pwd_register']) ? $options['reset_pwd_register'] : '']); ?>
                    <br />
                    <label for="global_settings[reset_pwd_register]"><?php _e( 'Select the default reset password  page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select password recovery page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[recovery_pwd_register]', 'page_id' => isset($options['recovery_pwd_register']) ? $options['recovery_pwd_register'] : '']); ?>
                    <br />
                    <label for="global_settings[recovery_pwd_register]"><?php _e( 'Select the default password recovery page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e( 'Select change password page', 'trainee' ); ?></th>
                <td>
                    <?php LcTrainee_Helper::generate_pages_dropdown(['name'=>'global_settings[change_pwd_register]', 'page_id' => isset($options['change_pwd_register']) ? $options['change_pwd_register'] : '']); ?>
                    <br />
                    <label for="global_settings[change_pwd_register]"><?php _e( 'Select the default password redovery page in the default language.' , 'trainee'); ?></label>
                    <br /><br />
                </td>
            </tr>
        </table>
        <p><input class="button button-primary" name="submit" id="submit" value="Save Changes" type="submit"></p>
    </form>
</div><!-- END wrap -->