<script>

    $(document).ready(function () {

        $("#dateSession").datepicker("destroy");

        $("#dateSession").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            numberOfMonths: 1,
            minDate: '{{$startDate->toDateString()}}',
            maxDate: '{{$endDate->toDateString()}}',
            firstDay: 1
        });



        var url = "{{$urlApiShowFormSearch}}"

        jQuery.ajax({
            url: url,
            type: "GET",
            data: [],
            context: this,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response, data) {

                $('#week-browser').hide();
                $('#week-browser').html(response);

                $('#week-browser').fadeIn('slow');
                $('#form-other-options').fadeIn('slow');

                $('#dateSession').prop("disabled", false);
                $('#timeId').prop("disabled", false);
                $('#coach').prop("disabled", false);

            },
            error: function (response, textStatus, xhr) {

                $.notify(response, {
                    className: "error",
                    position: "top-center",
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            },
        });


        jQuery(document).on('click', '.weekNavigator', function (event) {

            event.preventDefault()

            var url = $(this).attr('href')

            jQuery.ajax({
                url: url,
                type: "GET",
                data: [],
                context: this,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response, data) {

                    $('#week-browser').hide();
                    $('#week-browser').html(response);

                    $('#week-browser').fadeIn('slow');
                    $('#form-other-options').fadeIn('slow');

                },
                error: function (response, textStatus, xhr) {

                    $.notify(response, {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                },
            });
        });
    });

</script>
