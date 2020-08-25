(function ($) {
    $('body').on('click', '.btn-load-more-companies', function (e) {
        e.preventDefault();
        $('.loadingScreen').css('display', 'flex');
        var self = $(this);
        var offset = self.attr('data-offset');
        traineeRequest.endpoint = '/get-more-companies';
        traineeRequest.method = 'get';
        traineeRequest.addGetParam('offset', offset);
        traineeRequest.execute(function (response) {
            if(response.data.html === "") {
                $('.btn-load-more-companies').hide();
            } else {
                var newOffset = parseInt(offset) + 20;
                self.attr('data-offset', newOffset);
                $('#trainee-companies').append(response.data.html);
            }
        });
    });
})(jQuery, window);