@extends('layouts.app')

@section('content')

    @include('common.form_message_errors')

    <div class="row">
        <div class="col-12 col-xl-8 offset-xl-2">

            <div class="row">
                <div class="col-12">
                    <span class="text-corporate-color fw-bold">From: </span>
                    <span class="bg-corporate-color-light px-1 fw-bold">{{$thread->writer->writeFullName()}}</span>
                </div>

                <div class="col-12 mt-2">
                    <span class="text-corporate-color fw-bold">Date: </span>
                    @php $moment = $thread->message->first()->write_at @endphp
                    <span class="bg-corporate-color-light px-1 fw-bold">{{toDatetimeInOneRow($moment, $timezone)  }}</span>
                </div>

                <div class="col-12 mt-2">

                    <span class="text-corporate-color fw-bold">Participants: </span>
                    @foreach ($thread->participant as $participant)
                        <span class="bg-corporate-color-light px-1">{{$participant->user->writeFullName()}}</span> @if( ! $loop->last),@endif
                    @endforeach
                </div>
            </div>

            @foreach ($thread->message as $message)
                @include('messaging.message')
            @endforeach

            <div class="row mt-5">
                <div class="col-12">
                    <label class="fw-bold text-corporate-color"><i class="fa fa-reply"></i> Write Reply</label>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @include('messaging.form_reply')
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-end">
                    <a href="{{route('get.admin.messaging.delete', $thread->hashId())}}"
                       class="btn btn-sm btn-danger text-white"
                       onclick="return confirm('Are you sure you want to delete this thread?');">
                        Delete Thread
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
