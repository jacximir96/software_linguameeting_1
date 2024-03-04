jQuery(document).ready(function () {


    if ($('.chartRegisteredStudents').length > 0) {
        registeredStudentsChart();
        gradeBookChart();
    }


    var options = {
        max_value: 5,
        step_size: 0.1,
        initial_value: 4.8,
        readonly: true
    };
    $(".mean_stars").rate(options);

    $('.actionsChange').change(function () {

        if(this.value == "modalDuplicateCourse") {
            $("#modalDuplicateCourse").modal('show');
        }
        else if (this.value == "modalCloseCourse") {
            var idSectionValue = $("option[value='modalCloseCourse']:selected").data("idsection");
            $("#idSection").val(idSectionValue);

            $("#modalCloseCourse").modal('show');
        } else {
            var href = jQuery(this).val();

            if (href != '' && href != null) {
    
                if ($('.actionsChange option:selected').hasClass("validation-modal")) {
    
                    var configReload = $('.actionsChange option:selected').data('modal-reload');
    
                    if (configReload == 'yes') {
                        var reloadType = $('.actionsChange option:selected').data('reload-type');
    
                        jQuery("#modal-lingua").attr('data-reload', 'yes');
                        jQuery("#modal-lingua").attr('data-reload-type', reloadType);
    
                        if (reloadType == 'element'){
                            jQuery("#modal-lingua").attr('data-reload-element', jQuery(this).data('reload-element'));
                            jQuery("#modal-lingua").attr('data-reload-url', jQuery(this).data('reload-url'));
                        }
                        else if (reloadType == 'parentWithUrl'){
                            jQuery("#modal-lingua").attr('data-reload-url', jQuery(this).data('reload-url'));
                        }
                    }
    
                    //set target url and title
                    var url = jQuery(this).val();
                    var title = $('.actionsChange option:selected').data('modal-title');
    
                    jQuery('#modal-url').attr('href', url)
    
                    $(".modal-title").html(title);
    
                    //set other attributes
                    var isModalCentered = jQuery(this).data('modal-centered')
                    if (isModalCentered == 'yes'){
                        $("#modal-lingua .modal-dialog").addClass("modal-dialog-centered");
                    }
    
                    var modalSize = jQuery(this).data('modal-size')
                    $("#modal-lingua .modal-dialog").addClass(modalSize);
    
                    var modalFullscreen = jQuery(this).data('modal-fullscreen')
                    $("#modal-lingua .modal-dialog").addClass(modalFullscreen);
    
                    var modalHeight = jQuery(this).data('modal-height')
                    $(".modal-content").addClass(modalHeight);
                    $("#modal_iframe").addClass(modalHeight);
    
                    //open modal
                    $("#modal-lingua").modal("show");
                } else {
                    window.location.href = href;
                }
            }
        }
    });

});

registeredStudentsChart = function () {

    if ($('#registeredStudents').length > 0) {

        //var data = jQuery.parseJSON(result);
        var ctx2 = $('#registeredStudents');
        var myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Registered", "Expected"],
                datasets: [{
                    label: 'Expected 28',
                    data: [100, 28],
                    backgroundColor: [
                        'rgba(24, 110, 116, 1)',
                        'rgba(209, 217, 218, 1)'
                    ],
                    borderColor: [
                        'rgba(24, 110, 116, 1)',
                        'rgba(209, 217, 218, 1)'

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                rotation: 1 * Math.PI,
                circumference: 1 * Math.PI

            }
        });
    }



};


changeBtnNotification = function(type, on_off){

    var svg = '';

    if(on_off==='on'){
        svg = '<svg id="'+type+'" class="cursor_pointer" onclick="changeBtnNotification('
                        +"'"+ type +"','off')"
                        +'" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>';


    }else if(on_off==='off'){

        svg = '<svg id="'+type+'" class="cursor_pointer" onclick="changeBtnNotification('
                        +"'"+ type +"','on')"
                        +'" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>';

    }

    $('#div-' + type).empty();
    $('#div-' + type).append(svg);

};


function CopyToClipboard(containerid) {

    var textToCopy = $('#' + containerid).val();
    var tempTextarea = $('<textarea>');
    $('body').append(tempTextarea);
    tempTextarea.val(textToCopy).select();
    document.execCommand('copy');
    tempTextarea.remove();
}
