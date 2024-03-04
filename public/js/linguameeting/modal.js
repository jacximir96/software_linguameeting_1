jQuery(document).ready(function () {

    $('#manual-ajax').click(function(event) {
        event.preventDefault();
        this.blur(); // Manually remove focus from clicked link.

        $.get(this.href, function(html) {
            $(html).appendTo('body').modal();
        });
    });

    jQuery.ajaxSetup({cache: false});

    function resetModalConfig (){

        jQuery("#modal-lingua").attr('data-reload', '');
        jQuery("#modal-lingua").attr('data-reload-type', '');
        jQuery("#modal-lingua").attr('data-reload-element', '');
        jQuery("#modal-lingua").attr('data-reload-url', '');
        jQuery("#modal-lingua .modal-dialog").removeClass("modal-dialog-centered");
    }



    jQuery(document).on('click', '.open-modal', function (event) {

        event.preventDefault();

        resetModalConfig()

        //check reload info
        var configReload = jQuery(this).data('modal-reload')

        if (configReload == 'yes'){

            var reloadType = jQuery(this).data('reload-type')

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
        var url = $(this).attr("href");
        var title = $(this).attr("data-modal-title");

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
    });

    jQuery(document).on('shown.bs.modal', '#modal-lingua', function () {
        var url = $('#modal-url').attr("href");
        jQuery("#modal-lingua iframe").attr("src", url);
    });

    jQuery(document).on('hidden.bs.modal', '#modal-lingua', function () {

        jQuery("#modal-lingua iframe").contents().find("body").html('');

        var isReload = jQuery('#modal-lingua').data('reload')

        if (isReload == 'yes'){

            var reloadType = jQuery(this).data('reload-type')

            if (reloadType == 'parent'){
                window.location.reload();
            }
            else if (reloadType == 'parentWithUrl'){
                var url = jQuery('#modal-lingua').data('reload-url')
                window.location.href = url
                return true;
            }
            else if (reloadType == 'element'){

                var targetElement = jQuery('#modal-lingua').data('reload-element')
                var url = jQuery('#modal-lingua').data('reload-url')

                jQuery(targetElement).load(url);
            }
        }
    });

    window.closeModal = function(modalId){
        $(modalId).modal('hide');
    };

    jQuery(document).on('click', '.close-modal', function (event) {
        //button in iframe

        if ($(this).attr('data-modal-id-to-close') !== undefined) {
            var modalId = $(this).attr('data-modal-id-to-close')
            console.log(modalId)
            window.parent.closeModal('#'+modalId);
        }
        else{
            window.parent.closeModal('#modal-lingua');
        }
    });
});

