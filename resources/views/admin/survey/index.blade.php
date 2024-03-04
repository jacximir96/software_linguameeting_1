@extends('layouts.app')

@section('content')


    <div class="card mb-4">
        <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-poll me-1"></i>
                List of Surveys
            </span>
        </div>
        <div class="card-body">

            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th class="w-25">Origen</th>
                    <th class="w-30">Description</th>
                    <th class="w-5">Date</th>
                    <th class="w-5">Active</th>
                    <th class="w-20">Url</th>
                    <th class="w-5">Observations</th>
                    <th class="w-10">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($surveys as $survey)
                    <tr>
                        <td>
                            @if ($survey->isCourse())
                                <a href="{{route('get.admin.course.show', $survey->surveyable->id)}}" class="d-block" title="Show Course">
                                    {{$survey->surveyable->name}}
                                </a>
                            @else
                                <a href="{{route('get.admin.university.show', $survey->surveyable->id)}}" class="d-block" title="Show University">
                                    {{$survey->surveyable->name}}
                                </a>
                            @endif
                            <span class="d-block">{{$survey->writeType()}}</span>
                        </td>
                        <td>
                            {{$survey->description}}
                        </td>
                        <td>{{toDate($survey->created_at)}}</td>
                        <td>
                            @if ($survey->isActive())
                                <span class="text-success">Yes</span>
                            @else
                                <span class="text-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{$survey->url}}" title="Go to survey" target="_blank">
                                {{$survey->url}}
                            </a>
                        </td>
                        <td>
                            @if ($survey->hasObservations())
                                <a href="{{route('get.admin.survey.show', $survey->id)}}"
                                   class="open-modal me-2"
                                   data-modal-size="modal-lg"
                                   data-modal-reload="yes"
                                   data-reload-type="parent"
                                   data-modal-title='Show Survey'
                                   title="Show Observations">
                                    <i class="fa fa-comments text-success"></i>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>

                           @include('admin.survey.actions', ['survey' => $survey])

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$surveys->render()}}
        </div>
    </div>
@endsection
