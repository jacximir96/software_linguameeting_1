jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    function showNotify (message, className){

        $.notify(message, {
            className: className,
            position: "top-center",
            showDuration: 400,
            hideDuration: 400,
            autoHideDelay: 2000,
        });
    }

    jQuery(document).on('change', '.select-update-status-session', function (event) {

        event.preventDefault()

        var sessionStatusId = jQuery(this).val()

        var url = jQuery(this).data('url-change-status')

        jQuery.ajax({
            url: url,
            type: "POST",
            data: {
                'session_status_id': sessionStatusId
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response, data) {
                showNotify(response, 'success')
            },
            error: function (response, textStatus, xhr) {
                showNotify(response, 'error')
            },
        });
    });

    jQuery(document).on('change', '.select-update-student-feedback', function (event) {

        event.preventDefault()

        var studentReviewId = jQuery(this).val()
        var feedbackType = jQuery(this).data('session-feedback-type')
        var url = jQuery(this).data('url-change')

        jQuery.ajax({
            url: url,
            type: "POST",
            data: {
                'student_review_id': studentReviewId,
                'student_review_type': feedbackType
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response, data) {
                showNotify(response, 'success')
            },
            error: function (response, textStatus, xhr) {
                showNotify(response, 'error')
            },
        });
    });
});
