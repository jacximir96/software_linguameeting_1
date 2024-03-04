jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});


    jQuery(document).on('change', '.change-coordinator', function (event) {

        event.preventDefault()

        var url = jQuery(this).data('change-url')
        var value = jQuery(this).val()

        jQuery.ajax({
            url: url,
            type:"POST",
            data: {
                'coordinator_id' : value
            },
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

    jQuery(document).on('change', '.change-semester-finished', function (event) {

        event.preventDefault()

        var isChecked = jQuery(this).prop('checked')
        var semesterNumber = jQuery(this).data('semester-number')

        var url = jQuery(this).data('change-url')

        jQuery.ajax({
            url: url,
            type:"POST",
            data: {
                'semester_number' : semesterNumber,
                'is_checked' : isChecked
            },
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

    jQuery(document).on('change', '.select-update-ranking', function (event) {

        event.preventDefault()

        var url = jQuery(this).data('update-url')
        var value = jQuery(this).val()

        jQuery.ajax({
            url: url,
            type:"POST",
            data: {
                'value' : value
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){
                $.notify(response.message, {className: "success", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422) {
                    $.notify(response.message, {className: "error", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
                }
            },
            statusCode: {

                422: function (data){
                    $.notify('Value is required.', {className: "error", position: "top-center", showDuration: 400, hideDuration: 400, autoHideDelay: 2000,});
                }
            }
        });

    });
});
