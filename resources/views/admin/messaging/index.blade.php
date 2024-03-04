@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12 col-xl-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-envelope me-1"></i>
                        @if (isset($isInbox))
                            Inbox
                        @else
                            Sent
                        @endif
                        Messaging
                    </span>
                    <a href="{{route('get.admin.messaging.create')}}"
                       title="Write Message"
                       class="open-modal mt-1 text-success "
                       data-modal-size="modal-lg"
                       data-modal-height="h-90"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title="Write Message">
                        <i class="fa fa-edit"></i> Write Message
                    </a>
                </div>
                <div class="card-body">
                    @include('messaging.thread_tabla', ['threads' => $threads, 'user' => $user])
                </div>
            </div>
        </div>
    </div>
@endsection
