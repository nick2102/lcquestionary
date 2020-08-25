<?php
$buildings = $data['buildings'];
$questionsCount = count((array)$data['questionnaire']);
?>
<script>window.traineeRanges = JSON.parse('<?php echo json_encode($data['ranges']); ?>')</script>    
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div id="questionnaireIndicators" class="steps-indicator">
                <div class="q_single_indicator q-ind-1 active">
                    <span class="q_number"><?php _e('Home Info', 'trainee'); ?></span>
                </div>
                <?php $count = 1; foreach ($data['questionnaire'] as $key => $tab): $count++; ?>
                    <div class="q_single_indicator q-ind-<?php echo $count; ?><?php if($count == 1){ echo ' active'; } ?>">
                        <span class="q_number"><?php echo $tab->tabTitleEditable; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="questionnaireSteps" class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

            <form id="trainee-q-form" data-questionnaire-id="<?php echo $data['questionnaire_id']; ?>">
                <div
                        id="q-step-1"
                        data-step-name="user_address_info"
                        class="q-step q-step-1"
                >
                    <h3><?php _e('Tell us more about the location of your home', 'trainee'); ?></h3>
                    <?php echo LcTrainee_Render_View::view('questionnaire/partials/maps', $data) ?>

                    <div class="q-tab-footer">
                        <button
                            <?php echo isset($data['profile']) && $data['profile']['is_certified'] ? 'style="display: none;"' : ''; ?>
                                class="btn btn-primary trainee-system-map-next-step for_not_certified"
                                data-current-step="#q-step-1"
                                data-next-step="#q-step-2"
                                data-question-count=""
                                data-next-num="2"
                                data-current-num="1"
                        >
                            <?php _e('Next step', 'trainee'); ?>
                        </button>
                    </div>
                </div>

                <?php $count = 1; foreach ($data['questionnaire'] as $key => $tabs) :
                        $count++; $questionName = $key.'_q_';
                        //Loop in every Questions Tab
                ?>
                    <div
                        id="q-step-<?php echo $count; ?>"
                        data-step-name="<?php echo $key; ?>"
                        class="q-step q-step-<?php echo $key; ?>"
                        <?php if($count > 1) { echo 'style="display:none;"'; } ?>
                    >
                        
                    <div class="row">
                        <div id="sticky-sidebar" class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                            <div class="side-step-cover sticky-top">
                                <?php if(isset($tabs->sectionCover)): ?>
                                    <div class="ste-cover-image">
                                        <img class="img-fluid" src="<?php echo $tabs->sectionCover?>" alt="<?php echo isset($tab->tabTitleEditable) ? $tabs->tabTitleEditable : ''; ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="step-side-number">
                                    <?php 
                                        echo str_pad($count, 2, "0", STR_PAD_LEFT)
                                    ?>
                                </div>
                                <h3><?php echo $tabs->title; ?></h3>
                            </div>
                        </div><!-- //.col*-3/sticky-sidebar -->

                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                            
                        <?php foreach ($tabs->questions as $tabKey => $tab): //Loop every Question inside Tab ?>
                            <div class="q-question">
                                <div class="step-question"><?php echo $tab->question; ?></div>

                                <div class="step-options">
                                    <?php
                                        $tabData = ['profile' => $data['profile'], 'questionIndex' => $tabKey, 'isMandatory' => $tab->mandatory, 'stepName' => $key, 'options' => $tab->options, 'questionName' => $questionName.$tabKey];
                                        echo LcTrainee_Render_View::view('questionnaire/partials/singlechoice', $tabData);
                                    ?>
                                </div>

                                <?php if($tab->tip): ?>
                                    <div class="step-tip"><?php echo $tab->tip; ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                            <div class="q-tab-footer">

                                <?php if($count > 1): ?>
                                    <button
                                        class="btn btn-secondary trainee-system-q-prev-step"
                                        data-current-step="#q-step-<?php echo $count ?>"
                                        data-prev-step="#q-step-<?php echo $count - 1 ?>"
                                        data-prev-num="<?php echo $count - 1 ?>"
                                        data-current-num="<?php echo $count ?>"
                                    >
                                        <?php _e('Previous step', 'trainee'); ?>
                                    </button>
                                <?php endif; ?>

                                <?php if($count <= $questionsCount): ?>
                                    <button
                                        class="btn btn-primary trainee-system-q-next-step"
                                        data-current-step="#q-step-<?php echo $count ?>"
                                        data-next-step="#q-step-<?php echo $count + 1 ?>"
                                        data-question-count="<?php echo count((array)$tabs->questions); ?>"
                                        data-next-num="<?php echo $count + 1 ?>"
                                        data-current-num="<?php echo $count ?>"
                                    >
                                        <?php _e('Next step', 'trainee'); ?>
                                    </button>
                                <?php endif; ?>
                                <?php if($count > $questionsCount): ?>
                                    <button
                                        class="btn btn-primary trainee-system-q-finish-wizard"
                                        data-current-step="#q-step-<?php echo $count ?>"
                                        data-question-count="<?php echo count((array)$tabs->questions); ?>"
                                    >
                                        <?php _e('Finish', 'trainee'); ?>
                                    </button>
                                <?php endif; ?>
                            </div> <!-- //.q-tab-footer | Footer end -->
                        </div><!-- //.col*-9 -->
                    </div>


                    </div> <!-- //#q-step- -->
                <?php endforeach; ?>
            </form>
        </div><!-- //#questionnaireSteps -->
    </div> <!-- //.row (second div) -->
<?php
$shortcode = "[trainee_modal modalid=\"mapMobilePopup\" modaltitle=\"". __('Building Info', 'trainee') ."\"]
     <div class=\"bubble_address\">". __('Address', 'trainee') .": <span></span></div>
     <div class=\"bubble_mark\">". __('Energy Mark', 'trainee') .": <span></span></div>
     <div class=\"bubble_investor\">". __('Investor', 'trainee') .": <span></span></div>
     <hr>
     <button 
     data-dismiss=\"modal\"
     data-title=\"#\" 
     data-street=\"#\" 
     data-lat=\"#\" 
     data-lng=\"#\" 
     data-building-id=\"#\" 
     class=\"btn btn-primary trainee-select-address bubble_select_street_mobile\">
     " . __('Select address', 'trainee') . "
     </button>
     <a 
     id=\"certLink\"
     href=\"#\" 
     target=\"_blank\" class=\"btn btn-primary\">
     ". __('View certificate', 'trainee') ." 
     </a>
     [/trainee_modal]";
echo do_shortcode($shortcode);
?>
<script>
     window.buildings = JSON.parse('<?php echo $buildings; ?>');
</script>
