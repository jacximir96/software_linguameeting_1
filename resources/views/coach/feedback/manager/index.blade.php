@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-tasks me-1"></i>
                Linguameeting Feedback
            </span>
            <span>{{$timezone->name}}</span>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 col-xl-6">


                    <table id="" class="table table-hover">
                        <thead>
                        <tr>
                            <th class="w-30">Date</th>
                            <th class="w-70">File</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($evaluations as $evaluation)

                            <tr>

                                <td>
                                    {!! toDatetimeInOneRow($evaluation->evaluation_at, $timezone) !!}
                                </td>
                                <td>
                                    @foreach ($evaluation->file as $file)
                                        <a href="{{route('get.coach.feedback.manager.file.download', $file->hashId())}}" class="" title="Download evaluation file">
                                            <i class="fa fa-download"></i> Download file
                                        </a>
                                    @endforeach
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
