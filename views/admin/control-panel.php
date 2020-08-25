<div class="wrap">
    <h2><?php _e('Control Panel', 'trainee'); ?></h2>
    <?php settings_errors(); ?>
    <hr>

    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder control-panel-wrap">
                <div id="postbox-container-1" class="postbox-container trainee-postbox-container">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                        <div id="dashboard_site_health" class="postbox ">
                            <h2 class="hndle trainee-hndle"><span><?php _e('Pending Causes/Solutions', 'trainee') ?></span>
                                <?php if($causesCount > 0) : ?><span class="cause_count"><?php echo $causesCount; ?> </span> <?php endif; ?></h2>
                            <div class="inside" style="padding: 0; margin: 0;">
                                <div class="community-events" style="margin-bottom: 0;">
                                <ul class="community-events-results activity-block last" aria-hidden="false" style="max-height: 380px; overflow-y: scroll;">
                                    <?php foreach($causes as $cause): ?>
                                    <li class="event event-wordcamp wp-clearfix">
                                        <div class="event-info">
                                            <div class="event-info-inner">
                                                <a class="event-title" href="<?php echo get_site_url() . '/wp-admin/post.php?post=' .  $cause->ID . '&action=edit' ?>"><?php echo $cause->post_title; ?></a>
                                                <span class="event-city"><?php _e('Posted by', 'trainee') ?>: <?php echo get_the_author_meta('display_name', $cause->post_author); ?></span>
                                            </div>
                                        </div>

                                        <div class="event-date-time">
                                            <span class="event-date"><a href="<?php echo get_site_url() . '/wp-admin/post.php?post=' .  $cause->ID . '&action=edit' ?>" data-post-id="<?php echo $cause->ID; ?>"><?php _e('Edit', 'trainee') ?></a></span>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>

                                    <?php if($causesCount === 0): ?>
                                        <li class="event event-wordcamp wp-clearfix">
                                            <span class="event-city"><?php _e('No pending causes.', 'trainee') ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                </div>
                            </div>
                        </div>

                        <div id="dashboard_site_questionnaires" class="postbox">
                            <h2 class="hndle trainee-hndle"><span><?php _e('Number of done Questionnaires', 'trainee') ?></span>
                                <?php if($causesCount > 0) : ?><span class="cause_count"><?php echo $causesCount; ?> </span> <?php endif; ?></h2>
                            <div class="inside" style="padding: 0; margin: 0;">
                                <div class="community-events" style="margin-bottom: 0;">
                                    <div style="font-size: 20px;padding: 20px 0px;"><span class="dashicons dashicons-yes-alt" style="font-size: 30px;margin-right: 10px;color: green;"></span> <?php _e('Number of done questionnaires', 'trainee') ?>: <?php echo count($questionnaires_number); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="postbox-container-2" class="postbox-container trainee-postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
                        <div id="dashboard_quick_press" class="postbox ">
                            <h2 class="hndle trainee-hndle"><span><?php _e('Quick Links', 'trainee'); ?></span></h2>
                            <div class="inside">
                                <ul class="trainee-quick-links">
                                    <li><a href=""><span class="dashicons dashicons-admin-site"></span> <?php _e('Portal', 'trainee'); ?></a></li>
                                    <li><a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=company"><span class="dashicons dashicons-businessman"></span> <?php _e('Add Company', 'trainee'); ?></a></li>
                                    <li><a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=cause-solution"><span class="dashicons dashicons-lightbulb"></span> <?php _e('Add Cause/Solution', 'trainee'); ?></a></li>
                                    <li><a href="<?php echo get_site_url(); ?>/wp-admin/user-new.php"><span class="dashicons dashicons-admin-users"></span> <?php _e('Add User', 'trainee'); ?></a></li>
                                    <li><a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=questionnaire"><span class="dashicons dashicons-shield-alt"></span> <?php _e('Add energy questionnaire', 'trainee'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>