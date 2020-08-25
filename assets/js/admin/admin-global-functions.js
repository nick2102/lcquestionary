function generateQuestionGroup (id, optionsContainer) {
    var random = Math.random().toString(36).slice(-5);
    var group = '<div class="trainee-field-set">' +
        '            <div class="trainee-reorder-slide option_li_sides">' +
        '                <span class="dashicons dashicons-move"></span>' +
        '            </div>' +
        '            <label> '+ window.traineeTranslations.question +' </label>' +
        '            <input type="text" name="question" placeholder="">' +
        '            <label> '+ window.traineeTranslations.tip +' </label>' +
        '            <input type="text" name="tip" placeholder="">' +
        '            <a id="add_structure" data-count-options="'+ id +'" data-list="#questionnaire-'+ optionsContainer +'-options-list-'+ id +'" class="trainee-o-add button button-primary customize load-customize hide-if-no-customize">'+ window.traineeTranslations.addOption +'</a>' +
        '            <br>' +
        '            <br>' +
        '            <label> '+ window.traineeTranslations.mandatory +'</label>' +
        '             <select name="mandatory">' +
        '                <option value="1">'+ window.traineeTranslations.yes +'</option>' +
        '                <option value="0">'+ window.traineeTranslations.no +'</option>' +
        '            </select>' +
        //'            <label> '+ window.traineeTranslations.multipleChoice +'</label>' +
        //'             <select name="multipleChoice">' +
        //'                <option value="0">'+ window.traineeTranslations.no +'</option>' +
        //                <option value="1">'+ window.traineeTranslations.yes +'</option>' +
        //'            </select>' +
        '            <hr>' +
        '            <div class="questionnaire-structure-options-list" id="questionnaire-'+ optionsContainer +'-options-list-'+ id +'" >' +
        '                <div class="questionnaire-options">' +
        '                    <div class="trainee-reorder-slide option_li_sides">' +
        '                        <span class="dashicons dashicons-move"></span>' +
        '                    </div>' +
        '                    <div>' +
        '                        <label> '+ window.traineeTranslations.optionName +' </label>' +
        '                        <input name="optionName" type="text" placeholder="">' +
        '                    </div>' +
        '                    <div>' +
        '                        <label> '+ window.traineeTranslations.lossIn +' </label>' +
        '                        <input name="energyLoss" type="text" placeholder="">' +
        '                    </div>' +
        '                    <div>' +
        '                        <label> '+ window.traineeTranslations.icon +' </label>' +
        '                        <div class="lc_option_icon_box">' +
        '                            <input class="regular-text" id="lc_'+ random +'_trainee_option_placeholder" readonly name="energyIcon" type="text" value="">' +
        '                            <button class="button rational-metabox-media" id="lc_'+ random +'_trainee_option_button" type="button">'+ window.traineeTranslations.selectIcon +'</button>' +
        '                        </div>' +
        '                    </div>' +
        '                   <div style="width: 100%">' +
        '                       <label> '+ window.traineeTranslations.possibleSolution +'</label>' +
        '                       <textarea style="width: 100%" name="energyPossibleSolution" placeholder=""></textarea>' +
        '                   </div>' +
        '                    <div class="lctrainee-delete-slide remove_field option_li_sides">' +
        '                        <span class="dashicons dashicons-trash"></span>' +
        '                    </div>' +
        '                </div>' +
        '            </div>' +
        '            <div class="lctrainee-delete-slide remove_field option_li_sides">' +
        '                <span class="dashicons dashicons-trash"></span>' +
        '            </div>' +
        '        </div>';

    return group
}

function generateOptionsGroup(id) {
    var random = Math.random().toString(36).slice(-5);
    var group = '<div class="questionnaire-options">' +
                    '<div class="trainee-reorder-slide option_li_sides">' +
                        '<span class="dashicons dashicons-move"></span>' +
                    '</div>' +
                    '<div>' +
                        '<label>'+ window.traineeTranslations.optionName +' </label>' +
                        '<input name="optionName" type="text" placeholder="">' +
                    '</div>' +
                    '<div>' +
                        '<label> '+ window.traineeTranslations.lossIn +'</label>' +
                        '<input name="energyLoss" type="text" placeholder="">' +
                    '</div>' +
                    '<div>' +
                        '<label>'+ window.traineeTranslations.icon +' </label>' +
                            '<div class="lc_option_icon_box">' +
                            '<input class="regular-text" id="lc_'+ random +'_trainee_option_placeholder" readonly name="energyIcon"  type="text" value="">' +
                            '<button class="button rational-metabox-media" id="lc_'+ random +'_trainee_option_button" type="button">'+ window.traineeTranslations.selectIcon +'</button>                     ' +
                        '</div>' +
                    '</div>' +
                    '<div style="width: 100%">' +
                        '<label> '+ window.traineeTranslations.possibleSolution +'</label>' +
                        '<textarea style="width: 100%" name="energyPossibleSolution" placeholder=""></textarea>' +
                    '</div>' +
                        '<div class="lctrainee-delete-slide remove_field option_li_sides">' +
                        '<span class="dashicons dashicons-trash"></span>' +
                    '</div>' +
                '</div>';

    return group;
}

function generateQuestionnaireObject (tabs) {
    var formObject = {}

    Object.keys(tabs).forEach(function(tabsKey) {
        if(Number.isInteger(parseInt(tabsKey))){
            var tabId = jQuery(tabs[tabsKey]).attr('id');
            var questions = jQuery('#' + tabId).find('.trainee-field-set');
            var tabName = jQuery('#tabName_' + tabId);
            var tabTitle = tabName.val();
            var tabLongTitle = jQuery('#longTitle_'+ tabId).val();
            var sectionCover = jQuery('.section_cover_' + tabId).val();
            var tabTitleEditable = jQuery('#tabName_' + tabId + '_title').val();
            var sectionFullPoints = 0;

            formObject[tabId] = {tabTitle : tabTitle, tabTitleEditable: tabTitleEditable, title: tabLongTitle, sectionCover: sectionCover, questions: {}};

            Object.keys(questions).forEach(function(questionsKey) {
                if(Number.isInteger(parseInt(questionsKey))){

                    var qt = jQuery(questions[questionsKey]).find('> input');
                    var qtSelect = jQuery(questions[questionsKey]).find('> select');
                    var optionsContainer = jQuery(questions[questionsKey]).find('.questionnaire-structure-options-list .questionnaire-options');
                    var options = {};

                    formObject[tabId]['questions'][questionsKey] = {};

                    formObject[tabId]['questions'][questionsKey]['mandatory'] = jQuery(qtSelect[0]).val();
                    formObject[tabId]['questions'][questionsKey]['multipleSelect'] = jQuery(qtSelect[1]).val();

                    Object.keys(qt).forEach(function (qtKey) {
                        if(Number.isInteger(parseInt(qtKey))){

                            var objKey = jQuery(qt[qtKey]).attr('name');
                            formObject[tabId]['questions'][questionsKey][objKey] = jQuery(qt[qtKey]).val();

                        }
                    });

                    Object.keys(optionsContainer).forEach(function (optionsContainerKey) {
                        if(Number.isInteger(parseInt(optionsContainerKey))){
                            var optionInputs = jQuery(optionsContainer[optionsContainerKey]).find('input');
                            var optionTextAreas = jQuery(optionsContainer[optionsContainerKey]).find('textarea');
                            options[optionsContainerKey] = {};

                            Object.keys(optionInputs).forEach(function (optionInputsKey) {
                                if(Number.isInteger(parseInt(optionInputsKey))){
                                    var objKey = jQuery(optionInputs[optionInputsKey]).attr('name');
                                    var value =  jQuery(optionInputs[optionInputsKey]).val();

                                    options[optionsContainerKey][objKey] = value
                                }
                            });

                            Object.keys(optionTextAreas).forEach(function (optionTextAreaKey) {
                                if(Number.isInteger(parseInt(optionTextAreaKey))){
                                    var objKey = jQuery(optionTextAreas[optionTextAreaKey]).attr('name');
                                    var value =  jQuery(optionTextAreas[optionTextAreaKey]).val();

                                    options[optionsContainerKey][objKey] = value
                                }
                            });
                        }
                    });

                    formObject[tabId]['questions'][questionsKey].options = options;

                    var allPoints = Object.values(options).map(function(option){ return option.energyLoss} );
                    var maxVal = Math.max.apply(null, allPoints)
                    sectionFullPoints = sectionFullPoints + parseInt(maxVal);

                    formObject[tabId]['sectionMaxPoints'] = sectionFullPoints;
                }
            });
        }
    });

    return formObject;
}

function generateLevelsData(levels) {
    var formObject = {}

    Object.keys(levels).forEach(function (index) {
        if(Number.isInteger(parseInt(index))){
            var level = jQuery(levels[index]).attr('data-level');
            var inputs = jQuery(levels[index]).find('input');

            formObject[level] = {};

            Object.keys(inputs).forEach(function (inputIndex) {
                if(Number.isInteger(parseInt(inputIndex))){
                    var key = jQuery(inputs[inputIndex]).attr('name');
                    var value = jQuery(inputs[inputIndex]).val();

                    formObject[level][key] = value;
                }
            });
        }
    });

    return formObject;
}

function generateTabSolutionData (tabs) {
    var formObject = []

    Object.keys(tabs).forEach(function (tabIndex) {
        if (Number.isInteger(parseInt(tabIndex))) {
            var section = jQuery(tabs[tabIndex]).attr('data-tab-name');
            var minPoints = jQuery(tabs[tabIndex]).find('.max_solution_points');
            var solutions = jQuery(tabs[tabIndex]).find('.solutionSelector');
            formObject[tabIndex] = {
                section: section,
                minPoints: jQuery(minPoints[0]).val(),
                solutions: jQuery(solutions[0]).val()
            }
        }
    });

    return formObject;
}

function generateRanges () {
    var years = jQuery('#trainee_years_range').val();
    var squares = jQuery('#trainee_square_range').val();
    var occupants = jQuery('#trainee_occupants_range').val();

    return {
        years: years,
        squares: squares,
        occupants: occupants
    };
}