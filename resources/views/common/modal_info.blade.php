<div class="modal fade " id="{{$modalId}}">
    <div class="modal-dialog modal-dialog-scrollable {{isset($size) ? $size : ''}}">
        <div class="modal-content">
            <div class="modal-header bg-corporate-color text-white">
                <h6 class="modal-title" id="modal-lingua-title">{{$modalTitle}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include($path)
            </div>
            @if (!isset($noFooter))
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
                @endif
        </div>
    </div>
</div>
