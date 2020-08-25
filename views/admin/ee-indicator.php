<div class="wrap">
    <h1 class="wp-heading-inline"> <?php _e('Energy efficiency indicator', 'trainee'); ?> </h1>
    <div id="poststuff">
        <div class="postbox-container">
            <div id="trainee_ee_indicator" class="postbox ">
                <h2 class="hndle ui-sortable-handle"><span><?php _e('Energy efficiency indicator points', 'trainee'); ?></span></h2>
                <div class="inside">
                    <div class="indicators-wrapper">
                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-1" data-level="level_1">
                                <div class="indicator-title"><?php _e('Level 1 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_1']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_1']->level_to : ''; ?>">
                            </div>
                        </div>

                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-2" data-level="level_2">
                                <div class="indicator-title"><?php _e('Level 2 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_2']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_2']->level_to : ''; ?>">
                            </div>
                        </div>

                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-3" data-level="level_3">
                                <div class="indicator-title"><?php _e('Level 3 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_3']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_3']->level_to : ''; ?>">
                            </div>
                        </div>

                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-4" data-level="level_4">
                                <div class="indicator-title"><?php _e('Level 4 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_4']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_4']->level_to : ''; ?>">
                            </div>
                        </div>

                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-5" data-level="level_5">
                                <div class="indicator-title"><?php _e('Level 5 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_5']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_5']->level_to : ''; ?>">
                            </div>
                        </div>

                        <div class="indicator-item-wrapper">
                            <div class="indicator-item vale_lvl-6" data-level="level_6">
                                <div class="indicator-title"><?php _e('Level 6 points', 'trainee'); ?></div>
                                <label><?php _e('From', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_from" value="<?php echo $indicator ? $indicator['level_6']->level_from : ''; ?>">
                                <label><?php _e('To', 'trainee'); ?></label>
                                <input type="text" class="indicator-value" name="level_to" value="<?php echo $indicator ? $indicator['level_6']->level_to : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="button trainee-ee-indicator-save button-primary customize load-customize hide-if-no-customize"><?php _e('Save', 'trainee'); ?></a>
    </div>
</div>