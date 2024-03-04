<div id="gradebook" class="hidden-print modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-corporate-color text-white">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input download-gradebook-option" name="q" id="option1" value="for_canva">

                        <div class="form-check-label text-18" for="option1">
                            <span class="pe-2 text-20 text-corporate-color"><i class="fas fa-file-excel"></i></span>
                            Canvas Excel (.xlsx)

                        </div>
                        <div>
                            Excel for Canvas uploads
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="radio" class="form-check-input download-gradebook-option" name="q" id="option2" value="for_excel">
                        <div class="form-check-label text-18" for="option1">
                            <span class="pe-2 text-20 text-corporate-color"><i class="fas fa-file-excel"></i></span>
                            Excel (.xlsx) LinguaMeeting Report

                        </div>
                        <div>
                            Excel with LinguaMeeting format
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="radio" name="q" id="option3" class="form-check-input download-gradebook-option" value="for_csv">
                        <div class="form-check-label text-18" for="option1">
                            <span class="pe-2 text-20 text-corporate-color"><i class="fas fa-file-csv"></i></span>
                            Comma Separated Values (.csv)

                        </div>
                        <div>
                            Use for plain-text file type
                        </div>

                    </div>

                    <div class="form-check mt-4">
                        <input type="radio" name="q" id="option4" class="form-check-input download-gradebook-option" value="for_html">
                        <div class="form-check-label text-18" for="option1">
                            <span class="pe-2 text-20 text-corporate-color"><i class="fas fa-file-csv"></i></span>
                            HTML (.html)

                        </div>
                        <div>
                            For in browser and mobile view
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn background_colorAAAAAA colorWhite" data-dismiss="modal">Cancel</button>
                    <button type="button" id="button-download-gradebook" class="btn bg-corporate-color colorWhite" onclick="">Download</button>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        $('#button-download-gradebook').click(function() {
            // Obtiene el valor del radio button seleccionado
            var downloadFileType = $('.download-gradebook-option:checked').val();

            // Muestra el valor seleccionado en la consola
            var dateFrom = '';
            var dateTo = '';
            var daterangeValue = $('#daterange').val()

            if (daterangeValue != ''){

                var partes = daterangeValue.split(" - ");

                dateFrom = partes[0];
                var partesFecha = dateFrom.split("/");
                dateFrom = partesFecha[2] + "-" + partesFecha[0] + "-" + partesFecha[1]; // el formato viene en mm/dd/yyyy

                dateTo = partes[1];
                partesFecha = dateTo.split("/");
                dateTo = partesFecha[2] + "-" + partesFecha[0] + "-" + partesFecha[1];

            }

            var url = "{{route('post.instructor.course.gradebook.file.generate')}}";

            if (downloadFileType == 'for_html'){

                var courses = $('#courses-ids').val()

                console.log('from: '+dateFrom)
                console.log('to: '+dateTo)
                console.log('courses: '+courses)




                var urlHtmlVersion = "{{route('get.instructor.course.gradebook.show_table', $instructor->hashId())}}?date_from="+dateFrom+"&date_to="+dateTo+"&course_selected="+$('#courses-ids').val();

                console.log(urlHtmlVersion)

                window.open(urlHtmlVersion, '_blank');


                return;
            }

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    'instructor_id': "{{$instructor->hashId()}}",
                    'course_selected': $('#courses-ids').val(),
                    'date_from' : dateFrom,
                    'date_to' : dateTo,
                    'filetype' : downloadFileType,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {

                    if (downloadFileType == 'for_html'){

                        console.log(data)

                        myWindow = window.open("data:text/html," + encodeURIComponent(data),
                            "_blank", "width=200,height=100");
                        console.log(myWindow)
                        myWindow.focus();
                    }
                    else{

                        var downloadUrl = "{{route('get.instructor.course.gradebook.file.download')}}/"+data

                        var link = document.createElement('a');
                        link.href = downloadUrl;
                        //link.target = '_blank';
                        link.style.display = 'none';
                        document.body.appendChild(link);
                        link.click();

                        document.body.removeChild(link);
                    }
                },
                error: function (error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });

    });
</script>
