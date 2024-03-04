<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-fw fa-book me-2"></i> Chapters
        </span>
    </div>
    <div class="card-body  d-none d-md-block">

        <div class="col-12 mb-3 ps-2 d-none d-lg-block">

            <table class="table table-responsive">
                <thead>
                <tr class="text-corporate-color">
                    <th class="text-center w-50" >Name</th>
                    <th class="text-center w-40">File</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($chapters as $chapter)
                    <tr class="small">
                        <td class="text-left">

                            {{$chapter->name}}
                        </td>
                        <td class="text-center">
                            @if ($chapter->file)
                                <a href="{{route('get.common.conversation_guide.chapter.file.download', $chapter->file->id)}}" title="Download {{$chapter->file->original_name}}">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{route('get.admin.config.conversation_guide.chapter.edit', $chapter->id)}}"
                               class="open-modal me-2"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Edit chapter'
                               title="Edit chapter">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.config.conversation_guide.delete', $chapter->id)}}"
                               onclick="return confirm('Are you sure you want to delete this chapter');">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No existen chapters asociados a esta guía de conversación</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        <div class="col-12 d-block d-lg-none">
            <div class="row ps-2">

                @forelse ($chapters as $chapter)
                    <div class="col-12 mb-3 ps-2">
                        <div class="row">
                            <div class="col-12">
                        <span class="fw-bold fst-italic">
                           {{$chapter->name}}
                        </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 mb-3 ps-2">
                        No existen chapters asociados a esta guía de conversación
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 text-end">

            <a href="{{route('get.admin.config.conversation_guide.chapter.create', $guide->id)}}"
               class="open-modal text-success"

               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Create chapter'>
                <i class="fa fa-plus"></i> Create Chapter
            </a>
        </div>
    </div>

</div>


