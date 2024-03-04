jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});

    jQuery(".load-child-dropdown").change(function (event) {

        var childDropdownHtmlId = $(this).data('child-dropdown-id');

        if (jQuery(this).val() == '') {
            jQuery(childDropdownHtmlId).empty();
            return false;
        }

        var loadUrl = $(this).data('child-load-url')+'/';
        var childPlaceholder = $(this).data('child-placeholder');

        jQuery.get(loadUrl + jQuery(this).val(), function (data) {

            var model = initializeDropdown(childDropdownHtmlId, childPlaceholder)

            jQuery.each(data.items, function (index, element) {
                var option = jQuery('<option value="' + element.id + '">' + element.name + '</option>');
                model.append(option);
            });


        }, 'json');
    });

    jQuery(".load-child-dropdown-multiple").change(function (event) {

        var childDropdownHtmlId = $(this).data('child-dropdown-id');

        var loadUrl = $(this).data('child-load-url');
        var childPlaceholder = $(this).data('child-placeholder');
        var itemsSelectedIds = jQuery(this).val()

        if (jQuery(this).val() == '') {
            initializeDropdown(childDropdownHtmlId, childPlaceholder)
            return false;
        }

        jQuery.ajax({
            context: this,
            url: loadUrl,
            type: "POST",
            dataType: 'json',
            data: {'items_ids':  itemsSelectedIds,},
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            success:function(response, data){

                var model = initializeDropdown(childDropdownHtmlId, childPlaceholder)

                jQuery.each(response.items, function (index, element) {
                    var option = jQuery('<option value="' + element.id + '">' + element.name + '</option>');
                    model.append(option);
                });

                $('#course_id').selectpicker('refresh');

            },
            error: function(response, textStatus, xhr) {

                $.notify('There is an error loading options', {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
        });
    });

    $('#university_id').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

        var childDropdownHtmlId = $(this).data('child-dropdown-id');

        if (jQuery(this).val() == '') {
            jQuery(childDropdownHtmlId).empty();
            return false;
        }

        var loadUrl = $(this).data('child-load-url');
        var childPlaceholder = $(this).data('child-placeholder');
        var universitiesIds = jQuery(this).val()

        jQuery.ajax({
            context: this,
            url: loadUrl,
            type: "POST",
            dataType: 'json',
            data: {'universities_ids':  universitiesIds,},
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            success:function(response, data){

                var model = initializeDropdown(childDropdownHtmlId, childPlaceholder)

                jQuery.each(response.items, function (index, element) {
                    var option = jQuery('<option value="' + element.id + '">' + element.name + '</option>');
                    model.append(option);
                });

                $('#course_id').selectpicker('refresh');

            },
            error: function(response, textStatus, xhr) {

                $.notify('There is an error loading options', {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
        });
    });

    /**
     * Clear dropdown and put placeholder as initial option
     * @param htmlId
     * @param placeholder
     * @returns {*|jQuery|HTMLElement}
     */
    function initializeDropdown (htmlId, placeholder){

        var dropdownId = '#'+htmlId;

        var model = jQuery(dropdownId);
        model.empty();

        var option = jQuery('<option value="">'+placeholder+'</option>');
        model.append(option);

        return model;
    }


    jQuery(document).on('click', '.check-and-uncheck-all', function (event){

        var isChecked = jQuery(this).prop('checked')

        var targetClass = jQuery(this).attr('data-target-class');

        jQuery('.'+targetClass).each(function () {
            this.checked = isChecked;
        });
    });

    jQuery(document).on('click', '.check-and-uncheck-all-with-all', function (event){

        var isChecked = jQuery(this).prop('checked')

        var targetClass = jQuery(this).attr('data-target-class');

        jQuery('.'+targetClass).each(function () {
            this.checked = isChecked;
        });

        if (isChecked){
            jQuery('#block-all').removeClass('d-none').addClass('d-inline-block')
        }
        else{
            jQuery('#block-all').removeClass('d-inline-block').addClass('d-none')
            jQuery('#select-all').prop('checked', false)
        }
    });


    jQuery(document).on('click', '.check-all', function (event){

        event.preventDefault()

        var targetClass = jQuery(this).attr('data-target-class');

        jQuery('.'+targetClass).each(function () {
            this.checked = true;
        });
    });

    jQuery(document).on('click', '.uncheck-all', function (event){

        event.preventDefault()

        var targetClass = jQuery(this).attr('data-target-class');

        jQuery('.'+targetClass).each(function () {
            this.checked = false;
        });

    });

    jQuery(document).on('click', '.icon-calendar', function (event){
        $(this).prev('.input-datepicker').datepicker('show');
    });

    if (jQuery(".input-datepicker").length) {


        $('.input-datepicker').datepicker({
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            numberOfMonths: 1,
            firstDay: 1
        });

    }

    if (jQuery(".ckeditor").length) {

        $('.ckeditor').each(function() {
            var height = $(this).data('height') || '120px';

            CKEDITOR.replace('ckeditor', {
                language: 'es',
                height: height,
                scayt_autoStartup: true,
                scayt_sLang: 'es_ES',
                scayt_disableOptionsStorage : 'all',
                removePlugins: 'elementspath,save,font, flash',
                toolbarGroups: [
                    {name: 'document', groups: ['mode', 'document']},			// Displays document group with its two subgroups.
                    {name: 'clipboard', groups: ['clipboard', 'undo', 'spellchecker']},			// Group's name will be used to create voice label.
                    '/',																// Line break - next group will be placed in new line.
                    {name: 'basicstyles', groups: ['basicstyles', 'colors', 'cleanup']},
                    {name: 'links'}
                ]
            });
        });


    }

    if (jQuery(".ckeditor-basic").length) {

        $('.ckeditor-basic').each(function() {
            var height = $(this).data('height') || '120px';
            CKEDITOR.replace($(this).attr('id'), {
                language: 'es',
                height: height,
                removePlugins: 'elementspath,save,font,flash',
                autoParagraph: false,
                toolbarGroups: [
                    '/',
                    { name: 'basicstyles', groups: ['basicstyles', 'colors', 'cleanup'] },
                    { name: 'links' }
                ]
            });
        });
    }

    $('.select-2').select2({
        ajax: {
            url: function() {
                return $(this).data('search-url');
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            minimumInputLength: 3,
            data: function (params) {
                return {
                    _token: jQuery('meta[name="csrf-token"]').attr('content'),
                    search: params.term
                };
            },
        }
    });

    $('[data-toggle="popover"]').popover({
        html: true,
        content: function() {
            return decodeURIComponent($(this).data('content'));
        }
    });
});
