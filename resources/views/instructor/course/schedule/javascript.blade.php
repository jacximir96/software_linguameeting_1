<script>
    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        jQuery(document).on('click', '.select-session-coach', function (e) {

            e.preventDefault()

            var dataCoachId = jQuery(this).data('coach-id');
            jQuery('.session-coach').css('opacity', '1')

            var enlaces = document.querySelectorAll('.session-coach');
            enlaces.forEach(function(enlace) {
                if (enlace.getAttribute('data-coach-id') != dataCoachId) {
                    enlace.style.opacity = '0.2'; // Cambia la transparencia del enlace deseado
                }
                else{
                    enlace.style.opacity = '1'; // Cambia la transparencia del enlace deseado
                }
            });
        });

        jQuery(document).on('click', '#show-all-sessions-link', function (e) {
            e.preventDefault()
            jQuery('.session-coach').css('opacity', '1')
        });

    });

</script>
