<script>

    function hasCustomHeight() {

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

    function resizeIframe() {
        console.log('resize')
        var screenHeight = window.innerHeight || document.documentElement.clientHeight;
        var nuevoAltura = screenHeight * 0.7; // Establecer el 90% del alto de la pantalla

        document.getElementById("modal_iframe").style.height = nuevoAltura + "px";
    }
</script>
<div class="modal fade " id="modal-lingua" tabindex="-1" data-reload="" data-reload-type="">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable modal-autoheighta">
        <div class="modal-content">

            <div class="modal-header  bg-text-corporate-color text-white">
                <h5 class="modal-title colorBase1 font-weight-bold"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times cursor_pointer text-muted font-weight-normal"></i>
                </button>
            </div>

            <div class="modal-body">
                <iframe id="modal_iframe" src="" frameborder="0" scrolling="auto" width="100%" height="400" onload="resizeIframe()"></iframe>
            </div>

            <input type="hidden" id="modal-reload-element" value="">
            <input type="hidden" id="modal-reload-url" value="">
            <input type="hidden" id="modal-url" value="">
        </div>
    </div>
</div>
