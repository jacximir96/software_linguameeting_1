<div class="form-group row">
    <div class="col-12 text-600 ">
        @if (isset($titleFieldform))
            <span class="title-field-form ">{{$label}}</span>
        @else
            <span class="{{isset($normalText) ? '' : 'fw-bold'}}  mb-2  ">{{$label}}</span>
        @endif
    </div>
    @if (isset($textoExplicativo))
        <div class="col-12 ">
            {!! $textoExplicativo !!}
        </div>

    @endif
    <div class="col-12">
        {{Form::time($field, null, ['class' => 'form-control '. ($errors->has($field) ? 'is-invalid' : null),
                                        isset($required) ? 'required' : '' => isset($required) ? 'true' : '',

                                        ])}}

        @error($field)
        <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
