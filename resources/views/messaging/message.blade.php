<div class="row gx-3 border rounded mt-3 shadow-sm">
    <div class="col-12 d-flex justify-content-between border-bottom py-2 bg-corporate-color-light">
        <div class="text-start d-inline-block">
            <span>Write by</span>
            <span class="d-inline-block fw-bold">{{$message->user->writeFullName()}}</span>
            at
            @php $moment = $message->write_at @endphp
            <span class="d-inline-block">{{toDatetimeInOneRow($moment, $timezone)}}</span>
        </div>
        @if ($messageDeletionStrategy->canBeDeleted($message, user()))
            <a href="{{route('get.common.messaging.message.delete', $message->hashId())}}"
               title="Delete Message"
               onclick="return confirm('Are you sure you want to delete this message?');">
                <i class="fa fa-times text-danger"></i>
            </a>
        @endif
    </div>

    <div class="col-12 mt-2 pb-5">
        {!! $message->content !!}
    </div>

    @if ($message->file->count())
        <div class="col-12">
            <div class="row">
                <div class="col-12 ">
                    <label class="text-muted "><i class="fa fa-paperclip"></i> Attachments</label>
                </div>
            </div>
            <div class="col-12">

                @foreach ($message->file as $file)
                    <a href="{{route('get.common.messaging.file.download', $file->hashId())}}" class="d-inline-block fw-normal" title="Download {{$file->original_name}}">
                        {{$file->original_name}} @if( !$loop->last),@endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
