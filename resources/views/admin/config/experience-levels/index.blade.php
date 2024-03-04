@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-12 col-lg-6 col-xl-4">

            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-cog me-1"></i>
                        Experience Levels
                    </span>

                    <a href="{{route('get.admin.config.experience_level.create')}}"
                       title="Create Experience Level"
                       class="open-modal mt-1 text-success "
                       data-modal-size="modal-md"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title="Create Experience Level">
                        <i class="fa fa-plus"></i> Experience Level
                    </a>
                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                                <thead>
                                <tr class="small">
                                    <th class="w-80">
                                        Name
                                    </th>
                                    <th class="w-20">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($levels as $level)

                                    <tr>
                                        <td>{{$level->name ?? '-'}}</td>
                                        <td>
                                            <a href="{{route('get.admin.config.experience_level.edit', $level->hashId())}}"
                                               class="open-modal me-3"
                                               data-modal-size="modal-md"
                                               data-modal-reload="yes"
                                               data-reload-type="parent"
                                               data-modal-title='Edit Level'
                                               title="Edit Level">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{route('get.admin.config.experience_level.delete', $level->hashId())}}"
                                               onclick="return confirm('Are you sure you want to delete this experience level?');"
                                               title="Delete Level ">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
