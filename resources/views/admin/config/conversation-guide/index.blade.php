@extends('layouts.app')

@section('content')


    <div class="card mb-4 col-8">
        <div class="card-header p-2 d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-book me-1"></i>
                List of conversation guides
            </span>
        </div>
        <div class="card-body">

            <table id="" class="table table-hover small">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Origin</th>
                    <th>Name</th>
                    <th>Language</th>
                    <th>Chapters</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @php $originId = $guides->first()->guide_origin_id @endphp

                @foreach ($guides as $guide)
                    @if ($originId != $guide->guide_origin_id)
                        <tr><td colspan="6"></td> </tr>
                        @php $originId = $guide->guide_origin_id @endphp
                    @endif
                    <tr>
                        <td>{{$guide->id}}</td>
                        <td>{{$guide->origin->name}}</td>
                        <td>{{$guide->name}}</td>
                        <td>{{$guide->language->name}}</td>
                        <td>{{$guide->chapter->count()}}</td>
                        <td>
                            <a href="{{route('get.admin.config.conversation_guide.show', $guide->id)}}" title="Show Conversation Guide" class="me-2">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{route('get.admin.config.conversation_guide.edit', $guide->id)}}"
                               class="open-modal"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Edit conversation guide'
                               title="Edit conversation guide">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
