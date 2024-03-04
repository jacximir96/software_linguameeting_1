@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
       'class' => '',
       'url'=> $form->action(),
       'autocomplete' => 'off',
       'id' =>'form-assign-availability'
   ]) }}

    <div class="form-group row mt-4">
        <div class="col-6" id="times">
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-between">
                    <span class="bg-corporate-color-lighter text-corporate-dark-color fw-bold px-2 ">
                        <i class="fa fa-clock"></i> Time Slots
                    </span>
                    @if ( ! $form->isEdit())
                        <a href="#" id="add-slot" class="text-success">
                            <i class="fa fa-plus"></i> Add New Time Slot
                        </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="apply_hours_off" value="0" />
                    {{Form::checkbox('apply_hours_off', 1, null)}} Apply to <span class="text-corporate-danger fst-italic">hours off</span>
                </div>
            </div>
            <div class="row row-slots border rounded py-3 mb-3 mt-2">
                <div class="col-5">
                    <label>Start Time</label>
                    {{Form::select('start_time[]', $form->optionsField('startTimeSlots'), null,
                    [   'class'=>'form-control form-select select-start-time ',
                        'placeholder' => 'Select Time',
                     ])}}

                    @error('start_time')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-5">
                    <label>End Time</label>
                    {{Form::select('end_time[]', $form->optionsField('endTimeSlots'), null,
                    [   'class'=>'form-control form-select select-end-time ',
                        'placeholder' => 'End time',
                     ])}}

                    @error('end_time')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if ( ! $form->isEdit())
                    <div class="col-2 text-end">
                        <a href="#" class="remove-slot"><i class="fa fa-times text-danger"></i></a>
                    </div>
                @endif


            </div>
        </div>

        <div class="col-6 {{ $errors->has('apply_dates') ? ' div-invalid ' : ''}}">

            <div class="row">
                <div class="col-12 ">
                    <span class="bg-corporate-color-lighter text-corporate-dark-color fw-bold px-2 ">
                        <i class="fa fa-calendar"></i> Apply Dates
                    </span>

                </div>
            </div>
            <div class="row mt-3 ">
                <div class="col-12 ">
                    {{Form::radio('apply_dates', 'apply_only_day', null, )}} <span class="ms-2">Only Apply to {{toMonthAndCardinalDay($date)}}</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    {{Form::radio('apply_dates', 'apply_week_date')}} <span class="ms-2">Apply To All Selected Days Between Dates</span>
                </div>
                <div class="col-11 offset-1">
                    <div class="row">

                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Mon</label>
                            {{Form::checkbox('day_week[]', 1, null, ['class' => 'form-check-input day-week'])}}
                        </div>

                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Tue</label>
                            {{Form::checkbox('day_week[]', 2, null, ['class' => 'form-check-input day-week'])}}
                        </div>

                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Wed</label>
                            {{Form::checkbox('day_week[]', 3, null, ['class' => 'form-check-input day-week'])}}
                        </div>

                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Thu</label>
                            {{Form::checkbox('day_week[]', 4, null, ['class' => 'form-check-input day-week'])}}
                        </div>

                        <div class="col-2">
                            <label class=" mb-1 d-block" for="flexCheckDefault">Fri</label>
                            {{Form::checkbox('day_week[]', 5, null, ['class' => 'form-check-input day-week'])}}
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Sat</label>
                            {{Form::checkbox('day_week[]', 6, null, ['class' => 'form-check-input day-week'])}}
                        </div>
                        <div class="col-2">
                            <label class=" mb-1 d-block " for="flexCheckDefault">Sun</label>
                            {{Form::checkbox('day_week[]', 0, null, ['class' => 'form-check-input day-week'])}}
                        </div>
                    </div>
                    @error('day_week')
                    <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    {{Form::radio('apply_dates', 'apply_period')}} <span class="ms-2">Apply All Days Between Dates</span>
                </div>
            </div>
            @error('apply_dates')
                <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="row mt-3">
                <div class="col-6">
                    <span class="d-block">From Date</span>
                    {{Form::date('start_date', null, ['class' => 'form-control field-date'])}}

                    @error('start_date')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <span class="d-block">To Date</span>
                    {{Form::date('end_date', null, ['class' => 'form-control field-date'])}}

                    @error('end_date')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 {{$form->isEdit() ? 'd-flex justify-content-between' : 'text-end'}}">
            @if ($form->isEdit())
            <button class="btn bg-corporate-danger text-white btn-sm btn-bold px-4"
                    data-warning-message = 'Are you sure you want to delete this slot ?'
                    id="deleteButton"
                    type="submit"
                    name="action"
                    value="delete">
                Delete
            </button>
            @endif
            <button class="btn btn-primary btn-sm btn-bold px-4"
                    id="updateButton"
                    type="submit"
                    name="action"
                    value="update">
                Save
            </button>
        </div>
    </div>
    {{Form::close()}}

    <script type="text/javascript">
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});

            $('#deleteButton').click(function() {

                var confirmation = confirm(jQuery(this).data('warning-message'));

                if (confirmation === false){
                    return false;
                }

                return isFormValid()
            });

            $('#updateButton').click(function() {
                return isFormValid()
            });

            jQuery(document).on('click', '#add-slot', function (e) {
                e.preventDefault();

                var rowSlotsCopy = $('.row-slots').last().clone();
                $('#times').append(rowSlotsCopy);

                resizeIframeHeight(0);

            });

            jQuery(document).on('click', '.remove-slot', function (e) {
                e.preventDefault();

                var divHeight = $(this).closest('.row-slots').outerHeight(true);

                $(this).closest('.row-slots').remove();

                resizeIframeHeight(divHeight);
            });

            function resizeIframeHeight(subtract) {

                var parentIframe = window.parent.document.getElementById('modal_iframe');
                var iframeDocument = parentIframe.contentDocument || parentIframe.contentWindow.document;
                var iframeHeight = iframeDocument.documentElement.scrollHeight;

                parentIframe.style.height = (iframeHeight-subtract)+'px';
            }

            function isFormValid (){

                if ( ! timesAreValid('.select-start-time')){
                    showNotify('Una o varias horas en Start Time están incompletas.')
                    return false
                }

                if ( ! timesAreValid('.select-end-time')){
                    showNotify('Una o varias horas en End Time están incompletas.')
                    return false
                }

                if ( ! slotsTimeAreValid()){
                    return false;
                }

                if ( ! applyDatesAreValid()){
                    return false
                }

                return true;
            }

            // Verificar que todas las horas han sido seleccionadas
            function timesAreValid (selectClass){

                var allSelected = true;
                var selectElements = $(selectClass);

                selectElements.each(function() {

                    console.log('selectclass: '+selectClass+' - ' +$(this).val())

                    if ($(this).val() === '') {
                        allSelected = false;
                        return false;
                    }
                });

                return allSelected;
            }

            function slotsTimeAreValid (){

                var isValid = true;
                var startTimes = $('select[name="start_time[]"]');
                var endTimes = $('select[name="end_time[]"]');
                console.log(startTimes)

                // Validar que start_date[i] < end_date[i]
                startTimes.each(function(index) {
                    var startTime = $(this).val();
                    var endTime = endTimes.eq(index).val();
                    if (startTime >= endTime) {
                        showNotify('Las horas seleccionadas en Start Time y End Time no están correctamente ordenadas.')
                        isValid = false;
                        return false; // Salir del bucle each si se encuentra una validación incorrecta
                    }
                });

                // Validar que no haya superposición de rangos (thanks ChatGPT ;)
                for (var i = 0; i < startTimes.length; i++) {

                    var startTime1 = startTimes.eq(i).val();
                    var endTime1 = endTimes.eq(i).val();

                    for (var j = i + 1; j < startTimes.length; j++) {
                        var startTime2 = startTimes.eq(j).val();
                        var endTime2 = endTimes.eq(j).val();

                        // Comprobar si el rango 2 está incluido dentro del rango 1
                        if (startTime2 >= startTime1 && endTime2 <= endTime1) {
                            showNotify('Un rango de horas está incluido dentro de otro.');
                            isValid = false;
                            break;
                        }

                        // Comprobar si hay solapamiento de rangos
                        if ((startTime1 >= startTime2 && startTime1 < endTime2) ||
                            (endTime1 > startTime2 && endTime1 <= endTime2)) {
                            showNotify('Las horas seleccionadas en Start Time y End Time tienen rangos de horas solapados.')
                            isValid = false;
                            break;
                        }
                    }

                    if (!isValid) {
                        break;
                    }
                }

                return isValid
            }

            function applyDatesAreValid (){

                var hasSelection = $('input[name="apply_dates"]:checked').length > 0;
                if ( ! hasSelection) {
                    showNotify('Es obligatorio seleccionar al menos una opción en Apply Dates.')
                    return false;
                }

                applyDates = $('input[name="apply_dates"]:checked').val()
                if (applyDates == 'apply_only_day'){
                    return true;
                }

                if (applyDates == 'apply_week_date'){
                    // Verificar que al menos un día de la semana está seleccionado
                    var checkboxes = document.querySelectorAll('.day-week');

                    var isChecked = Array.from(checkboxes).some(function(checkbox) {
                        return checkbox.checked;
                    });

                    // Si ningún checkbox está seleccionado, detener el envío del formulario
                    if (!isChecked) {
                        showNotify('Es obligatorio al menos seleccionar un día de la semana.')
                        return false;
                    }
                }

                //check dates fields are filled
                var dateFields = $('.field-date');

                var areFilled = dateFields.filter(function() {
                    return $(this).val() !== '';
                }).length === dateFields.length;

                if ( ! areFilled){
                    showNotify('Las fechas From Date y To Date son obligaorias para la opción seleccionada en Apply Dates.')
                    return false;
                }

                return true;
            }

            function showNotify (message, type = 'error'){

                $.notify(message, {
                    className: type,
                    position: "top left",
                    /*elementPosition: "top left",*/
                    showDuration: 400,
                    hideDuration: 400,
                    autoHideDelay: 2000,
                });
            }
        });


    </script>

@endsection
