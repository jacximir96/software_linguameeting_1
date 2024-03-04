jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(document).on('click', '.join-experience', function (event) {

        event.preventDefault()

        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type:"GET",
            data: [],
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

                //window.location.href = response.url_join;
                return;
            },
            error: function(response, textStatus, xhr) {

                $.notify(response, {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
        });
    });

    jQuery(document).on('click', '.set-intro-session', function (event) {

        event.preventDefault()

        var url = $(this).data('url-intro')

        jQuery.ajax({
            url: url,
            type:"GET",
            data: [],
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

                window.location.href = jQuery(this).attr('href')

            },
            error: function(response, textStatus, xhr) {

                $.notify('Sorry, there is an error updated intro sessino info.', {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });

                window.location.href = jQuery(this).attr('href')
            },
        });
    });
});
