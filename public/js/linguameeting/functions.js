

    function hasFilesValidSize (attributeClassFile, attributeFeedback, maxFileSize){

        jQuery(attributeFeedback).html('')

        var totalSize = 0;
        $(attributeClassFile).each(function() {
            var fileSize = 0;
            if (this.files.length > 0) {
                for (var i = 0; i < this.files.length; i++) {
                    fileSize += this.files[i].size;
                }
            }
            totalSize += fileSize;
        });
        var totalSizeKB = totalSize / 1024;

        if (totalSizeKB <= maxFileSize){
            return true;
        }

        return false;
    }

    /**
     * Form functions to show feedback in 422 error validation -  start
     **/

    function obtainFormFiels (formId){

        var formArray = $(formId).serializeArray();
        var fieldNames = [];
        formArray.forEach(function(input) {
            fieldNames.push(input.name);
        });

        return fieldNames
    }

    function show422Feedback (fieldId, messages){

        var feedbackErrorId =  "#feedback-error-"+fieldId
        var inputClass = ".form-input-"+fieldId

        if ( jQuery( feedbackErrorId ).length ) {

            jQuery(feedbackErrorId).removeClass('d-none').addClass('d-block')
            jQuery(inputClass).addClass('is-invalid')

            var messagesToPrint = '';
            messages.forEach (function (message){
                messagesToPrint = messagesToPrint + message + '<br>'
            })

            jQuery(feedbackErrorId +' strong').html(messagesToPrint)
        }
    }

    function clearFormFeedback (formId){

        fieldsNames = obtainFormFiels(formId)

        fieldsNames.forEach(function(fieldName) {

            clearFieldFeedback(fieldName)

        });
    }

    function clearFieldFeedback(fieldName){

        var feedbackErrorId =  "#feedback-error-"+fieldName
        var inputClass = ".form-input-"+fieldName

        if ( jQuery( feedbackErrorId ).length ) {
            jQuery(feedbackErrorId).removeClass('d-block').addClass('d-none')
            jQuery(feedbackErrorId +' strong').html('')
        }

        if ( jQuery( inputClass ).length ) {
            jQuery(inputClass).removeClass('is-invalid')
        }
    }

    function obtainFormDataInArray (formId){

        var $inputs = jQuery(formId + ' :input')

        var data = {};
        $inputs.each(function() {

            if ($(this).is(':checkbox') && !$(this).is(':checked')) {
                // Si es un checkbox y no está marcado, no lo agregamos al FormData
                data[this.name] = 0;
            }
            else{
                data[this.name] = $(this).val();
            }
        });

        return data
    }

    function showOrHidePasswordContent (element, passwordFieldId){

        var fieldPassword = jQuery('#'+passwordFieldId);

        if (fieldPassword.attr('type') == "password") {

            fieldPassword.removeAttr("type");
            fieldPassword.attr("type","text");

            element.html('Hide')

        } else {

            fieldPassword.removeAttr("type");
            fieldPassword.attr('type','password');

            element.html('Show')
        }
    }
