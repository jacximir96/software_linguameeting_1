<table id="" class="table table-hover">
    <thead>
    <tr>
        <th class="w-30">From</th>
        <th class="w-50">Subject</th>
        <th class="c-20">Last Write</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($threads as $thread)
        <tr class="">
            <td>
                <span class="d-block fw-bold">{{$thread->writer->writeFullName()}}</span>
                <span class="d-block">{{$thread->writer->email}}</span>
            </td>
            <td>
                @if ($thread->readForUser($user))
                    @php $moment = $thread->infoReadForUser($user)->read_at @endphp
                    <i class="fa fa-circle fa-xs text-success" title="Read at: {{toDatetimeInOneRow($moment, $timezone)}}"></i>
                @else
                    <i class="fa fa-circle fa-xs text-danger" title="Not Read"></i>
                @endif

                <a href="{{route('get.common.messaging.thread.show', $thread->hashId())}}" title="Read Thread">
                    {{$thread->subject}}
                </a>
            </td>
            <td>

                @php $moment = $thread->message->last()->write_at @endphp
                {!! toDatetimeInTwoRow($moment, $timezone) !!}

            </td>
        </tr>
    @empty
        <tr>
            <td class="text-left" colspan="10">
                <span class="bg-warning p-2 py-1 rounded text-white">Not messaging found</span>
            </td>
        </tr>
    @endforelse


    </tbody>
</table>
<input type="hidden" name="query-string" id="query-string" class="form-control" value="{{ http_build_query(request()->input()) }}"/>
{{$threads->appends(request()->except(['_token']))->links()}}
