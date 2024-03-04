<div class="row">
    <div class="col-12 text-600">
        <span class="fw-bold mb-2">Zoom</span>
    </div>
    <div class="col-12">
        {{Form::email('zoom_email', null, ['class' => 'form-control form-control-xs '])}}
        <span class="text-muted small">If you have a zoom account, please introduce the zoom email account</span>
        @error('zoom_email')
        <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
</div>
