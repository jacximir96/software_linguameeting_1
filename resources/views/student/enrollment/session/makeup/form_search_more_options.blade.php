<div class="row gx-0" id="div-title-more-options">
    <span class="d-block fw-bold bg-corporate-color text-white p-1 rounded">
        If these times do not work for you, please click here to find more options.
    </span>
</div>
{{ Form::model($searchCoachForm->model(),  [
           'class' => '',
           'url'=> $searchCoachForm->action(),
           'autocomplete' => 'off',
           'id' =>'search-availability',
           ]) }}
<div class="row mt-2">
    <div class="col-12 col-md-4">
        <label class="fw-bold d-block">Date</label>
        <div class="input-group">
            {{Form::text("dateSession", null, ['class' => 'form-control input-datepicker '.($errors->has('dateSession') ? ' is-invalid ' : ''), 'disabled' => true,'id' => 'dateSession',])}}
            <span class="input-group-text icon-calendar"><i class="fa fa-calendar"></i></span>
            @error('dateSession')
                <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        @include('common.form-field.select', [  'field' => 'time_id',
                                                'id' => 'timeId',
                                                'form' => $searchCoachForm,
                                                'label' => 'Time',
                                                'optionsField' => 'timeOptions',
                                                'disabled' => true,
                                                'placeholder' => 'Select Time'])
    </div>

    <div class="col-6 col-md-4">
        @include('common.form-field.text', ['field' => 'coach',
                                            'disabled' => true,
                                            'id' => 'coach',
                                            'label' => 'Coach\'s first name (Optional)'])
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit">
            Search Session
        </button>
    </div>
</div>

{{Form::close()}}
