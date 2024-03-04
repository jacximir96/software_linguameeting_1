<div class="row">
    <div class="col-12">
        <p class="mb-1">
            <span class="fw-bold">Conversation guide:</span> <span class="text-corporate-color fw-bold">{{$guide->name}}</span>
        </p>
        <p class="mb-1">
            <span class="fw-bold">Language:</span> <span class="text-corporate-color fw-bold">{{$course->language->name}}</span>
        </p>
    </div>

    @if ($guide->conversationGuideFile->count())
        <div class="col-12 mt-3">
            <span class="bg-corporate-color-light text-corporate-dark-color fw-bold rounded p-1">Files</span>

            <ul class="mt-2">
                @foreach ($guide->conversationGuideFile as $file)
                    <li class="mb-2" style="border-bottom: 1px solid #eee">
                        <span class="d-inline-block w-75">{{$file->description}}</span>
                        <a href="{{route('get.admin.config.conversation_guide.file.download', $file->id)}}"
                           class="ms-2 small"
                           title="Download {{$file->original_name}}">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </li>

                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-12 mt-3">
        <span class="bg-corporate-color-light text-corporate-dark-color fw-bold rounded p-1">Chapters</span>
    </div>

    <div class="col-12 mt-2">
        <ul>
            @foreach ($guide->chapter as $chapter)
                <li class="mb-2" style="border-bottom: 1px solid #eee">
                <span class="d-inline-block w-75">{{$chapter->name}}</span>

                @if ($chapter->file)
                    <a href="{{route('get.common.conversation_guide.chapter.file.download', $chapter->file->id)}}"
                       class="ms-2 small"
                       title="Download {{$chapter->file->original_name}}">
                        <i class="fa fa-download"></i> Download
                    </a>
                @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
