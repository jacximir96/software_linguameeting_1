<div>
    <a href="#">Show assignments</a>
</div>

<div class="row">
    <div class="col-12">
        <p>
            Session {{$enrollmentSessionFacade->sessionOrder()->get()}}
        </p>
        <p>
            @php $scheduleSession = $enrollmentSessionFacade->scheduleSession() @endphp
            Date: {{$scheduleSession->print()}}
        </p>
    </div>
</div>
