<div class="row">

    <div class="col-12 text-600">
        <span class="fw-bold mb-2 small">Language</span>
    </div>
    <div class="col-12 mt-1 {{($errors->has('language') ? ' is-invalid ' : null)}}">
        <div class="form-group row ">
            @foreach ($form->optionsField('languageOptions') as $key => $lang)
                <div class="col-sm-6">
                    @include('common.form-field.checkbox', ['field' => 'language[]', 'value' => $key, 'label' => $lang])
                </div>
            @endforeach
        </div>

        <div class="mt-1">
            <a href="#" class="check-all small me-2" title="Check all language" data-target-class="check-language">
                all
            </a>

            <a href="#" class="uncheck-all small" title="Check all language" data-target-class="check-language">
                none
            </a>
        </div>
        @error('language')
        <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
