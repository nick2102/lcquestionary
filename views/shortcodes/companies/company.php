<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="trainee-company-detils">
            <div class="trainee-company-logo">
                <img src="<?php echo LcTrainee::lctrainee_get_post_meta('lc_trainee_company_logo', $id); ?>" alt="<?php echo get_the_title(); ?>">
            </div>

            <div class="trainee-company-title">
                <h2><?php echo get_the_title(); ?></h2>
                <p><?php echo LcTrainee::lctrainee_get_post_meta('lc_trainee_company_short_description', $id); ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="trainee-company-contact">
            <ul>
                <?php if($phone = LcTrainee::lctrainee_get_post_meta('lc_trainee_company_phone', $id)): ?>
                    <li><?php _e('Phone'); ?>: <?php echo $phone; ?></li>
                <?php endif; ?>

                <?php if($fax = LcTrainee::lctrainee_get_post_meta('lc_trainee_company_fax', $id)): ?>
                    <li><?php _e('Fax'); ?>: <?php echo $fax; ?></li>
                <?php endif; ?>

                <?php if($mobile = LcTrainee::lctrainee_get_post_meta('lc_trainee_company_mobile', $id)): ?>
                    <li><?php _e('Mobile'); ?>: <?php echo $mobile; ?></li>
                <?php endif; ?>

                <?php if($email = LcTrainee::lctrainee_get_post_meta('lc_trainee_company_email', $id)): ?>
                    <li><?php _e('Email'); ?>: <?php echo $email; ?></li>
                <?php endif; ?>

                <?php if($email = LcTrainee::lctrainee_get_post_meta('lc_trainee_company_website', $id)): ?>
                    <li><?php _e('Website'); ?>: <?php echo $email; ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>