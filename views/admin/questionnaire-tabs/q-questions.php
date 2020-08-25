    <?php
        $titleLower = strtolower(str_replace(' ', '_', $tab->tabTitle));
    ?>
   <div class="wp-tab-panel lctrainee-tab-panel" id="tabs-<?php echo $titleLower; ?>" <?php if( $counter > 0 ) { echo 'style="display: none;"' ;} ?>>
        <br>
        <a data-count-questions="<?php echo count((array)$tab->questions); ?>" data-options-container="<?php echo $titleLower; ?>" data-tab="#<?php echo $titleLower; ?>_questions" class="button trainee-q-add button-primary customize load-customize hide-if-no-customize"><?php _e('Add Question', 'trainee'); ?></a>
        <a href="#" data-menu="#name_<?php echo $counter; ?>" id="deleteTab"><span class="dashicons dashicons-trash"></span> Delte Tab</a>
       <div class="tabLongTitle">
           <div>
               <label><?php _e('Tab Name', 'trainee'); ?></label>
               <input id="tabName_<?php echo $titleLower; ?>_questions" name="_tabName" type="hidden" value="<?php echo $tab->tabTitle; ?>">
               <input id="tabName_<?php echo $titleLower; ?>_questions_title" name="_tabTitle" type="text" value="<?php echo isset($tab->tabTitleEditable) ? $tab->tabTitleEditable : ''; ?>">
               <label><?php _e('Title', 'trainee'); ?></label>
               <input id="longTitle_<?php echo $titleLower; ?>_questions" class="longTitle" type="text" placeholder="" value="<?php echo $tab->title; ?>">
               <label><?php _e('Select Image', 'trainee'); $coverRandom = sha1(rand() + time());  ?></label>
               <div class="lc_option_icon_box">
                   <input class="regular-text section_cover_<?php echo $titleLower; ?>_questions" id="lc_<?php echo $coverRandom; ?>_trainee_option_placeholder" readonly name="sectionCover" type="text" value="<?php echo isset($tab->sectionCover) ? $tab->sectionCover : ''; ?>">
                   <button class="button rational-metabox-media" id="lc_<?php echo $coverRandom; ?>_trainee_option_button" type="button"><?php _e('Select Image', 'trainee'); ?></button>
               </div>
           </div>
       </div>
       <div id="<?php echo $titleLower; ?>_questions" class="structure-questions">
            <?php foreach ($tab->questions as $question) : ?>
                <div class="trainee-field-set">

                    <div class="trainee-reorder-slide option_li_sides">
                        <span class="dashicons dashicons-move"></span>
                    </div>

                    <label> <?php _e('Question', 'trainee'); ?> </label>
                    <input type="text" name="question" placeholder="" value="<?php echo $question->question; ?>" >

                    <label> <?php _e('Tip', 'trainee'); ?> </label>
                    <input type="text" name="tip" placeholder="" value="<?php echo $question->tip; ?>">
                    <?php $random =  sha1(rand() + time());?>
                    <a data-count-options="<?php echo count((array)$question->options) ?>" data-list="#questionnaire-usage-options-list-<?php echo $random; ?>" class="button trainee-o-add button-primary customize load-customize hide-if-no-customize"><?php _e('Add Option', 'trainee'); ?></a>
                    <br>
                    <br>
                    <label> <?php _e('Mandatory', 'trainee'); ?></label>
                    <select name="mandatory">
                        <option <?php selected($question->mandatory, '1') ?> value="1"><?php _e('Yes', 'trainee'); ?></option>
                        <option <?php selected($question->mandatory, '0') ?> value="0"><?php _e('No', 'trainee'); ?></option>
                    </select>
<!--                    <label> --><?php //_e('Multiple choice', 'trainee'); ?><!--</label>-->
<!--                    <select name="multipleChoice">-->
<!--                        <option --><?php //selected($question->multipleSelect, '0') ?><!-- value="0">--><?php //_e('No', 'trainee'); ?><!--</option>-->
<!--                        <option --><?php //selected($question->multipleSelect, '1') ?><!-- value="1">--><?php //_e('Yes', 'trainee'); ?><!--</option>-->
<!--                    </select>-->
                    <hr>
                    <div id="questionnaire-usage-options-list-<?php echo $random; ?>" class="questionnaire-structure-options-list">
                        <?php foreach ($question->options as $option): ?>
                            <div class="questionnaire-options">
                                <div class="trainee-reorder-slide option_li_sides">
                                    <span class="dashicons dashicons-move"></span>
                                </div>
                                <div>
                                    <label><?php _e('Option Name', 'trainee'); ?></label>
                                    <input name="optionName" type="text" placeholder="" value="<?php echo $option->optionName; ?>">
                                </div>

                                <div>
                                    <label><?php _e('Points', 'trainee'); ?></label>
                                    <input name="energyLoss" type="text" placeholder="" value="<?php echo $option->energyLoss; ?>">
                                </div>

                                <div>
                                    <label><?php _e('Icon', 'trainee'); ?></label>
                                    <div class="lc_option_icon_box">
                                        <?php $random =  sha1(rand() + time());?>
                                        <input class="regular-text" id="lc_<?php echo $random; ?>_trainee_option_placeholder" readonly name="energyIcon"  type="text"  value="<?php echo $option->energyIcon; ?>">
                                        <button class="button rational-metabox-media" id="lc_<?php echo $random; ?>_trainee_option_button" type="button"><?php _e('Select Icon', 'trainee'); ?></button>
                                    </div>
                                </div>
                                <div style="width: 100%;">
                                    <label><?php _e('Possible Solution', 'trainee'); ?></label>
                                    <textarea style="width: 100%" name="energyPossibleSolution" placeholder=""><?php echo $option->energyPossibleSolution; ?></textarea>
                                </div>
                                <div class="lctrainee-delete-slide remove_field option_li_sides">
                                    <span class="dashicons dashicons-trash"></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="lctrainee-delete-slide remove_field option_li_sides">
                        <span class="dashicons dashicons-trash"></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>