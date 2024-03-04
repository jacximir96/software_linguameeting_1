@extends('layouts.app_modal')

@section('content')


    <div class="row">
        <div class="col-12">
            <table id="" class="table" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>Feedback File</th>
                    <th>Date</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($evaluations as $evaluation)
                    @foreach ($evaluation->file as $file)
                        <tr>
                            <td>
                                <a href="{{route('get.common.coaches.evaluation_manager.file.download', $file->hashId())}}" class="" title="Download evaluation file">
                                    <i class="fa fa-download"></i> Download file
                                </a>
                            </td>
                            <td>{{$evaluation->evaluation_at}}</td>

                        </tr>
                    @endforeach
                @empty

                    <tr>
                        <td colspan="2" class="text-left">
                            <span class="bg-warning text-white p-1 rounded">There is not feedback to show</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
