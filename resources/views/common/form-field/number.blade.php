<div class="form-group row">
    <div class="col-12 text-600">
        @if (isset($titleFieldform))
            <span class="title-field-form ">{{$label}}</span>
        @else
            <span class="{{isset($normalText) ? '' : 'fw-bold'}}  mb-2  ">{{$label}}</span>
        @endif
    </div>
    <div class="col-12">
        {{Form::number($field, null, [   "onkeydown" => "return event.keyCode !== 69",
                                            "class" => 'form-input-'.$field.' form-control '.($errors->has($field) ? ' is-invalid ' : null),
                                            (isset($required) AND $required) ? "required" : "not-required" => (isset($required) AND $required) ? "true" : "",
                                            isset($min) ? "min" : "not-min" => isset($min) ? $min : "",
                                            isset($max) ? "max" : "not-max" => isset($max) ? $max : "",
                                            isset($step) ? "step" : "" => isset($step) ? $step : "",
                                    ])}}
        @error($field)
            <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <span class="custom-invalid-feedback d-none" id="feedback-error-{{$field}}" role="alert">
            <strong></strong>
        </span>
    </div>
</div>

