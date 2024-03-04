<div class="row">
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'name', 'label' => 'Name'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'lastname', 'label' => 'Last Name'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.email', ['field' => 'email', 'label' => 'Email'])
    </div>
</div>


<div class="row mt-3">
    <div class="col-sm-4">
        @include('common.form-field.select', [  'field' => 'country_id',
                                                'label' => 'Country',
                                                'optionsField' => 'countryOptions',
                                                'placeholder' => 'Select Country'])
    </div>

    <div class=" col-sm-4">
        @include('common.form-field.select', [  'field' => 'timezone_id',
                                                'label' => 'Time Zone',
                                                'optionsField' => 'timezoneOptions',
                                                'placeholder' => 'Select Time Zone'])
    </div>

    <div class="col-sm-1">
        <div class="col-12">
            <label class=" mb-1 d-block fw-bold" for="flexCheckDefault">Active</label>
            <input type="hidden" name="active" value="0"/>
            {{Form::checkbox('active', 1, null, ['class' => 'form-check-input'])}}
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'phone', 'label' => 'Phone'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'whatsapp', 'label' => 'WhatsApp'])
    </div>
</div>




@include('common.form-field.password_complet')
