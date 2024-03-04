{{ Form::model($accommodationForm->model(),  [
    'class' => 'user',
    'url'=> $accommodationForm->action(),
    'autocomplete' => 'off',
    'id' =>'update-accommodation-form'
    ]) }}

<div class="row">
    <div class="col-12 float-start pt-2 pe-2">
        Accommodations
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="float-start pe-2">
            {{Form::select('accommodation_type_id', $accommodationForm->optionsField('accommodationsTypesOptions'), null,
                                   [   'class'=>'form-input-select form-control form-select',
                                       'placeholder' => 'Select Accommodation Type ',
                                       'id' => 'accommodation-type-id',
                                       ])}}
        </div>
    </div>
</div>

<div class="row mt-2 float-none">
    <div class="col-md-8">
        {{Form::textarea('description', null, [
                     'class' => 'form-control',
                     'rows' => 2,
                     'id'=> 'description',
                     'placeholder' => 'Type a description...'
                 ])}}
    </div>
    <div class="col-md-4">
        <button type="submit" id="button-update-accommodation" class="btn bg-text-corporate-color btn-bold form-control-xs px-4 me-3 colorWhite" value="Save">
            Save
        </button>

        <button  id="button-delete-accommodation" class="btn bg-corporate-danger btn-bold form-control-xs px-4 colorWhite" value="Delete"
                 onclick="return confirm('Are you sure you want to delete this accommodation info?');"
        >
            Delete
        </button>
    </div>
</div>

{{Form::close()}}

<script>

    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        $('#button-update-accommodation').on('click', function(e) {

            e.preventDefault();

            if ($('#accommodation-type-id').val() == ''){
                alert('Accommodation type is required');
                return;
            }

            var formData = $('#update-accommodation-form').serialize();

            $.ajax({
                type: 'POST',
                url: '{{route('post.instructor.api.students.accommodation.update', $enrollment->hashId())}}',
                data: formData,
                success: function(response) {

                    $.notify("Accommodation updated successfully.", {
                        className: "success",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                },
                error: function(xhr, status, error) {

                    $.notify(xhr.responseText, {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            });
        });

        $('#button-delete-accommodation').on('click', function(e) {

            e.preventDefault();

            $.ajax({
                type: 'GET',
                url: '{{route('get.instructor.api.students.accommodation.delete', $enrollment->hashId())}}',
                success: function(response) {

                    jQuery('#accommodation-type-id').val('');
                    jQuery('#description').val('');

                    $.notify("Accommodation deleted successfully.", {
                        className: "success",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });


                },
                error: function(xhr, status, error) {

                    $.notify(xhr.responseText, {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            });
        });
    });
</script>
