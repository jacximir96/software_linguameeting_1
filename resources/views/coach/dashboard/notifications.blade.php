<div class="card">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-bell me-1"></i>
            Notifications
        </span>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <p class="bg-corporate-color-light px-1 fw-bold">Latest Notifications</p>
                <p class="fw-bold small"><span class="fw-bold text-corporate-danger">{{$viewData->notifications()->total()}} unread</span>  notifications</p>
            </div>
            <div class="col-12">
                <table id="" class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="w-5">Level</th>
                        <th class="w-10">Type</th>
                        <th class="w-20">Description</th>
                        <th class="w-10">Notification at</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($viewData->notifications()->get() as $notification)

                        <tr>
                            <td>
                                <span class="d-inline-block p-1 rounded" style="background-color: {{$notification->type->level->color}}">
                                    {{$notification->type->level->name}}
                                </span>
                            </td>
                            <td>{{$notification->type->name}}</td>
                            <td>{{$notification->type->description}}</td>
                            <td>
                                <span class="d-block">{!! toDatetimeInTwoRow($notification->notification_at, $timezone) !!}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-12 mt-2 text-end">

                <p><a href="{{route('get.notification.index')}}" class="text-decoration-underline" title="View All Reviews">View All Notifications</a></p>
            </div>

        </div>
    </div>
</div>
