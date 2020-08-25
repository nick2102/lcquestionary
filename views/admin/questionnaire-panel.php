<?php $tabs = unserialize(LcTrainee::lctrainee_get_post_meta('_lctrainee_questionnaire')); ?>
<div class="wrap">
    <div class="loadingScreen">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    <div id="post-body">

        <div>
            <div id="addTabs">
                <div class="addTabsWrapper">
                    <div style="width: 90%; padding: 0 10px;">
                        <label for="tabName"><?php _e('Tab name', 'trainee'); ?></label>
                        <input type="text" id="tabName">
                    </div>
                    <div>
                        <br>
                        <a id="addSection" class="button-primary button"  data-tab="<?php echo $tabs && count((array)$tabs) > 0 ? count((array)$tabs) + 1 : '1' ?>" href="#"><?php _e('+ Add Section', 'trainee'); ?></a>
                    </div>
                </div>

                <?php if($tabs && count((array)$tabs) > 0): ?>
                    <div class="addTabsWrapper" id="shortcode">
                        <div style="width: 100%; margin: 10px;"><?php _e('Copy Shortcode', 'trainee'); ?></div>
                        <input type="text" readonly value='[trainee_questionnaire id="<?php echo $_GET['post']; ?>"]'>
                    </div>
                <?php endif; ?>
            </div>


            <!-- Start tabs -->
            <ul class="wp-tab-bar trainee-tab-bar">
                <?php if($tabs && count((array)$tabs) > 0): $counter = 0; foreach ($tabs as $tab): ?>
                    <li <?php if($counter == 0) { echo 'class="wp-tab-active"'; } ?>><a id="name_<?php echo $counter; ?>" href="#tabs-<?php echo strtolower(str_replace(' ', '_', $tab->tabTitle)); ?>"><?php echo $tab->tabTitle; ?></a></li>
                <?php $counter++; endforeach; endif; ?>
            </ul>
            <div id="questionnaire_form">
                <?php if($tabs && count((array)$tabs) > 0):
                        $counter = 0;
                        foreach ($tabs as $tab):
                            include TRAINEE_PLUGIN_DIR . '/views/admin/questionnaire-tabs/q-questions.php';
                            $counter++;
                        endforeach;
                    endif; ?>

            </div>
            <a class="button trainee-save-questionnaire-cpt button-primary customize load-customize hide-if-no-customize"><?php _e('Save', 'trainee'); ?></a>

            <!-- End tabs -->
        </div>
    </div>
</div>