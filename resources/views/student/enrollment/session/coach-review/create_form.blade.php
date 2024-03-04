<div class="col-12">

    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'coach-review-form',
           ]) }}

            <div class="row mt-3">

                <div class="col-6 col-md-4 d-flex align-self-center">
                            <span class="bg-corporate-color-light text-corporate-dark-color fw-bold d-block w-100 py-1 ps-1">
                                Tap a star to give a rating
                            </span>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="ratingSession margin_auto" id="ratingSession" style="font-size: 35px"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            {{Form::hidden('rate', null, [
                              'class' => 'rate form-control '.($errors->has('rate') ? ' is-invalid ' : null),
                              'id'=> 'rate'
                          ])}}
                            @error('rate')
                            <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <span class="text-corporate-dark-color">What did you like the most about your coach?</span>
                </div>
            </div>

            <div class="row mt-1">
                @foreach (collect($form->optionsField('reviewOptions'))->chunk(3) AS $options)

                    @foreach ($options as $optionId => $optionName)
                        <div class="col-4 mb-2">
                            <input type="checkbox" name="review_option[]" value="{{$optionId}}" />
                            {{$optionName}}
                        </div>
                    @endforeach
                @endforeach
            </div>

            <div class="row mt-3">
                <div class="col-12">
                            <span class="d-block text-corporate-dark-color">
                                What did you like the most about your coach?
                            </span>
                    @include('common.form-field.textarea', ['label' => '', 'field' => 'comment', 'rows' => 3])
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit">
                        Send
                    </button>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        var options = {
            max_value: 5,
            step_size: 1,
            initial_value: {{old('rate') ?? 5}}
        };
        $(".ratingSession").rate(options);

        jQuery(document).on('submit', '#coach-review-form', function (event) {

            rate = $('#ratingSession').attr('data-rate-value')
            $('#rate').val(rate)

            return true;
        });
    });
</script>
