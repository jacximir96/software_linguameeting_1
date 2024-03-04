@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-calendar me-1"></i>
                        Availability
                    </span>
                    <span>
                        {{userTimezoneName()}}
                    </span>
                </div>
                <div class="card-body">

                    <div class="row ">
                        <div class="col-12 p-0 text-corporate-danger">
                            <ul class="m-0">
                                <li>I accept that the availability I have provided is correct.</li>
                                <li>I will be avaible for the duration of the course during those days and times -7/8 h. a day maximum-.</li>
                                <li>If there is any change, I will contact the LinguaMeeting team at the soonest brevity.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="row mt-4 d-none" id="div-caption">
                        <div class="col-md-6 div_btn_saveCalendar padding-right10">
                            @include('admin.coach.schedule.caption')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});

            var coachId = '{!! $coach->hashId() !!}'
            var urlCreate = '{!! route('get.coach.schedule.availability.create') !!}'
            var calendarEl = document.getElementById('calendar');
            var currentViewType = 'dayGridMonth';
            var eventsLoaded = false;


            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'en',
                defaultView: 'dayGridMonth',
                defaultDate: '{!! \Carbon\Carbon::now(userTimezoneName())->toDateString() !!}',
                timeZone: '{!! userTimezoneName() !!}',
                firstDay: 1,
                contentHeight: "auto",
                headerToolbar: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                eventContent: function (arg) {

                    if (currentViewType == 'dayGridMonth') {
                        var isBlockedSes = arg.event.extendedProps.blockedSes

                        var classColor = ''
                        if (isBlockedSes){
                            classColor = 'schedule-blocked-ses'
                        }

                        return {
                            html: '<div class="fc-daygrid-event-dot '+classColor+' "></div> <div class=" fc-event-title '+classColor+'">' + arg.event.title + '</div>',
                        };
                    }
                    return {
                        html: ' <div class=" fc-event-title text-white '+classColor+'">' + arg.event.title + '</div>',
                    }
                },
                eventClassNames: function (arg) {
                    if (currentViewType == 'dayGridMonth') {
                        return '';
                    }
                    return ['no-opacity']; // Clase CSS personalizada para todos los eventos
                },
                eventDidMount: function (arg) {
                    arg.el.setAttribute("data-modal-size", 'modal-lg');
                    arg.el.setAttribute("data-modal-title", arg.event.extendedProps.modalTitle);
                },
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                },
                dayCellDidMount: function (dayCellInfo) {
                    if (dayCellInfo.view.type === 'dayGridMonth') {
                        //Create link for add more availability only in month view
                        addCreateAvailabilityLinkToCell(dayCellInfo)
                    }
                },
                events: function (info, successCallback, failureCallback) {
                    if (!eventsLoaded) {
                        fetchEvents(info.start, info.end, successCallback, failureCallback);
                        eventsLoaded = true;
                    }
                },
                viewDidMount: function (info) {
                    currentViewType = info.view.type;
                    jQuery('#div-caption').removeClass('d-block')
                    jQuery('#div-caption').removeClass('d-none')
                    jQuery('#div-caption').addClass('d-none')

                    if (info.view.type !== 'dayGridMonth') {
                        calendar.refetchEvents();
                        jQuery('#div-caption').removeClass('d-none')
                        jQuery('#div-caption').addClass('d-block')
                    }
                },
                datesSet: function (info) {
                    eventsLoaded = false;
                    calendar.refetchEvents()
                },
                eventMouseEnter: function (info) {

                    if (info.view.type === "timeGridWeek") {
                        var eventEl = info.el;
                        var tooltipText = info.event.extendedProps.tooltipText;

                        $(eventEl).tooltip({
                            title: tooltipText,
                            placement: "top",
                            trigger: "hover",
                            container: "body",
                        }).tooltip("show");
                    }

                },
            });


            function addCreateAvailabilityLinkToCell(dayCellInfo) {
                var date = dayCellInfo.date;
                var year = date.getFullYear();
                var month = date.getMonth() + 1;
                var day = date.getDate();
                var selectedDate = year + '-' + month + '-' + day;

                var urlModal = urlCreate + '/' + coachId + '/' + selectedDate;

                var linkElement = document.createElement('a');
                linkElement.className = 'custom-link open-modal';
                linkElement.href = urlModal;
                linkElement.target = '_blank';
                linkElement.dataset.modalReload = 'no';
                linkElement.dataset.modalSize = 'modal-lg';
                linkElement.dataset.reloadType = 'parentWithUrl';
                linkElement.dataset.modalTitle = 'Add Available Time for {!! $coach->writeFullName() !!} in ' + month + '/' + day + '/' + year;
                linkElement.style = 'position:absolute; top:0; right:5px;font-size:11px';

                var iconElement = document.createElement('i');
                iconElement.className = 'fa fa-plus';
                linkElement.appendChild(iconElement);

                var dayBottomElement = dayCellInfo.el.querySelector('.fc-daygrid-day-frame');
                dayBottomElement.appendChild(linkElement);
            }

            //Recargar eventos cuando se cierre el modal de configucion de la disponibilidad
            $('#modal-lingua').on('hidden.bs.modal', function () {

                eventsLoaded = false;
                calendar.refetchEvents();

                $('#modal-lingua iframe').attr('src', '');
            });


            function fetchEvents(startDate, endDate, successCallback, failureCallback) {

                if (!isDateValid(startDate)) {
                    return
                }
                if (!isDateValid(endDate)) {
                    return
                }

                var options = {timeZone: 'Europe/Madrid', year: 'numeric', month: '2-digit', day: '2-digit'};

                var start = new Date(startDate);
                var dateString = start.toLocaleDateString('es-ES', options);
                var parts = dateString.split('/');
                start = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');

                var end = new Date(endDate);
                dateString = end.toLocaleDateString('es-ES', options);
                parts = dateString.split('/');
                end = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');

                var url = '{!! $getEventUrl !!}' + '/' + '{!! $coach->id !!}' + '/' + start + '/' + end + '/' + currentViewType

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function (response) {
                        var events = response.events; // Suponiendo que los eventos están en un campo llamado "events"
                        events = JSON.parse(events)

                        if (typeof successCallback === 'function') {
                            successCallback(events);
                        }
                    },
                    error: function () {
                        if (typeof failureCallback === 'function') {
                            failureCallback();
                        }
                    }
                });
            }

            function isDateValid(value) {
                var dateObject = new Date(value);
                return !isNaN(dateObject.getTime());
            }

            calendar.render();

        });
    </script>

@endsection
