<div class="row mt-2">
    <div class="col-12">

        <input type="hidden" name="email_reception" value="0" />
        {{Form::checkbox('email_reception', 1, null, ['class' => 'me-2'])}}

        <span class="mb-2 me-2 fw-bold small">Services comunication</span>
        <span class="small">
                                 (session start/end date, student activity, survey results, or coach feedback, etc.)
                            </span>

        @error('email_reception')
        <span class="custom-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
        @enderror
    </div>


    <div class="col-12 mt-2">

        <input type="hidden" name="email_marketing" value="0" />
        {{Form::checkbox('email_marketing', 1, null, ['class' => 'me-2'])}}

        <span class="mb-2 me-2 fw-bold small">Marketing Communication</span>
        <span class="small">
                                 (new service or products, newsletter, organization highlights, etc.)
                            </span>

        @error('email_marketing')
            <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>
</div>
