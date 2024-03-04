@extends('layouts.app')

@section('content')


    <div class="card mb-4 col-6">
        <div class="card-header p-2 d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-language me-1"></i>
                List of languages
            </span>

            <a href="{{route('get.admin.config.language.create')}}"
               class="open-modal text-success me-3"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Create Language'
               title="Create Language">
                <i class="fa fa-plus"></i> Create Language
            </a>
        </div>
        <div class="card-body">

            <table id="" class="table table-hover small">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Is Lingro?</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>


                @foreach ($languages as $language)

                    <tr>
                        <td>{{$language->id}}</td>
                        <td>{{$language->name}}</td>
                        <td>{{$language->is_lingro ? 'Yes' : 'No'}}</td>

                        <td>
                            <a href="{{route('get.admin.config.language.edit', $language->id)}}"
                               class="open-modal me-3"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Edit Language'
                               title="Edit Language">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.config.language.delete', $language->id)}}"
                               onclick="return confirm('Are you sure you want to delete this language?');">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
