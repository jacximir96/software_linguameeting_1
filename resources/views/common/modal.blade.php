<script>
    function hasCustomHeight(){

        var divElement = document.getElementById("modal_iframe");

        if (divElement.hasAttribute("class")) {

            var regex = /\bh-(\d+)\b/;
            var classesArray = divElement.className.split(/\s+/);

            var foundClass = classesArray.find(function (className) {
                return regex.test(className);
            });

            if (foundClass) {
                return true
            }

            return false
        }
    }

    function resizeIframe(){

        if (hasCustomHeight()){
            //si tiene configurada una clase específica de altura...confiamos en el valor de esa clase
            return false
        }

        //si no tiene clase específica de altura, la altura del iframe será la altura de su contenido.
        var iframeHeight =  $("#modal_iframe").contents().height();

        $("#modal_iframe").animate({
            height: iframeHeight
        }, 150);
    }
</script>
<div class="modal fade " id="modal-lingua" tabindex="-1" data-reload="" data-reload-type="">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable modal-autoheighta">
        <div class="modal-content">

            <div class="modal-header  bg-text-corporate-color text-white">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <iframe id="modal_iframe" src="" frameborder="0"  scrolling="auto" width="100%" onload="resizeIframe()"></iframe>
            </div>

            <input type="hidden" id="modal-reload-element" value="">
            <input type="hidden" id="modal-reload-url" value="">
            <input type="hidden" id="modal-url" value="">
        </div>
    </div>
</div>


<?php /*
<div class="modal fade" id="modal-iframe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title text-600" id="modal-iframe-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src=""
                        frameborder="0"
                        width="100%"
                        height="100%"></iframe>
            </div>
        </div>
    </div>
</div>


<div class="modal fade " id="modal-iframe-reload-div" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title text-600" id="modal-iframe-reload-div-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src=""
                        frameborder="0"
                        width="100%"
                        height="100%"></iframe>
            </div>
            <input type="hidden" id="modal-reload-div" value="">
            <input type="hidden" id="modal-reload-url" value="">
        </div>
    </div>
</div>


<div class="modal fade " id="modal-no-reload-iframe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-600" id="modal-no-reload-iframe-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src=""
                        frameborder="0"
                        width="100%"
                        height="100%"></iframe>
            </div>
        </div>
    </div>
</div>
*/ ?>
