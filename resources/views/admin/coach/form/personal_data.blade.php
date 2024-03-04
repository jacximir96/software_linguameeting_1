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
        @include('common.form-field.select', [  'field' => 'role_id',
                                                 'label' => 'Role',
                                                 'optionsField' => 'roleOptions',
                                                 'placeholder' => 'Select Role'])
    </div>

    <div class="col-sm-4">
        @include('common.form-field.select', [  'field' => 'level_id',
                                                'label' => 'Level',
                                                'optionsField' => 'levelOptions',
                                                'placeholder' => 'Select Level'])
    </div>

    <div class="col-sm-2">

        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 fw-bold ">In-training?</span>
            </div>
            <div class="col-12">
                <input type="hidden" name="is_trainee" value="0"/>
                {{Form::checkbox('is_trainee', 1, null, ['class' => 'form-check-input d-block'])}}

                @error('is_trainee')
                <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">

    <div class="col-sm-4">
        <div class="col-12">
            <label class=" mb-1 d-block fw-bold" for="flexCheckDefault">Active</label>
            <input type="hidden" name="active" value="0"/>
            {{Form::checkbox('active', 1, null, ['class' => 'form-check-input'])}}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="col-12">
            <label class=" mb-1 d-block fw-bold" for="flexCheckDefault">Email Verified</label>
            <input type="hidden" name="email_verified" value="0"/>
            {{Form::checkbox('email_verified', 1, null, ['class' => 'form-check-input'])}}

            @if ($coach->hasEmailVerified())
                <span class="small text-muted">
                    {!! toDatetimeInOneRow($coach->email_verified_at)!!}
                </span>
            @endif

        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-4">
        @include('common.form-field.select', [  'field' => 'country_id',
                                                'label' => 'Teaching Language',
                                                'optionsField' => 'countryOptions',
                                                'placeholder' => 'Select Country'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.select', [  'field' => 'country_live_id',
                                                'label' => 'Residence',
                                                'optionsField' => 'countryOptions',
                                                'placeholder' => 'Select Country'])
    </div>
    <div class=" col-sm-4">
        @include('common.form-field.select', [  'field' => 'timezone_id',
                                                'label' => 'Time Zone',
                                                'optionsField' => 'timezoneOptions',
                                                'placeholder' => 'Select Time Zone'])
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'skype', 'label' => 'Skype'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'phone', 'label' => 'Phone'])
    </div>
    <div class="col-sm-4">
        @include('common.form-field.text', ['field' => 'whatsapp', 'label' => 'WhatsApp'])
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-4">
        @include('admin.coach.form.zoom_field')
    </div>

    <div class="col-sm-4">
    </div>

    <div class="col-sm-4">
        @include('admin.instructor.form.language')
    </div>
</div>


<div class="row mt-3">
    <div class="mb-3 col-12">
        @include('common.form-field.textarea', ['field' => 'description',
                                                'label' => 'Description',
                                                'id' => 'ckeditor',
                                                'rows' => 5,
                                                'ckEditor' => 'ckeditor-basic'])


    </div>
</div>

<div class="row mt-3">

    <div class="col-sm-6">

        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 text-corporate-dark-color fw-bold">Coach Photo</span>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-12">
                <div class="row">

                    <div class="col-12 col-md-6 d-flex align-items-center text-center">
                        @if ($form->isEdit())
                            @if ($coach->profileImage)
                                <p>
                                    <a href="{{asset($coach->profileImage->url()->get())}}" target="_blank" title="Show original">
                                        <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid" alt="Imagen" style="max-width: 68%">
                                    </a>
                                </p>
                            @else
                                <p class="text-center">
                                    <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid" alt="Imagen" style="max-width: 40%">
                                    <span class="d-block text-muted small">Without Image</span>
                                </p>
                            @endif
                        @endif
                    </div>

                    <div class="col-12 col-md-6 ">

                        <div class="row">
                            <div class="col-12 text-center">
                                <a onclick="openFileSelector()"
                                   class="button-select-file button bg-corporate-color text-white rounded p-2 fw-bold border-1 border-white">
                                    <i class="fa fa-upload"></i> Upload Photo
                                </a>

                                <input type="file" id="fileInput" onchange="handleFileSelection(this.files)" name="profile_image" class="profile-image d-none" accept="image/*">

                                @error('profile_image')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>


                        @if ($form->isEdit())
                            @if ($coach->profileImage)
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <input type="checkbox" name="delete_profile_image" value="1" class="mt-3"/> Delete Image
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
                <p class="small my-0">
                    Add your photo. The recommended size is 8x8cm (945x945px)
                </p>
            </div>
        </div>
        <div class="row mt-1">
            <a href="#"
               class="text-decoration-underline small text-corporate-dark-color fw-bold"
               data-bs-toggle="modal"
               data-bs-target="#modal-photo-guidelines">
                See guidelines
            </a>

            @include('common.modal_info', [
                'modalId' => 'modal-photo-guidelines',
                'modalTitle' => 'Photo Guidelines',
                'size' => 'modal-lg',
                'path' => 'admin.coach.form.photo_guidelines',
            ])
        </div>
    </div>

    <div class="col-sm-6">


        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 text-corporate-dark-color fw-bold">Coach Video</span>
            </div>
        </div>
        @if ($form->isEdit())
            @if ($coach->coachInfo->url_video)
                <div class="row">
                    <div class="col-12">
                        <iframe src="{{$coach->coachInfo->url_video}}" frameborder="0" allow="encrypted-media" allowfullscreen id="iframeVideo"></iframe>
                    </div>
                </div>
            @endif
        @endif

        <div class="row">
            <div class="col-12">
                {{Form::url('url_video', null, ['class' => 'form-control '])}}

                @error('url_video')
                <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <p class="my-0 small">
                    Add your video. The recommended duration is less than 1 min. 30 sec. (max.)
                </p>

                <p class="my-0">
                    <a href="http://develop.linguameeting.com/documents/manager/guidelines_video_coach.pdf"
                       class="text-decoration-underline small text-corporate-dark-color fw-bold"
                       title="See Guidelines">
                        See guidelines
                    </a>
                </p>
            </div>
        </div>
    </div>

</div>

<div class="row mt-5">
    <div class="mb-3 col-12">
        <div class="form-group row">
            <div class="col-12 text-600">
                <span class=" mb-2 fw-bold ">Hobbies</span>
            </div>
            @foreach ($form->model()['hobbies'] as $hobbyId => $hobbyName)
                <div class="col-12 col-sm-4 mb-2">

                    {{Form::text('hobbies['.$hobbyId.']', null, ['class' => 'form-control form-control-xs'])}}

                </div>
            @endforeach

            @foreach ($form->model()['new_hobbies'] as $hobbyId => $hobbyName)
                <div class="col-12 col-sm-4 mb-2">

                    {{Form::text('new_hobbies['.$hobbyId.']', null, ['class' => 'form-control form-control-xs'])}}

                </div>
            @endforeach
        </div>


    </div>
</div>


@include('common.form-field.password_complet')

<script>
    // Función para abrir el selector de archivos al hacer clic en el botón
    function openFileSelector() {
        document.getElementById('fileInput').click();
    }

    // Función para manejar la selección de archivos
    function handleFileSelection() {
        // Puedes realizar acciones con los archivos seleccionados aquí
        var files = document.getElementById('fileInput').files;
        console.log('Archivos seleccionados:', files);
    }
</script>
