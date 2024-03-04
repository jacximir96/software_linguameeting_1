<div class="card">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-envelope me-1"></i>
            Messaging
        </span>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12 d-flex justify-content-between ">
                <p class="bg-corporate-color-light px-1 fw-bold">Latest Messages</p>
                <p class="fw-bold small"><span class="fw-bold text-corporate-danger">{{$viewData->messaging()->total()}} unread</span> messages</p>
            </div>
            <div class="col-12">
                <table id="" class="table table-hover mb-1">
                    <thead>
                    <tr>
                        <th class="w-30">From</th>
                        <th class="w-50">Subject</th>
                        <th class="c-20">Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($viewData->messaging()->get() as $thread)
                        <tr class="">
                            <td>
                                <span class="d-block fw-bold">{{$thread->writer->writeFullName()}}</span>
                            </td>
                            <td>
                                <i class="fa fa-circle fa-xs text-danger" title="Not Read"></i>

                                <a href="{{route('get.common.messaging.thread.show', $thread->hashId())}}" title="Read Thread">
                                    {{$thread->subject}}
                                </a>
                            </td>
                            <td>

                                @php $moment = $thread->message->first()->write_at @endphp
                                {!! toDatetimeInTwoRow($moment, $timezone) !!}

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-left" colspan="10">
                                <span class="text-success fw-bold text-decoration-underline">No tienes mensajes sin leer</span>
                            </td>
                        </tr>
                    @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-0">
            <div class="col-12 text-end">
                <p class="mt-0"><a href="{{route('get.coach.messaging.index')}}" class="text-decoration-underline" title="View All Reviews">View All Messages</a></p>
            </div>
        </div>
    </div>
</div>
