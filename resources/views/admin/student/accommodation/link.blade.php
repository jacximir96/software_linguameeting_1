@if ($enrollment->accommodation)

    <a href="#"
       class="d-inline-block fw-bold text-corporate-danger"
       data-bs-toggle="modal"
       data-bs-target="#modal-accommodation-{{$enrollment->id}}">
        (A)
    </a>

    @include('common.modal_info', [
        'modalId' => 'modal-accommodation-'.$enrollment->id,
        'modalTitle' => 'Accommodation to '.$enrollment->user->writeFullName(),
        'size' => 'modal-md',
        'path' => 'admin.student.accommodation.mini_modal',
        'accommodation' => $enrollment->accommodation,
    ])

@endif
