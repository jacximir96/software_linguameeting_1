<div class="form-group row">
    <div class="col-12 text-600">
        <span class="{{isset($normalText) ? '' : 'fw-bold'}} {{isset($titleFieldform) ? 'title-field-form' : ''}}  mb-2  @error($field) text-danger-disabled.. @enderror ">{{$label}}</span>
    </div>
    <div class="col-12">
        {{Form::select($field, $form->optionsField($optionsField), null,
            [   'class'=>'form-input-'.$field.(isset($customClass) ? ' '.$customClass.' ' : '').' form-control form-select '.(isset($controlXs) ? ' form-control-xs ' : '').' '.($errors->has($field) ? ' is-invalid ' : null),
                isset($id) ? 'id' : '' => isset($id) ? $id : '',
                isset($required) ? 'required' : '' => isset($required) ? 'true' : '',
                isset($disabled) ? 'disabled' : '' => isset($disabled) ? 'true' : '',
                isset($placeholder) ? 'placeholder' : '' => isset($placeholder) ? $placeholder : '',
                isset($multiple) ? 'multiple' : '' => isset($multiple) ? 'true' : '',
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
