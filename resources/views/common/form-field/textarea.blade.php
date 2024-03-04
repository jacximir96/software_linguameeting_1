<div class="form-group row">
    <div class="col-12 text-600">
        @if (isset($titleFieldform))
            <span class="title-field-form ">{{$label}}</span>
        @else
            <span class="{{isset($normalText) ? '' : 'fw-bold'}}  mb-2  ">{{$label}}</span>
        @endif
    </div>
    <div class="col-12 {{$errors->has($field) ? ' div-invalid ' : ' '}}">
        {{Form::textarea($field,  null, [   'class'=>'form-control ' .(isset($ckEditor) ? $ckEditor : ''),
                                            'id' => isset($id) ? $id : $field,
                                            'data-height' => isset($ckEditorHeight) ? $ckEditorHeight : '120px',
                                            'rows' => isset($rows) ? $rows : 4,
                                            'style' => isset($style) ? $style : '',
                                        ])}}
        @error($field)
        <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<?php

/*
 * ckEditor
 * ckeditor-basic
 *
 */

?>
