jQuery(document).ready( function($) {
    $('body').on('click', '.wp-tab-bar a', function(event){
        event.preventDefault();

        // Limit effect to the container element.
        var context = $(this).closest('.wp-tab-bar').parent();
        $('.wp-tab-bar li', context).removeClass('wp-tab-active');
        $(this).closest('li').addClass('wp-tab-active');
        $('.wp-tab-panel', context).hide();
        $( $(this).attr('href'), context ).show();
    });

    // Make setting wp-tab-active optional.
    $('.wp-tab-bar').each(function(){
        if ( $('.wp-tab-active', this).length )
            $('.wp-tab-active', this).click();
        else
            $('a', this).first().click();
    });

    $( ".structure-questions, .questionnaire-structure-options-list" ).sortable({
        handle: ".trainee-reorder-slide",
    });
    $( ".structure-questions" ).sortable({
        handle: ".trainee-reorder-slide",
    });
    $( ".structure-questions, .questionnaire-structure-options-list" ).disableSelection();


    $('body').on('click', '.trainee-q-add', function (e) {
            e.preventDefault();
            var tab = $(this).attr('data-tab');
            var qCount = $(this).attr('data-count-questions');
            var optionsContainer = $(this).attr('data-options-container');
            var groupId = parseInt(qCount) + 1;
            var html = generateQuestionGroup(groupId, optionsContainer);
            $(tab).append(html);

            $(this).attr('data-count-questions', groupId);
    });

    $('body').on('click', '.trainee-o-add', function (e) {
        e.preventDefault();
        var tab = $(this).attr('data-list');
        var qCount = $(this).attr('data-count-options');
        var groupId = parseInt(qCount) + 1;
        var html = generateOptionsGroup(groupId);
        $(tab).append(html);

        $( ".questionnaire-structure-options-list").sortable({
            handle: ".trainee-reorder-slide",
        });

        $( ".structure-questions, .questionnaire-structure-options-list" ).disableSelection();

        $(this).attr('data-count-options', groupId);
    });

    $('body').on('click', '.remove_field', function (e) {
        if(confirm("Delete this item?")){
            var fieldSet = $(this).parent();
            fieldSet.remove();

        }
    });

    $('body').on('click', '.trainee-save-questionnaire', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var form = $('#questionnaire_form');
        var tabs = form.find('.structure-questions');
        var formData = generateQuestionnaireObject(tabs);

        traineeRequest.endpoint = '/save-questionnaire';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('questionnaireData', JSON.stringify(formData));
        traineeRequest.execute(function (response) {
            Swal.fire(window.traineeTranslations.successTitle, response.data.message, 'success');
        });
    });

    $('body').on('click', '.trainee-save-questionnaire-cpt', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var form = $('#questionnaire_form');
        var tabs = form.find('.structure-questions');
        var formData = generateQuestionnaireObject(tabs);
        $('input[name="lctrainee_questionnaire"]').val(JSON.stringify(formData));
        $('#publish').trigger('click');
    });

    $('body').on('click', '#addSection', function (e) {
        e.preventDefault();

        var tabNumber = $(this).attr('data-tab');
        var newTabNumber = parseInt(tabNumber) + 1;
        var tab = $('#tabName');
        var tabName = tab.val();
        var tabArray = tabName.toLowerCase().split(' ');
        var tabID = tabArray.join('_');
        var tabMenu = $('.trainee-tab-bar');
        var displayNone = tabNumber > 1 ? 'style="display: none;"' : '', wpActive = tabNumber < 2 ? 'wp-tab-active' : '';

        if(tabName === '') {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.noEmptyTab, 'error');
        }

        if(!/^[aA-zZ0-9]+([aA-zZ0-9-_ ])+$/.test(tabID)) {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.tabRegex, 'error');
        }

        if(tabMenu.find('a#name_'+ tabID).length > 0) {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.tabExists, 'error');
        }

        var random = Math.random().toString(36).slice(-5);
        var tabMenuItem = '<li class="'+ wpActive +'"><a id="name_'+tabID+'" href="#tabs-'+tabID+'">'+tabName+'</a></li>';
        var tabContent = '<div class="wp-tab-panel lctrainee-tab-panel" id="tabs-'+tabID+'" '+ displayNone +'>' +
                         '<br>' +
                         '<div class="tabLongTitle">' +
                         '<div>' +
                         '<label>'+ window.traineeTranslations.tabName +'</label>' +
                         '<input id="tabName_' + tabID +'_questions" name="_tabName" type="hidden" value="'+tabName+'">'+
                         '<input id="tabName_' + tabID +'_questions_title" name="_tabTitle" type="text" value="'+tabName+'">'+
                         '<label>'+ window.traineeTranslations.title +'</label>' +
                         '<input id="longTitle_' + tabID +'_questions" class="longTitle" type="text" placeholder="">' +
                         '<label>'+ window.traineeTranslations.sectionCoverImage +'</label>' +
                         '<div class="lc_option_icon_box">' +
                         '<input class="regular-text section_cover_'+ tabID +'_questions" id="lc_'+ random +'_trainee_option_placeholder" readonly name="sectionCover" type="text" value="">' +
                         '<button class="button rational-metabox-media" id="lc_'+ random +'_trainee_option_button" type="button">'+ window.traineeTranslations.sectionCoverImage +'</button>' +
                         '</div>' +
                         '</div>' +
                         '</div>'+
                         '<a data-count-questions="1" data-options-container="'+tabID+'" data-tab="#'+ tabID +'_questions" class="button trainee-q-add button-primary customize load-customize hide-if-no-customize">'+ window.traineeTranslations.addQuestion +'</a>' +
                         '<a data-menu="#name_'+tabID+'" href="#" id="deleteTab"><span class="dashicons dashicons-trash"></span>'+ window.traineeTranslations.deleteTab +'</a>'+
                         '<div id="'+ tabID +'_questions" class="structure-questions">' +
                         '</div>'+
                         '</div>';


        tabMenu.append(tabMenuItem);
        $('#questionnaire_form').append(tabContent);
        $(this).attr('data-tab', newTabNumber );
        tab.val('');
    });

    $('body').on('click', '#deleteTab', function (e) {
        e.preventDefault();
        var menu = $(this).attr('data-menu');
        if(confirm(window.traineeTranslations.deleteTabText)){
            $(this).parent().remove();
            $(menu).remove();
        }
    });

    $('body').on('click', '.trainee-q-export', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var form = $('#questionnaire_form');
        var tabs = form.find('.structure-questions');
        var formData = generateQuestionnaireObject(tabs);
        $('#exportedJson').val(JSON.stringify(formData));
        $('.loadingScreen').css('display', 'none');
    });

    $('body').on('click', '.trainee-q-import', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var content = $('#exportedJson').val();
        $('input[name="lctrainee_questionnaire"]').val(content);
        $('#publish').trigger('click');
    });

    $('body').on('click', '.trainee-ee-indicator-save', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var form = $('.indicators-wrapper');
        var levels = form.find('.indicator-item');
        var formData = generateLevelsData(levels);

        traineeRequest.endpoint = '/save-ee-indicator';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('eeIndicatorData', JSON.stringify(formData));
        traineeRequest.execute(function (response) {
            Swal.fire(window.traineeTranslations.successTitle, response.data.message, 'success');
        });

    });

    $('body').on('click', '#trainee-solution-settings-save', function (e) {
        e.preventDefault();
        var solutionTabs = $('#questionnaire_solution_form').find('.solution_tab');
        var ranges = generateRanges();
        var postID = $('#select_q').val();
        var solutionsObj = generateTabSolutionData(solutionTabs);

        traineeRequest.endpoint = '/save-q-solutions-tabs';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('post_id', postID);
        traineeRequest.addPostParam('solutions', JSON.stringify(solutionsObj));
        traineeRequest.addPostParam('ranges', JSON.stringify(ranges));
        traineeRequest.execute(function (response) {
            Swal.fire(window.traineeTranslations.successTitle, response.data.message, 'success');
        });

    });

    $('body').on('change', '#select_q', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var postID = $(this).val();

        if(!postID)
            return;

        traineeRequest.endpoint = '/get-q-solutions-tabs';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('post_id', postID);
        traineeRequest.execute(function (response) {
           $('#q-solution-panel-wrapper').html(response.data.tabs);
           var selects = $('.solutionSelector');
           Object.keys(selects).forEach(function (index) {
               if(Number.isInteger(parseInt(index))){
                   var select = $(selects[index]);

                   select.multiSelect({
                       selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Serach...'>",
                       selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Serach...'>",
                       afterInit: function(ms){
                           var that = this,
                               $selectableSearch = that.$selectableUl.prev(),
                               $selectionSearch = that.$selectionUl.prev(),
                               selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                               selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                           that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                               .on('keydown', function(e){
                                   if (e.which === 40){
                                       that.$selectableUl.focus();
                                       return false;
                                   }
                               });

                           that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                               .on('keydown', function(e){
                                   if (e.which == 40){
                                       that.$selectionUl.focus();
                                       return false;
                                   }
                               });
                       },
                       afterSelect: function(){
                           this.qs1.cache();
                           this.qs2.cache();
                       },
                       afterDeselect: function(){
                           this.qs1.cache();
                           this.qs2.cache();
                       }
                   });
               }
           });
        });

    });

    $('body').on('click', '.trainee-s-export', function (e) {
        e.preventDefault();
        var solutionTabs = $('#questionnaire_solution_form').find('.solution_tab');
        var solutionsObj = generateTabSolutionData(solutionTabs);
        var rangeSettings = generateRanges();
        var questionnaireSettings = {
            solutions : solutionsObj,
            ranges: rangeSettings
        }

        $('#exportedJson').val(JSON.stringify(questionnaireSettings));
    });

    $('body').on('click', '.trainee-s-import', function (e) {
        e.preventDefault();
        var postID = $('#select_q').val();
        var solutionsObj =  JSON.parse($('#exportedJson').val());

        if(!solutionsObj){
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.exportImportEmpty, 'error');
        }

        traineeRequest.endpoint = '/save-q-solutions-tabs';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('post_id', postID);
        traineeRequest.addPostParam('solutions', JSON.stringify(solutionsObj.solutions));
        traineeRequest.addPostParam('ranges', JSON.stringify(solutionsObj.ranges));
        traineeRequest.execute(function (response) {
            Swal.fire(window.traineeTranslations.successTitle, response.data.message, 'success');
        });
    });
});
