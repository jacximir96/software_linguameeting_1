<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        var calendarEl = document.getElementById('calendar');
        var currentViewType = 'dayGridMonth';
        var eventsLoaded = false;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            allDaySlot: false,
            locale: 'en',
            contentHeight: 'auto',
            eventDisplay: 'block',
            defaultDate: '{!! \Carbon\Carbon::now($timezone->name)->toDateString() !!}',
            initialView: 'dayGridWeek',
            firstDay: 1,
            timezone: '{!!$timezone->name !!}',
            headerToolbar: {
                left: 'today prev,next',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay,listDay'
            },
            eventTimeFormat: {// like '14:30:00'
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            datesSet: function (info) {
                eventsLoaded = false;
                calendar.refetchEvents()
            },
            eventContent: function (arg) {

                var isBlockedSes = arg.event.extendedProps.blockedSes

                var classColor = ''
                if (isBlockedSes){
                    classColor = 'schedule-blocked-ses'
                }

                if (currentViewType == 'dayGridMonth') {
                    return {
                        html: '<div class="fc-event-title '+classColor+'" style="white-space: normal;padding:2px">' + arg.event.title + '</div>',
                    };
                }

                return {
                    html: '<div class="fc-event-title '+classColor+'" style="white-space: normal;padding:2px">' + arg.event.title + '</div>',
                }
            },
            eventDidMount: function (arg) {
                arg.el.setAttribute("data-modal-size", 'modal-xl');
                arg.el.setAttribute("data-modal-height", 'h-95');
                arg.el.setAttribute("data-modal-title", arg.event.extendedProps.modalTitle);

                var eventEl = arg.el;
                eventEl.style.backgroundColor = arg.event.backgroundColor;
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();
            },
            events: function (info, successCallback, failureCallback) {
                if (!eventsLoaded) {
                    fetchEvents(info.start, info.end, successCallback, failureCallback);
                    eventsLoaded = true;
                }
            },
            viewDidMount: function (info) {
                currentViewType = info.view.type;
            },
        });


        function fetchEvents(startDate, endDate, successCallback, failureCallback) {

            if (!isDateValid(startDate)) {
                return
            }
            if (!isDateValid(endDate)) {
                return
            }

            var options = {timeZone: '{{userTimezoneName()}}', year: 'numeric', month: '2-digit', day: '2-digit'};

            var start = new Date(startDate);
            var dateString = start.toLocaleDateString('es-ES', options);
            var parts = dateString.split('/');
            start = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');

            var end = new Date(endDate);
            dateString = end.toLocaleDateString('es-ES', options);
            parts = dateString.split('/');
            end = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');

            var url = '{!! $getEventUrl !!}' + '/' + '{!! $user->hashId() !!}' + '/' + start + '/' + end + '/' + currentViewType

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
