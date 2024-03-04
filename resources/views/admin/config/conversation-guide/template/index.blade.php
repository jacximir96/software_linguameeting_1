@extends('layouts.app')

@section('content')


    <div class="card mb-4 col-6">
        <div class="card-header p-2 d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-book me-1"></i>
                List of Templates
            </span>
        </div>
        <div class="card-body">

            <table class="table table-responsive">
                <thead>
                <tr class="text-corporate-color">
                    <th class="text-center w-50" >Description</th>
                    <th class="text-center w-40">File</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($templates as $template)
                    <tr class="">
                        <td class="text-left">
                            {{$template->description}}
                        </td>
                        <td class="text-center">
                            @if ($template->file)
                                <a href="{{route('get.admin.config.conversation_guide.template.file.download', $template->file->id)}}" title="Download {{$template->file->original_name}}">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{route('get.admin.config.conversation_guide.template.edit', $template->id)}}"
                               class="open-modal me-2"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Edit template'
                               title="Edit template">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.config.conversation_guide.template.delete', $template->id)}}"
                               onclick="return confirm('Are you sure you want to delete this template');">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No existen templates.</td>
                    </tr>
                @endforelse

                </tbody>
            </table>

            <div class="row mt-2">
                <div class="col-12 text-end">

                    <a href="{{route('get.admin.config.conversation_guide.template.create')}}"
                       class="open-modal text-success"

                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title='Create Template'>
                        <i class="fa fa-plus"></i> Create Template
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
