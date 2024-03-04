jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(document).on('change', '.upload-assignment', function (event) {

        jQuery('.feedback-file-session').html('')

        var totalSize = 0;
        $('.upload-assignment').each(function() {
            var fileSize = 0;
            if (this.files.length > 0) {
                for (var i = 0; i < this.files.length; i++) {
                    fileSize += this.files[i].size;
                }
            }
            totalSize += fileSize;
        });
        var totalSizeKB = totalSize / 1024;

        var sessionID = jQuery(this).data('session-id')

        jQuery.get('/file/check-upload-size/' + totalSizeKB, function (data) {
            if (data.response.max_exceeded == true){
                jQuery('.feedback-file-session-'+sessionID).html('With this file the max upload size ('+data.response.max_size_in_mb+' MB) is exceeded.')
            }
        }, 'json');
    });


    jQuery(document).on('click', '.delete-teaching-assistant-from-section', function (event) {

        if (confirm('Are you sure to remove this teaching assistant?') == false){

            return false;
        }

        event.preventDefault()

        var reloadInElement = jQuery(this).data('reload-element')
        var reloadUrl = jQuery(this).data('reload-url')

        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type:"POST",
            data: [],
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

                jQuery(reloadInElement).load(reloadUrl);

                $.notify(response.message, {
                    className: "success",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
            error: function(response, textStatus, xhr) {

                $.notify(response.message, {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
        });

    });

    jQuery(document).on('click', '.btn-save-section', function (event) {

        event.preventDefault()

        var reloadElement = jQuery(this).data('reload-element')
        var url = jQuery(this).data('reload-url')

        var formId =' #'+jQuery(this).data('form-id')

        clearFormFeedback(formId)

        data = obtainFormDataInArray(formId)

        jQuery.ajax({
            url: jQuery(formId).attr('action'),
            type:"POST",
            data: data,
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){

                jQuery(reloadElement).load(url);

                $.notify("Section update successfully", {
                    className: "success",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422){

                    $.notify("An error occurred while updating the section.", {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            },
            statusCode: {

                422: function (data){
                    jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                        show422Feedback(fieldName, messages)
                    })
                }
            }
        });
    });

    jQuery(document).on('click', '#btn_to_course_assignment', function (event) {

        event.preventDefault()

        jQuery('#section_information').submit();
    });

    jQuery(document).on('click', '.guide-type', function (event) {

        var elementSelected = jQuery(this).val()

        if (elementSelected == 'guide'){
            jQuery('.div-select-guide').removeClass('d-none').addClass('d-block')
            jQuery('.div-upload-assignment').removeClass('d-block').addClass('d-none')
            jQuery('.div-assignment-for-all').removeClass('d-block').addClass('d-none')
        }
        else{
            jQuery('.div-upload-assignment').removeClass('d-none').addClass('d-block')
            jQuery('.div-assignment-for-all').removeClass('d-none').addClass('d-block')
            jQuery('.div-select-guide').removeClass('d-block').addClass('d-none')
        }
    });

    jQuery(document).on('click', '.give-all-students-access', function (event) {

        var isChecked = jQuery(this).prop('checked')

        var targetClass = jQuery(this).attr('data-target-class');

        jQuery('.'+targetClass).each(function () {
            this.checked = isChecked;
        });
    });

    jQuery(document).on('click', '.remove-session-file', function (event) {

        if (confirm('Are you sure to remove this assignment file?') == false){

            return false;
        }

        event.preventDefault()

        var reloadInElement = jQuery(this).data('reload-element')
        var reloadUrl = jQuery(this).data('reload-url')

        var sessionFileId = jQuery(this).data('file-id')
        var coachingWeekId = jQuery(this).data('coaching-week-id')

        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type:"POST",
            data: {
                'session_file_id':sessionFileId
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

                jQuery(reloadInElement).load(reloadUrl);

                jQuery.notify(response, {
                    className: "success",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422){

                    jQuery.notify("An error occurred while deleting the file.", {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            },
            statusCode: {

                422: function (data){
                    jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                        fieldName = 'feedback-file-session-'+coachingWeekId
                        show422Feedback(fieldName, messages)
                    })
                }
            }
        });
    });

    jQuery(document).on('change', '.file-assignment', function (event) {

        var maxSizeFile = jQuery('#max-size-file-in-kb').val()
        var isValid = hasFilesValidSize('.file-assignment', '.feedback-file-session', maxSizeFile );


        if (isValid == false){
            jQuery('.feedback-file-session').html('File size is exceeded. Max size allow is '+maxSizeFile/1024+' MB. is exceeded.')

            return
        }

    });

    jQuery(document).on('click', '.btn-save-course-assignment-section', function (event) {

        event.preventDefault()

        //set reload info
        var reloadElement = jQuery(this).data('reload-element')
        var url = jQuery(this).data('reload-url')

        var formId =' #'+jQuery(this).data('form-id')
        clearFormFeedback(formId)

        var maxSizeFile = jQuery('#max-size-file-in-kb').val()
        var isValid = hasFilesValidSize('.upload-all-assignment', '.feedback-file-session', maxSizeFile );

        if (isValid){
            isValid = hasFilesValidSize('.upload-assignment', '.feedback-file-session', maxSizeFile );
        }

        if (isValid == false){

            $.notify("File size is exceeded. Max size allow is "+maxSizeFile/1024+" MB.", {
                className: "error",
                position: "top-center",
                showDuration: 400,
                hideDuration: 400,
                autoHideDelay: 2000,
            });

            return
        }

        //empty formData
        var formData = new FormData(); // Currently empty

        //
        var target = jQuery(this).data('target')
        formData.append('target', target)

        //filled with form fields
        var $inputs = jQuery(formId + ' :input')
        var data = {};
        $inputs.each(function() {
            if ($(this).is(':checkbox') && !$(this).is(':checked')) {
                // Si es un checkbox y no está marcado, no lo agregamos al FormData
                return;
            }
            else if ($(this).is(':radio') && $(this).attr('name') == 'guide_type' && !$(this).is(':checked')) {
                // Si es un radio button y no está seleccionado, no lo agregamos al FormData
                return;
            }
            formData.append(this.name, $(this).val());
        });


        //add files to formData
        var fileInputs = document.querySelectorAll('.upload-assignment');
        for (var i = 0; i < fileInputs.length; i++) {
            var fileInput = fileInputs[i];
            var files = fileInput.files;
            for (var j = 0; j < files.length; j++) {
                formData.append(fileInput.name, files[j]);
            }
        }

        jQuery.ajax({
            url: jQuery(formId).attr('action'),
            type:"POST",
            data: formData,
            processData: false,
            contentType: false,
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){

                //jQuery(reloadElement).html('')
                jQuery(reloadElement).load(url);

                $.notify("Section update successfully", {
                    className: "success",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422){

                    $.notify("An error occurred while updating the section. Check field form.", {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            },
            statusCode: {

                422: function (data){
                    jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                        show422Feedback(fieldName, messages)
                    })
                }
            }
        });
    });


    jQuery(document).on('click', '.accordion-header', function (event) {

        var elementTextStatus = jQuery(this).find('.status-section')

        if (elementTextStatus.hasClass('text-danger'))
            elementTextStatus.removeClass('text-danger')
        else
            elementTextStatus.addClass('text-danger')

    });


    jQuery(document).on('change', '.save-course-coordinator', function (event) {

        var coordinatorId = jQuery(this).val()

        if (coordinatorId == ''){
            var url = jQuery(this).data('url-remove')
            var requestType = 'GET';
        }
        else{
            var url = jQuery(this).data('url-assign')
            var requestType = 'POST';
        }

        jQuery.ajax({
            url: url,
            type: requestType,
            data: {
                'coordinator_id':coordinatorId
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

                console.log('success');

                jQuery.notify(response, {
                    className: "success",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
            error: function(response, textStatus, xhr) {


                if (response.status != 422){

                    jQuery.notify("An error occurred update course coordinator.", {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            },
            statusCode: {

                422: function (data){
                    jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                        fieldName = 'feedback-file-session-'+coachingWeekId
                        show422Feedback(fieldName, messages)
                    })
                }
            }
        });
    });



    jQuery(document).on('change', '.week-one-on-one-chapter-id', function (event) {

        var chapterId = jQuery(this).val()
        var updateUrl = jQuery(this).data('url-update')

        updateGuide(updateUrl, chapterId)
    });

    jQuery(document).on('change', '.week-small-group-chapter-id', function (event) {

        var chapterId = jQuery(this).val()
        var updateUrl = jQuery(this).data('url-update')

        updateGuide(updateUrl, chapterId)
    });

    jQuery(document).on('change', '.flex-one-on-one-chapter-id', function (event) {

        var chapterId = jQuery(this).val()
        var updateUrl = jQuery(this).data('url-update')

        updateGuide(updateUrl, chapterId)
    });

    jQuery(document).on('change', '.flex-small-group-chapter-id', function (event) {

        var chapterId = jQuery(this).val()
        var updateUrl = jQuery(this).data('url-update')

        updateGuide(updateUrl, chapterId)
    });

    function updateGuide (updateUrl, chapterId){

        jQuery.ajax({
            url: updateUrl,
            type: "POST",
            data: {
                'chapter_id':chapterId
            },
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, data){

            },
            error: function(response, textStatus, xhr) {

                if (response.status != 422){

                    jQuery.notify("An error occurred update guide.", {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            },
            statusCode: {

                422: function (data){
                    jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                        fieldName = 'todo-replace-by-field-name'
                        show422Feedback(fieldName, messages)
                    })
                }
            }
        });
    }

    jQuery(document).on('click', '#button-clean-assignment', function (event) {
        jQuery('#name').val('');
        jQuery('#activity-description').val('');
        jQuery('#coach-note').val('');
    });


    if (jQuery(".long-text").length) {

        $('.long-text').each(function() {
            const slicePoint = $(this).data('expander-slice');
            const defaultSlicePoint = 150;

            $(this).expander({
                slicePoint: slicePoint !== undefined ? slicePoint : defaultSlicePoint,
                expandText: 'See more',
                moreLinkClass: 'more-link',
                userCollapseText: 'See less',
                userCollapsePrefix: '',
                lessLinkClass: 'less-link',
            });
        });
    }
});

