<div class="row mt-2">
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.text', ['field' => 'name', 'label' => 'First Name'])
    </div>
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.text', ['field' => 'lastname', 'label' => 'Last name'])
    </div>

</div>


<div class="row mt-3">
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.select', [  'field' => 'country_id',
                                                'label' => 'Where are you from?',
                                                'optionsField' => 'countryOptions',
                                                'placeholder' => 'Select Country'])
    </div>
    