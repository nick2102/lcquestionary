(function ($) {

    var auth = {
        register: function(inputs){
            traineeRequest.endpoint = '/register';
            traineeRequest.method = 'post';

            inputs.forEach(function (field) {
                traineeRequest.addPostParam(field.name, field.value);
            });

            traineeRequest.execute(function (response) {
                Swal.fire({
                    title: window.traineeTranslations.successTitle,
                    text: response.data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = window.homeUrl;
                });
            });
        },

        login: function (inputs) {
            traineeRequest.endpoint = '/login';
            traineeRequest.method = 'post';

            inputs.forEach(function (field) {
                traineeRequest.addPostParam(field.name, field.value);
            });

            traineeRequest.execute(function (response) {
                window.location.reload(true);
            })
        },

        passwordRecovery: function (inputs) {
            traineeRequest.endpoint = '/reset-password-request';
            traineeRequest.method = 'post';

            inputs.forEach(function (field) {
                traineeRequest.addPostParam(field.name, field.value);
            });

            traineeRequest.execute(function (response) {
                Swal.fire({
                    title: window.traineeTranslations.successTitle,
                    text: response.data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = window.homeUrl;
                });
            });
        },

        passwordReset: function (key, login, inputs) {
            traineeRequest.endpoint = '/reset-password';
            traineeRequest.method = 'post';

            traineeRequest.addPostParam('key', key);
            traineeRequest.addPostParam('login', login);

            inputs.forEach(function (field) {
                traineeRequest.addPostParam(field.name, field.value);
            });

            traineeRequest.execute(function (response) {
                Swal.fire({
                    title: window.traineeTranslations.successTitle,
                    text: response.data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                }).then(function(result) {
                    if (result.value) {
                        window.location.href = window.homeUrl;
                    }
                });
            });
        },

        changePassword: function (inputs) {
            traineeRequest.endpoint = '/change-password';
            traineeRequest.method = 'post';

            inputs.forEach(function (field) {
                traineeRequest.addPostParam(field.name, field.value);
            });

            traineeRequest.headers = { 'Content-Type': 'application/json', 'X-WP-Nonce' : window.restNonce };

            traineeRequest.execute(function (response) {
                Swal.fire({
                    title: window.traineeTranslations.successTitle,
                    text: response.data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    closeOnConfirm: false
                }).then(function(result) {
                    if (result.value) {
                        location.reload();
                    }
                });
            });
        }
    };

    $('body').on('click', '.trainee-system-login-btn', function(e) {
        e.preventDefault();

        var random = $(this).attr('data-random');
        var form =  $('.trainee-system-form#traineeLoginForm' + random );
        var isFormValid = form.valid();

        if(!isFormValid)
            return;

        $('.loadingScreen').css('display', 'flex');

        var formData = form.serializeArray();
        auth.login(formData);
    });

    $('body').on('click', '.trainee-system-password-recovery-btn', function (e) {
        e.preventDefault();

        var form =  $('.trainee-system-form#passwordRecoveryForm');
        var isFormValid = form.valid();

        if(!isFormValid)
            return;

        $('.loadingScreen').css('display', 'flex');

        var formData = form.serializeArray();

        auth.passwordRecovery(formData);
    })

    $('body').on('click', '.trainee-system-password-reset-btn', function (e) {
        e.preventDefault();

        var form =  $('.trainee-system-form#passwordResetForm');
        var isFormValid = form.valid();

        if(!isFormValid)
            return;

        $('.loadingScreen').css('display', 'flex');

        var key = getUrlParameter('key');
        var login = getUrlParameter('login');

        var formData = form.serializeArray();

        auth.passwordReset(key, login, formData);

    });

    $('body').on('click', '.trainee-system-register-btn', function (e) {
        e.preventDefault();
        var random = $(this).attr('data-random');
        var form =  $('.trainee-system-form#traineeRegisterForm' + random);
        var isFormValid = form.valid();

        if(!isFormValid)
            return;

        $('.loadingScreen').css('display', 'flex');

        var formData = form.serializeArray();

        auth.register(formData);
    });

    $('body').on('click', '.trainee-system-change-password-btn', function (e) {
        e.preventDefault();

        var form =  $('.trainee-system-form#changePasswordForm');
        var isFormValid = form.valid();

        if(!isFormValid)
            return;

        $('.loadingScreen').css('display', 'flex');

        var formData = form.serializeArray();

        auth.changePassword(formData);
    });

    $('body').on('click', '.system-trainee-password-recovery-btn', function (e) {
        e.preventDefault();
        $('.modal').modal('hide');
        setTimeout(function () {
            $('#trRecoveryModal').modal('toggle');
        }, 300);
    });
})(jQuery, window);