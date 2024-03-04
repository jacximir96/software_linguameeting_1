@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Coaches</h6>
        </div>
        <div class="card-body">
            @include('admin.coach.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-table me-1"></i>
                    List of Coaches
                </span>
            <a href="{{route('get.admin.coach.create')}}" class="text-success px-4" title="Create coach">
                <i class="fa fa-plus"></i> Create Coach
            </a>

        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.coach.excel.download') }}?{{ http_build_query(request()->input()) }}"
                       class="small"
                       title="Download excel with selected coaches">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>
                </div>
            </div>

            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <td class="">

                    </td>
                    <th>ID</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.coach.search', 'field' => 'name', 'tag' => 'Name'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.coach.search', 'field' => 'lastname', 'tag' => 'Last Name'])</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>In-Training</th>
                    <th>Country</th>
                    <th>TimeZone</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($coaches as $coach)
                    <tr>
                        <td>
                            {{Form::checkbox('selected_id[]', $coach->hashId(),null, ['class' => 'item-to-select'] )}}
                        </td>
                        <td>{{$coach->id}}</td>
                        <td>
                            <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="mr-2" title="Show coach">
                                {{$coach->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="mr-2" title="Show coach">
                                {{$coach->lastname}}
                            </a>

                            @if ( ! $coach->isActive())
                                <span class="badge bg-warning text-dark ms-2">Disabled</span>
                            @endif

                            @if ( $coach->isDeleted()!='')
                                <span class="badge bg-danger text-dark ms-2">Deleted</span>
                            @endif
                        </td>

                        <td>{{$coach->getRoleName()->first()}}</td>
                        <td>{{$coach->email}}</td>
                        <td>
                            @if ( $coach->coachinfo->is_trainee==1)
                            Yes
                            @else
                            No
                            @endif
                        </td>
                        <td>{{$coach->country->name}}</td>
                        <td>{{$coach->timezone->name}}</td>
                        <td>

                            <a href="{{route('get.admin.coach.edit', $coach->hashId())}}" class="text-primary me-2" title="Edit Coach">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.common.coaches.evaluation_manager.show', $coach->hashId())}}"
                               class="open-modal {{$coach->evaluationManager->count() ? 'text-primary' : 'text-muted'}} me-2"
                               data-modal-reload="no"
                               data-modal-title='Show Evaluation Manager'
                               title="{{$coach->evaluationManager->count() ? 'Show feedback' : 'This coach has not evaluation'}}">
                                <i class="fa fa-comment-dots"></i>
                            </a>

                            @if ($coach->trashed())
                                <a href="{{route('get.admin.coach.restore', $coach->hashId())}}"
                                   class="text-success"
                                   onclick="return confirm('Are you sure to restore this coach?');"
                                   title="Delete Coach">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @else
                                <a href="{{route('get.admin.coach.delete', $coach->hashId())}}"
                                   class="text-danger"
                                   onclick="return confirm('Are you sure you want to delete this coach?');"
                                   title="Delete Coach">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-left" colspan="10">
                            <span class="bg-warning p-2 py-1 rounded text-white">Coaches not found</span>
                        </td>
                    </tr>
                @endforelse

                    <tr>

                        <td colspan="10" class="">
                            <input type="checkbox" name="check_all" class="check-and-uncheck-all-with-all" data-target-class="item-to-select"/>

                            <p class="ms-3 p-2 rounded bg-light d-none d-inline" id="block-all">
                                <span class="d-inline-block me-3 text-muted">Están seleccionados los {{$coaches->count()}} coaches de esta página.</span>
                                <span class="d-inline-block text-primary">
                                ¿Seleccionar los {{$coaches->total()}} coaches del listado completo? <input type="checkbox" id="select-all" name="select_all" value="all" />
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="10">

                            <a href="{{route('get.admin.coach.email.send.config_view')}}"
                               title="Send mail to selected coaches"
                               data-target-class="item-to-select"


                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Send email'

                               class="send-mail-selected-users">
                                <i class="fa fa-envelope"></i> Send mail
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
            <input type="hidden" name="query-string" id="query-string" class="form-control" value="{{ http_build_query(request()->input()) }}" />
            {{$coaches->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
