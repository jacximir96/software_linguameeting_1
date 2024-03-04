<div class="form-group row">
    <div class="col-12 text-600">
        @if (isset($titleFieldform))
            <span class="title-field-form ">{{$label}}</span>
        @else
            <span class="{{isset($normalText) ? '' : 'fw-bold'}}  mb-2  ">{{$label}}</span>
        @endif
    </div>
    <div class="col-12 input-group">
        {{Form::text($field, '', [
                isset($id) ? 'id' : '' => isset($id) ? $id : '',
                'class' => 'form-control form-control-xs ' .($errors->has($field) ? ' is-invalid ' : null),
                isset($required) ? 'required' : '' => isset($required) ? 'true' : ''
        ])}}

        @error($field)
            <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
