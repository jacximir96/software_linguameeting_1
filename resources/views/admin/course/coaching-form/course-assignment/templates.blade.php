<div class="row">
    <div class="col-12">
        <p class="mb-1">
            <span class="fw-bold">Templates</span>
        </p>
    </div>

    <div class="col-12 mt-3">

        <ul class="">
            @foreach ($templates as $template)
                <li class="mb-2" style="border-bottom: 1px solid #eee">
                    <span class="d-inline-block w-75">{{$template->description}}</span>
                    <a href="{{route('get.admin.config.conversation_guide.template.file.download', $template->file->id)}}"
                       class="ms-2 small"
                       title="Download {{$template->file->original_name}}">
                        <i class="fa fa-download"></i> Download
                    </a>
                </li>

            @endforeach
        </ul>
    </div>


</div>
