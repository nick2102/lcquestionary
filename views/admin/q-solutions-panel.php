<h2 class="wp-heading-inline"> <?php _e('Map step settings', 'trainee'); ?> </h2>
<hr>
<div class="trainee_ranges">
    <div class="tabLongTitle">
        <div>
            <label for="trainee_years_range"><?php _e('Enter years range with the points, comma separated', 'trainee'); ?>.</label>
            <p><?php _e('Ex: 1990:1998#10 this means if user enters between 1990 and 1998 he will get 10 points for this question', 'trainee'); ?>.</p>
            <textarea id="trainee_years_range" class="longTitle range_input" name="trainee_years_range" type="text" placeholder=""><?php echo $rangesSettings && isset($rangesSettings->years) ? $rangesSettings->years : '' ?></textarea>
        </div>
    </div>

    <div class="tabLongTitle">
        <div>
            <label for="trainee_square_range"><?php _e('Enter square meter range with the points, comma separated', 'trainee'); ?>.</label>
            <p><?php _e('Ex: 30:45#10 this means if user enters between 30 and 45 he will get 10 points for this question', 'trainee'); ?>.</p>
            <textarea id="trainee_square_range" class="longTitle range_input" name="trainee_square_range" type="text" placeholder=""><?php echo $rangesSettings && isset($rangesSettings->squares) ? $rangesSettings->squares : ''; ?></textarea>
        </div>
    </div>

    <div class="tabLongTitle">
        <div>
            <label for="trainee_occupants_range"><?php _e('Enter occupants range with the points, comma separated', 'trainee'); ?>.</label>
            <p><?php _e('Ex: 1:3#10 this means if user enters between 1 and 3 he will get 10 points for this question', 'trainee'); ?>.</p>
            <textarea id="trainee_occupants_range" class="longTitle range_input" name="trainee_occupants_range" type="text" placeholder=""><?php echo $rangesSettings && isset($rangesSettings->occupants) ? $rangesSettings->occupants : ''?></textarea>
        </div>
    </div>
</div>

<h2 class="wp-heading-inline"> <?php _e('Questionnaire solutions', 'trainee'); ?> </h2>
<hr>
    <!-- Start tabs -->
<ul class="wp-tab-bar trainee-tab-bar">
        <?php if($tabs && count((array)$tabs) > 0): $counter = 0; foreach ($tabs as $tab): ?>
        <li <?php if($counter == 0) { echo 'class="wp-tab-active"'; } ?>><a id="name_<?php echo $counter; ?>" href="#tabs-<?php echo strtolower(str_replace(' ', '_', $tab->tabTitle)); ?>"><?php echo $tab->tabTitle; ?></a></li>
        <?php $counter++; endforeach; endif; ?>
</ul>
<div id="questionnaire_solution_form">
    <?php $counter = 0; foreach ($tabs as $tab): $titleLower = strtolower(str_replace(' ', '_', $tab->tabTitle)); ?>
        <div data-tab-name="<?php echo $titleLower; ?>" class="wp-tab-panel lctrainee-tab-panel solution_tab" id="tabs-<?php echo $titleLower; ?>" <?php if( $counter > 0 ) { echo 'style="display: none;"' ;} ?>>
            <div class="tabLongTitle">
                <div>
                    <label><?php _e('Enter the minimum number of points, bellow which solutions should appear after user finishes with the questionnaire', 'trainee') ?></label>
                    <input id="max_solution_points" class="max_solution_points" type="text" placeholder="" value="<?php echo $solutionsSettings ? $solutionsSettings[$counter]->minPoints : ''; ?>">
                </div>

                <div>
                    <label><?php _e('Please select solutions', 'trainee') ?></label>
                    <select multiple="multiple" id="solutionSelect_<?php echo $titleLower; ?>" class="solutionSelector" name="searchable[]">

                        <?php foreach ($causeSolutions as $cs): ?>
                            <optgroup label='<?php echo $cs['name']; ?>'>

                                <?php foreach ($cs['solutions'] as $s): ?>
                                    <option <?php echo in_array($s->ID, $solutionsSettings[$counter]->solutions) ? 'selected' : ''; ?> value='<?php echo $s->ID; ?>'><?php echo $s->post_name ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
        </div>
    <?php  $counter++; endforeach;  ?>
    <a href="#" id="trainee-solution-settings-save" class="button-primary button"> <?php _e('Save', 'trainee'); ?> </a>
</div>

<div class="tabLongTitle">
    <div>
        <label for="exportedJson">Export/Import</label>
        <textarea id="exportedJson" class="longTitle" type="text" placeholder=""></textarea>
    </div>

    <div style="margin: 15px 0;">
        <a class="button trainee-s-export button-primary customize load-customize hide-if-no-customize"><?php _e('Export content', 'trainee') ?></a>
        <a class="button trainee-s-import button-primary customize load-customize hide-if-no-customize"><?php _e('Import content', 'trainee') ?></a>
    </div>
</div>