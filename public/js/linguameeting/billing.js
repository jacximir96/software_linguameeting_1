jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(document).on('change', '.change-paid-payment', function (event) {

        event.preventDefault()

        var url = jQuery(this).data('change-url')


        jQuery.ajax({
            url: url,
            type:"POST",
            data: {},
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){
                $.notify(response, {className: "success", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422) {
                    $.notify(response.responseText, {className: "error", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
                }
            },
            statusCode: {

                422: function (data){
                    $.notify('Value is required.', {className: "error", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
                }
            }
        });

    });

    jQuery(document).on('click', '#generate-invoices-ajax', function (event) {

        event.preventDefault()

        //var reloadInElement = jQuery(this).data('reload-element')
        //var reloadUrl = jQuery(this).data('reload-url')

        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type:"GET",
            data: [],
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){
                location.reload(true);
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

});
