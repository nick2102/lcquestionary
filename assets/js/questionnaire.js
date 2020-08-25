jQuery(document).ready(function ($) {
    // MAPS API KEY
    var platform = new H.service.Platform({
        'apikey': window.hereMapsKey,
    });
    var defaultLayers = platform.createDefaultLayers();

    function hereMapInit () {
        //Step 2: initialize a map - this map is centered over California
        var map = new H.Map(document.getElementById('traineeMap'),
            defaultLayers.vector.normal.map,{  pixelRatio: window.devicePixelRatio || 1 });
        return map;
    }

    if($('#traineeMap').length > 0) {
        var map = hereMapInit();
        window.hereMap = map;
        window.traineeBubble = false;
        // add a resize listener to make sure that the map occupies the whole container
        window.addEventListener('resize', function (){map.getViewPort().resize()});
        // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
        var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

        // Create the default UI components
        var ui = H.ui.UI.createDefault(map, defaultLayers);

        addLocationsToMap(map, window.buildings, ui);
    }


    $('body').on('click', '.trainee-system-q-next-step', function (e) {
        e.preventDefault();
        var currentStep = $(this).attr('data-current-step');
        var nextStep = $(this).attr('data-next-step');
        var nextStepNum = $(this).attr('data-next-num');
        var questionCount = $(this).attr('data-question-count');
        var answers = $(currentStep).find('.q-option-check:checked');

        if(parseInt(questionCount) > answers.length) {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.requiredQuestions, 'error');
        }

        $(currentStep).hide();
        $(nextStep).show();
        $('.q-ind-' + nextStepNum).addClass('active');

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#questionnaireSteps").offset().top - 200
        }, 800);
    });

    $('body').on('click', '.trainee-system-q-prev-step', function (e) {
        e.preventDefault();

        var currentStep = $(this).attr('data-current-step');
        var currentStepNum = $(this).attr('data-current-num');
        var prevStep = $(this).attr('data-prev-step');

        $(currentStep).hide();
        $(prevStep).show();
        $('.q-ind-' + currentStepNum).removeClass('active');

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#questionnaireSteps").offset().top - 200
        }, 800);
    });

    $('body').on('click', '.trainee-system-q-finish-wizard', function (e) {
        e.preventDefault();
        var currentStep = $(this).attr('data-current-step');
        var questionCount = $(this).attr('data-question-count');
        var answers = $(currentStep).find('.q-option-check:checked');
        var form = $('#trainee-q-form');
        var questionnaireId = $('#trainee-q-form').attr('data-questionnaire-id')

        if(parseInt(questionCount) > answers.length) {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.requiredQuestions, 'error');
        }

        $('.loadingScreen').css('display', 'flex');
        traineeRequest.endpoint =  'save-profile-questionnaire';
        traineeRequest.method = 'post';
        traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
        traineeRequest.addPostParam('questionnaireData', form.serializeArray());
        traineeRequest.addPostParam('questionnaire_id', questionnaireId);
        traineeRequest.addPostParam('building_id', $('#building_id').val());
        traineeRequest.execute(function (response) {
            window.location.href = window.energyProfilePage;
        });


    });

    $('body').on('change', '#residence_city', function (e) {
        e.preventDefault();

        var lng = $(this).find(':selected').attr('data-lng');
        var lat = $(this).find(':selected').attr('data-lat');
        var theMap = window.hereMap;
        theMap.setCenter({lat:lat, lng:lng});
        theMap.setZoom(11);

        $('#address').val('');
        $('#address').attr('readonly', false);
        $('#have_certificate').val('');
        $('#have_certificate').attr('data-building-id', '');
        $('#building_id').val('');
        $('.for_not_certified').show();
        $('.for_certified').hide();

        $('.for_not_certified input').val('');
        $('#certified_badge').removeClass(function (index, classNames) {
            var current_classes = classNames.split(" "), // change the list into an array
                classes_to_remove = []; // array of classes which are to be removed

            $.each(current_classes, function (index, class_name) {
                // if the classname begins with bg add it to the classes_to_remove array
                if (/mark_.*/.test(class_name)) {
                    classes_to_remove.push(class_name);
                }
            });
            // turn the array back into a string
            return classes_to_remove.join(" ");
        });

    });

    if($('#address').length) {
        autocomplete({
            input: document.getElementById('address'),
            minLength: 2,
            preventSubmit: true,
            onSelect: function (item, inputfield) {
                $('.for_not_certified').hide();
                $('.for_certified').show();
                inputfield.value = item.label
                trainee_select_street(item.value);
                inputfield.readOnly = true;
                $('#have_certificate').val('true');
                $('#have_certificate').attr('data-building-id', item.value.id);
                $('#building_id').val(item.value.id);
                $('#certified_badge').addClass('mark_' + item.value.certificate);
                $('#building_cert').html(mapMark(item.value.certificate));
                $('.for_not_certified input').val('false');
            },
            fetch: function (text, callback) {
                var match = trainee_transliterate(text.toLowerCase());
                var city = jQuery('#residence_city').val();

                traineeRequest.endpoint =  'get-buildings';
                traineeRequest.method = 'get';
                traineeRequest.addGetParam('street_slug', match);
                traineeRequest.addGetParam('city', city);
                traineeRequest.addGetParam('l',  window.currentLang);
                traineeRequest.execute(function (response) {
                    callback(response.data);
                });
            },
            render: function(item, value) {
                var itemElement = document.createElement("div");
                itemElement.textContent = item.label;
                return itemElement;
            },
            emptyMsg: "",
            customize: function(input, inputRect, container, maxHeight) {
                if (maxHeight < 100) {
                    container.style.top = "";
                    container.style.bottom = (window.innerHeight - inputRect.bottom + input.offsetHeight) + "px";
                    container.style.maxHeight = "250px";
                }
            }
        })
    }

    $('body').on('click', '#changeStreet', function (e) {
        e.preventDefault();
        var lng = $('#residence_city').find(':selected').attr('data-lng');
        var lat = $('#residence_city').find(':selected').attr('data-lat');
        $('#have_certificate').val('');
        $('#address').prop('readonly', false);
        $('#address').val('');
        $('#have_certificate').attr('data-building-id', '');
        $('#building_id').val('');
        $('.for_not_certified input').val('');
        $('#certified_badge').removeClass(function (index, classNames) {
            var current_classes = classNames.split(" "), // change the list into an array
                classes_to_remove = []; // array of classes which are to be removed

            $.each(current_classes, function (index, class_name) {
                // if the classname begins with bg add it to the classes_to_remove array
                if (/mark_.*/.test(class_name)) {
                    classes_to_remove.push(class_name);
                }
            });
            // turn the array back into a string
            return classes_to_remove.join(" ");
        });

        var map = window.hereMap;

        map.setCenter({lat:lat, lng:lng});
        map.setZoom(11);
        $(this).parent().hide();
        $('.for_not_certified').show();
        $('.for_certified').hide();
    });

    $('body').on('click', '.trainee-select-address', function (e) {
        e.preventDefault();
        var lng = $(this).attr('data-lng');
        var lat = $(this).attr('data-lat');
        var title = $(this).attr('data-title');
        var buildingId = $(this).attr('data-building-id');
        var buildingCert = $(this).attr('data-certificate');
        var buildingCertRaw = $(this).attr('data-certificate-raw');

        $('#have_certificate').val('true');
        $('#address').prop('readonly', true);
        $('#address').val(title);
        $('#building_id').val(buildingId);
        $('#changeStreet').parent().show();
        $('#building_cert').show().html(buildingCert);
        $('#certified_badge').addClass('mark_'+buildingCertRaw);
        $('.for_not_certified input').val('false');

        var map = window.hereMap;

        map.setCenter({lat:lat, lng:lng});
        map.setZoom(18);

        if($(this).hasClass('bubble_select_street_mobile')) {
            $('html, body').animate({
                scrollTop: $("#trainee_user_address").offset().top
            }, 500)
        }

        $('.for_not_certified').hide();
        $('.for_certified').show();
    });

    $('body').on('click', '.trainee-system-map-next-step', function (e) {
        e.preventDefault();
        var currentStep = $(this).attr('data-current-step');
        var currentStepNum = $(this).attr('data-current-num');
        var nextStep = $(this).attr('data-next-step');
        var nextStepNum = $(this).attr('data-next-num');
        var hasCertificate = $('#have_certificate').val();
        var buildingId = $('#building_id').val();
        var questionnaireId = $('#trainee-q-form').attr('data-questionnaire-id')

        var emptyInputs = Array.from($('.q-step-1 input')).filter(function (input) {
            return $(input).val() === '' && $(input).attr('type') !== 'hidden';
        });
        var emptySelects = Array.from($('.q-step-1 select')).filter(function (select) {
            return $(select).val() === '';
        });

        if(emptyInputs.length > 0 && !emptySelects.length > 0) {
            return Swal.fire(window.traineeTranslations.errorTitle, window.traineeTranslations.requiredFields, 'error');
        }

        var yearOfConstructionPoints = trainee_return_range_points($('#yearOfConstruction').val(), window.traineeRanges.years);
        var sizeInSquarePoints = trainee_return_range_points($('#sizeInSquare').val(), window.traineeRanges.squares);
        var occupantsPoints = trainee_return_range_points($('#occupants').val(), window.traineeRanges.occupants);

        $('#yearOfConstructionPoints').val(yearOfConstructionPoints);
        $('#sizeInSquarePoints').val(sizeInSquarePoints);
        $('#occupantsPoints').val(occupantsPoints);

        if(hasCertificate && hasCertificate == 'true') {
            $('.loadingScreen').css('display', 'flex');
            traineeRequest.endpoint = '/save-profile-questionnaire-certified';
            traineeRequest.method = 'post';
            traineeRequest.addPostParam('is_certified', hasCertificate);
            traineeRequest.addPostParam('building_id', buildingId);
            traineeRequest.addPostParam('questionnaire_id', questionnaireId);
            traineeRequest.addPostParam('residence_type', $('#residence_type').val());
            traineeRequest.addPostParam('residence_city', $('#residence_city').val());
            traineeRequest.addPostParam('address', $('#address').val());
            traineeRequest.addPostParam('yearOfConstruction', $('#yearOfConstruction').val());
            traineeRequest.addPostParam('sizeInSquare', $('#sizeInSquare').val());
            traineeRequest.addPostParam('occupants', $('#occupants').val());
            traineeRequest.addPostParam('building_id', $('#building_id').val());
            traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };
            traineeRequest.execute(function (response) {
                window.location.href = window.energyProfilePage;
            });
            return;
        }

        $(currentStep).hide();
        $(nextStep).show();
        $('.q-ind-' + nextStepNum).addClass('active');

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#questionnaireSteps").offset().top - 200
        }, 800);

    });

    $('body').on('click', '.trainee-save-pdf', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        makePDF();
    });

    $('body').on('click', '.continue_with_q', function (e) {
        e.preventDefault();
        $('#have_certificate').val('false');
        $('.for_not_certified input').val('');
        $('.for_not_certified').show();
        $('.for_certified').hide();
    });

    $('body').on('change', '.q-option-check', function (e) {
        var idBase = $(this).attr('name');
        var textAreaID = '#' + idBase + '_possible_solution_q';
        var hasSolution = $(this).attr('data-possible-solution');
        var questionIndex = $(this).attr('data-question-index');
        var optionIndex = $(this).attr('data-option-index');
        var solutionObj = { hasSolution: hasSolution, optionIndex: optionIndex, questionIndex: questionIndex}
        $(textAreaID).val(JSON.stringify(solutionObj));
    });
});