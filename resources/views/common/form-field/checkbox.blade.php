<div class="form-group row">
    <div class="col-12">
        {{Form::checkbox($field, $value, null, ['class' => 'check-language'])}}
        <span class="mb-2 {{isset($boldLabel) ? 'fw-bold' : ''}}">{{$label}}</span>
        @error($field)
        <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @if (isset($description))
            <span class="text-muted small d-block">{{$description}}</span>
        @endif
    </div>
</div>
