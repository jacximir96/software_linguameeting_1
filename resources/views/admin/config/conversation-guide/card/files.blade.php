<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-fw fa-folder-open me-2"></i> Files
        </span>
    </div>
    <div class="card-body  d-none d-md-block">

        <div class="col-12 mb-3 ps-2 d-none d-lg-block">

            <table class="table table-responsive">
                <thead>
                <tr class="text-corporate-color">
                    <th class="text-center w-50" >Description</th>
                    <th class="text-center w-40">File</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($files as $file)
                    <tr class="small">
                        <td class="text-left">

                            {{$file->description}}
                        </td>
                        <td class="text-center">

                            <a href="{{route('get.admin.config.conversation_guide.file.download', $file->id)}}" title="Download {{$file->original_name}}">
                                <i class="fa fa-download"></i> Download
                            </a>

                        </td>
                        <td>
                            <a href="{{route('get.admin.config.conversation_guide.file.edit', $file->id)}}"
                               class="open-modal me-2"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Edit File'
                               title="Edit File">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.config.conversation_guide.file.delete', $file->id)}}"
                               onclick="return confirm('Are you sure you want to delete this file');">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No existen archivos específicos asociados a la guía de conversación</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        <div class="col-12 d-block d-lg-none">
            <div class="row ps-2">

                @forelse ($files as $file)
                    <div class="col-12 mb-3 ps-2">
                        <div class="row">
                            <div class="col-12">
                        <span class="fw-bold fst-italic">
                           {{$file->description}}
                        </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 mb-3 ps-2">
                        No existen archivos específicos asociados a la guía de conversación
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 text-end">

            <a href="{{route('get.admin.config.conversation_guide.file.create', $guide->id)}}"
               class="open-modal text-success"

               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Create File'>
                <i class="fa fa-plus"></i> Create File
            </a>
        </div>
    </div>

</div>


