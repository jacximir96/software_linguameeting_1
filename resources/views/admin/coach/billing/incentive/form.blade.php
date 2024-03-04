@extends('layouts.app_modal')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'discount-type-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row mt-3">
                        <div class="col-6">
                            @include('common.form-field.number', ['field' => 'value', 'label' => 'Cost', 'min' => 0, 'step' => '0.01'])
                        </div>

                        <div class="col-6">
                            @include('common.form-field.date', ['field' => 'date', 'label' => 'Date'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="small mb-1 fw-bold @error('type_id') text-danger @enderror" for="type_id">Type</label>
                            <div class="form-group row">
                                <div class="col-12">
                                    {{Form::select('type_id', $form->optionsField('typeOptions'), null,
                                    [   'class'=>'form-control form-select',
                                        'placeholder' => 'Select Type',
                                        'id' => 'type_id',
                                        ])}}
                                    @error('type_id')
                                    <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">

                            <div class="row">

                                <div class="col-12 text-600">
                                    <span class="fw-bold ">Frequency</span>
                                </div>
                                @foreach ($form->frequencies() as $frequency)
                                    <div class="col-12 mt-2">
                                        {{Form::radio('frequency_id', $frequency->id, null, [])}} {{$frequency->name}}
                                    </div>
                                @endforeach

                                @error('frequency_id')
                                    <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.textarea', ['field' => 'comments', 'label' => 'Comments',  'rows' => 3])
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                {{$form->isCreate() ? 'Create' : 'Update'}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
@endsection
