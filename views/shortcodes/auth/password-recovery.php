<form id="passwordRecoveryForm" class="trainee-system-form">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="email"><?php _e('Email', 'trainee'); ?></label>
                    <input id="email" type="text" class="form-control"  placeholder="<?php _e('Enter Email', 'trainee'); ?>" name="email" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary trainee-system-password-recovery-btn"><?php _e('Send reset email', 'trainee'); ?></button>
            </div>
        </div>

    </div>
</form>
