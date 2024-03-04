<div class="row mt-2">
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.email', ['field' => 'email', 'label' => 'Email'])
    </div>

    @if (isset($withZoom))
        <div class="col-sm-6 col-lg-4 col-xl-3">
            @include('user.profile.fields.zoom')
        </div>
    @endif
</div>


<div class="row mt-3">
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.text', ['field' => 'phone', 'label' => 'Phone'])
    </div>
    <div class="col-sm-6 col-lg-4 col-xl-3">
        @include('common.form-field.text', ['field' => 'whatsapp', 'label' => 'Phone - WhatsApp'])
    </div>
</div>
