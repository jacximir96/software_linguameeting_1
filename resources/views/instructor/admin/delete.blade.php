@extends('layouts.app_modal')

@section('content')

<form action="{{route('post.instructor.admin.delete', $user->hashId())}}" method="POST" id="delete-instructor-form">
    @csrf
    <div class="row mt-3">
        <div class="col-12">
            Are you sure you want to delete this instructor: <strong>{{$user->name}} {{$user->lastname}}</strong>?
        </div>
    </div>

    <div class="modal-footer d-flex justify-content-between">
        <button class="btn btn-danger btn-sm btn-bold px-4" type="submit">
            Delete
        </button>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>
@endsection
