<div class="row">
    <div class="col-sm-6">
        @include('common.form-field.text', ['field' => 'name', 'label' => 'Name'])
    </div>
    <div class="col-sm-6">
        @include('common.form-field.text', ['field' => 'lastname', 'label' => 'Last Name'])
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm-6">
        @include('common.form-field.email', ['field' => 'email', 'label' => 'Email'])
    </div>
    <div class="col-sm-3">


            <label class="small mb-1 d-block fw-bold" for="flexCheckDefault">Active</label>
            <input type="hidden" name="active" value="0"/>
            {{Form::checkbox('active', 1, null, ['class' => 'form-check-input'])}}

    </div>

    <div class="col-sm-3">

            <label class=" mb-1 d-block fw-bold" for="flexCheckDefault">Email Verified</label>
            <input type="hidden" name="email_verified" value="0"/>
            {{Form::checkbox('email_verified', 1, null, ['class' => 'form-check-input'])}}

            @if ( ! $form->isCreate())
                @if ($instructor->hasEmailVerified())
                    <span class="small text-muted">
                        {!! toDatetimeInOneRow($instructor->email_verified_at, $timezone->name, true)!!}
                    </span>
                @endif
            @endif


    </div>

</div>
<div class="row mt-3">
    <div class="col-sm-6">
        @include('common.form-field.select', [  'field' => 'country_id',
                                                'label' => 'Country',
                                                'optionsField' => 'countryOptions',
                                                'placeholder' => 'Select Country'])
    </div>
    <div class=" col-sm-6">
        @include('common.form-field.select', [  'field' => 'timezone_id',
                                                'label' => 'Time Zone',
                                                'optionsField' => 'timezoneOptions',
                                                'placeholder' => 'Select Time Zone'])
    </div>
</div>
<div class="row mt-3">

    @if ($form->isCreate())
        <div class="col-sm-6">
            @include('common.form-field.select', [  'field' => 'university_id',
                                                     'label' => 'University',
                                                     'optionsField' => 'universityOptions',
                                                     'placeholder' => 'Select University'])
        </div>
    @endif

    <div class="col-sm-6">
        @include('common.form-field.select', [  'field' => 'role_id',
                                                 'label' => 'Role',
                                                 'optionsField' => 'roleOptions',
                                                 'placeholder' => 'Select Role'])
    </div>

    @if ($form->isEdit())
        <div class="col-sm-6">
            @include('admin.instructor.form.language')
        </div>
    @endif
</div>

@if ($form->isCreate())
    <div class="row mt-3">
        <div class="col-6">
            @include('admin.instructor.form.language')
        </div>
    </div>

@endif

<div class="row mt-3">
    <div class="col-sm-6">
        @include('common.form-field.password', ['field' => 'password', 'label' => 'Password', 'id' => 'password'])

        <div class="d-flex justify-content-between">
            <a href="{{route('get.public.password.generate')}}" class="fst-italic small" id="generate_password">Generate</a>

            <a href="#" class="text-primary show-hide-password small" id="basic-addon1">
                Hide
            </a>
        </div>
    </div>

    <div class="col-sm-6 mt-2 mt-sm-0">
        @include('common.form-field.password', ['field' => 'password_confirmation', 'label' => 'Password confirmation', 'id' => 'password_confirmation'])
    </div>

</div>

<div class="row mt-0">
    <div class="col-12">
        <span class="text-muted" style="font-size: 0.8rem">    Your password must contain the following:
            <ul class="mb-0">
                <li>At length of at least six characters.</li>
                <li>At least one lowercase character.</li>
                <li>At least one uppercase character.</li>
                <li>At least one number.</li>
                <li>At least one special character: @ # $ % &amp; + ! = ?</li>
            </ul>
        </span>
    </div>
</div>


<div class="row mt-3">
    <div class="mb-3 col-12">
        @include('common.form-field.textarea', ['field' => 'internal_comment', 'label' => 'Comment', 'rows' => 3])
    </div>
</div>
