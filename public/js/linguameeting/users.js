jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(document).on('click', '.send-mail-selected-users', function (event) {

        event.preventDefault()

        var userIds = []

        jQuery('.item-to-select').each(function () {

            if (jQuery(this).prop('checked')) {
                userIds.push(jQuery(this).val())
            }
        });

        if ( ! userIds.length){
            alert('You must select at least one item')

            return false;
        }

        var selectAll = jQuery('#select-all').prop('checked')

        var url = jQuery(this).attr('href')

        if (selectAll){
            var queryString = jQuery('#search-form').serialize()
            url = url + '?' + queryString
        }
        else{
            url = url +'?users_ids='+userIds.join('-')
        }

        jQuery(".modal-title").html('Send mail');
        jQuery('#modal-url').attr('href', url)
        jQuery("#modal-lingua").modal("show");
    });

    jQuery(document).on('click', '.show-hide-password', function (event) {

        event.preventDefault();

        showOrHidePasswordContent(jQuery(this), 'password')
        showOrHidePasswordContent(jQuery(this), 'password_confirmation')
    });

    jQuery(document).on('change', '.change-status-user', function (event) {

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

});
