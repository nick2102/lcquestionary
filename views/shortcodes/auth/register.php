<?php $random = sha1(rand() + time());?>
<form id="traineeRegisterForm<?php echo $random; ?>" class="modal-content animate trainee-system-form">
    <div class="container">

        <?php if($data['role'] === 'expert'): ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="name"><?php _e('Name', 'trainee'); ?>:</label>
                    <input required type="text" name="name" class="form-control" placeholder="<?php _e('Your name', 'trainee'); ?>" id="name">
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="username"><?php _e('Last Name', 'trainee'); ?>:</label>
                    <input required type="text" name="lastName" class="form-control" placeholder="<?php _e('Your Last Name', 'trainee'); ?>" id="lastName">
                </div>
            </div>
        </div>
        <?php endif; ?>


        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="username"><?php _e('Email', 'trainee'); ?>:</label>
                    <input required type="text" name="email" class="form-control" placeholder="<?php _e('Your Email', 'trainee'); ?>" id="email">
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="password"><?php _e('Password', 'trainee'); ?>:</label>
                    <input required type="password" name="password" class="form-control" placeholder="<?php _e('Enter Password', 'trainee'); ?>" id="password">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <button data-random="<?php echo $random; ?>" class="btn btn-primary trainee-system-register-btn"><?php _e('Register', 'trainee'); ?></button>
            </div>
        </div>
        <input type="hidden" name="role" value="<?php echo $data['role']; ?>">
    </div>
</form>