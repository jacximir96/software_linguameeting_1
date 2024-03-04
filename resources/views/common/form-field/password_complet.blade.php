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
