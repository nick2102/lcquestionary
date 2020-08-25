<?php $random = sha1(rand() + time()); $globalSettings = get_option( 'global_settings' );?>
<form id="traineeLoginForm<?php echo $random; ?>" class="trainee-system-form">
    <div class="form-group">
        <label for="username"><?php _e('Email', 'trainee'); ?>:</label>
        <input required type="text" name="username" class="form-control" placeholder="<?php _e('Your email', 'trainee'); ?>" id="username">
    </div>
    <div class="form-group">
        <label for="password"><?php _e('Password', 'trainee'); ?>:</label>
        <input required type="password" name="password" class="form-control" placeholder="<?php _e('Enter password', 'trainee'); ?>" id="password">
    </div>



        <button data-random="<?php echo $random; ?>" class="btn btn-primary trainee-system-login-btn"><?php _e('Login', 'trainee'); ?></button>

        <div class="modal-footer">
            <div class="col">
                <a class="system-trainee-password-recovery-btn" href="#"><?php _e('Forgot your password?', 'trainee'); ?> </a>
            </div>
            <div class="col">
                <?php _e('Don\'t have account?', 'trainee'); ?> <a href="<?php echo get_the_permalink(apply_filters( 'wpml_object_id',  $globalSettings['resident_register'])); ?>"><?php _e('Register here.', 'trainee'); ?> </a>
                </div>
        </div>
 </form>