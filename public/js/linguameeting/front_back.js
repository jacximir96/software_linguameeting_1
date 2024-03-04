jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(document).on('click', '#generate_password', function (event) {

        event.preventDefault()

        jQuery.get('/password/generate', function (data) {

            jQuery('#password').val(data.password)
            jQuery('#password_confirmation').val(data.password)

        }, 'json');

    });
});
