{{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'discount-type-form',
           ]) }}

<div class="row">

    <div class="col-12 col-xl-6">

        <div class="row mt-3">

            <div class="col-sm-4">
                <label class="small fw-bold @error('month') text-danger @enderror" for="month">Month</label>
                <div class="form-group row">
                    <div class="col-12">
                        {{Form::select('month', $form->optionsField('monthsOptions'), null,
                        [   'class'=>'form-control form-select',
                            'placeholder' => 'Select Month',
                            'id' => 'month',
                            ])}}
                        @error('month')
                            <span class="custom-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-4">
                @include('common.form-field.number', ['field' => 'year', 'label' => 'Year', 'min' => 2015, 'max' => date('Y'), 'step' => '1'])
            </div>

            <div class="col-12 col-sm-4 d-flex align-items-end">
                <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                    Show Billing
                </button>
            </div>
        </div>
    </div>
</div>

{{Form::close()}}
