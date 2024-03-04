<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>

    <section>

        <div class="paddingSection">

            <div class="row">

                <div class="col-lg-6 padding20">

                    <div class="margin-top60 colorBase1 w500 text_center">
                        LET'S GET STARTED
                    </div>

                    <div class="colorBase1 fontRecoleta text-72 text_center">
                       Create an <br>Account

                    </div>

                    <div class="text_center colorBase1 w500">
                        Whether you have a question about features, trials, pricing, need a demo, or anything else, <strong>our team is ready to answer all your questions</strong>.
                    </div>

                </div>


                <div class="col-lg-6 padding20">


                    <div class="margin-top60 colorBase1 w500 text_center">
                        SELECT ONE
                    </div>

                    <div class="text_center colorBase1 text-32">
                        <div class="btn-group borderBottomText2">
                            <div class="text_center colorBase2" id="changeNameContact" value="Student">Select your profile</div>


                            <div class="cursor_pointer colorBase2 w300 marginArrowContact" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Instructor');">Instructor</div>
                                <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Student');">Student</div>
                            </div>
                        </div>
                    </div>

                    <div id="formStudent" class="{{old('code') ? '' : 'notDisplay'}}">

                        @if (old('code'))
                            <script>
                                changeNameContact('Student')
                            </script>
                        @endif

                        <form method="POST" action="{{ route('post.public.register.student.code') }}">
                            @csrf

                            <div class="margin-top60">
                                <input type="text" name="code" id="code" class="inputTextRegister {{ $errors->has('code') ? 'is-invalid' : ''}}" placeholder="Class ID" required autofocus>
                            </div>

                            @error('code')
                            <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input type="hidden" name="type" value="student" />

                            <div class="text_center">
                                <button type="submit" class="btnBasicRed textBtnLearnMore margin-top40 w600" onclick="doStep2()">Register</button>
                            </div>

                        </form>
                    </div>

                    <div id="formInstructor" class="notDisplay">

                        {{ Form::model($instructorForm->model(),  [
                             'class' => '',
                             'url'=> $instructorForm->action(),
                             'autocomplete' => 'off',
                             'id' =>'create-instructor-form',

                             ]) }}

                        <div class="margin-top60">
                            {{Form::text('name', null, [
                                    'id' => 'name',
                                    'placeholder' => 'First Name',
                                    'class' => 'inputTextRegister ' .($errors->has('name') ? ' is-invalid ' : null),

                            ])}}
                            @error('name')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="margin-top40">
                            {{Form::text('lastname', null, ['class' => 'inputTextRegister ' .($errors->has('lastname') ? ' is-invalid ' : null), 'placeholder' => 'Last Name'])}}
                            @error('lastname')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="margin-top40">
                            {{Form::email('email', null, ['class' => 'inputTextRegister '.($errors->has('email') ? ' is-invalid ' : null), 'placeholder' => 'Email Address'])}}
                            @error('email')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="margin-top40">
                            {{Form::text('password', null, [
                                            'class' => 'inputTextRegisterPassword ' .($errors->has('password') ? ' is-invalid ' : null),
                                            'id' => 'password',
                                            'placeholder' => 'Password'])}}
                            <i class="fas fa-info-circle colorBase1 cursor_pointer" onclick="modalVideo('password')"></i>
                            @error('password')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="margin-top10">
                            <a href="{{route('get.public.password.generate')}}" class="fst-italic small d-inline-block mr-5" id="generate_password">Generate</a>

                            <a href="#" class="text-primary show-hide-password small d-inline-block" id="basic-addon1">
                                Hide
                            </a>
                        </div>

                        <div class="margin-top40">
                            <input type="text" name="password_confirmation" id="password_confirmation" tabindex="2" class="inputTextRegisterPassword" placeholder="Confirm Password" >
                        </div>

                        <div class="margin-top40">
                            {{Form::select('country_id', $instructorForm->optionsField ('countriesOptions'),null, [
                                               'placeholder' => 'Select Your Country',
                                               'id' => 'country-id',
                                               'name' => 'country_id',
                                               'class' => 'inputTextRegister event_create_uni '.($errors->has('country_id') ? ' is-invalid ' : null)])}}
                            @error('country_id')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="margin-top40">

                            <div class="widthAll">

                                <div class="float_left divFormWidth">
                                    {{Form::select('university_id', $instructorForm->optionsField ('universitiesOptions'),null, [
                                                'placeholder' => 'Select Your University',
                                                'id' => 'university-id',
                                                'class' => 'inputTextRegister event_create_uni '.($errors->has('university_id') ? ' is-invalid ' : null)])}}
                                        @error('university_id')
                                            <span class="invalid-feedback" >
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="float_left margin-left10 divFormWidthBtn">
                                    <button type="button" id="registerButton" class="btn backgroundColor35b4b4 colorWhite" onclick="modalUniversity()">
                                        <span>Add New</span>&nbsp;&nbsp;
                                        <span class="btn-group-addon"><i class="fas fa-plus"></i></span>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="padding-top40 clear_both">
                            {{Form::select('timezone_id', $instructorForm->optionsField ('timezonesOptions'),null, [
                                               'placeholder' => 'Select Your Time Zone',
                                               'id' => 'timezone-id',
                                               'class' => 'inputTextRegister '.($errors->has('timezone_id') ? ' is-invalid ' : null)])}}
                            @error('timezone_id')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="margin-top40">
                            <select name="rol_id" class="inputTextRegister {{$errors->has('rol_id') ? ' is-invalid ' : null}}" id="rol-id">
                                <option value="" selected>Select Your Role</option>
                                <option value="4">Coordinator</option>
                                <option value="3">Course Manager</option>
                                <option value="5">Instructor</option>
                            </select>
                            @error('rol_id')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="margin-top40">
                            <div class="widthAll">
                                <div class="float_left divFormWidth">
                                    {{Form::select('language_id', $instructorForm->optionsField ('languagesOptions'),null, [
                                               'placeholder' => 'Select Your Language',
                                               'id' => 'language_id',
                                               'class' => 'inputTextRegister event_create_language ' .($errors->has('language_id') ? ' is-invalid ' : null)])}}
                                    @error('language_id')
                                        <span class="invalid-feedback" >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>


                        <div class="padding-top40 clear_both">
                            <input type="checkbox" name="check_terms" id="accept-terms" class="{{$errors->has('check_terms') ? ' is-invalid ' : null}}"/>
                            <label class="margin-top10"><a href="https://www.linguameeting.com/terms" class="colorBase1 w500" target="_blank">Accept Terms and Conditions</a></label>
                            @error('check_terms')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text_center">
                            <button class="btnBasicRed textBtnLearnMore margin-top40 w600" onclick="modalRegisterForm()" >Register</button>
                        </div>

                        <input type="hidden" name="type" value="instructor" />

                        {{Form::close()}}

                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

</main>



<div id="modal_university" class="hidden-print modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="color4 text-20 margin-top20">
                    <strong>Add New University</strong>
                </div>
                <div id="registerInst-form">

                    <input type="hidden" id="create-university-action" value="{{route('post.public.register.university.create')}}" />

                    <div class="form-group margin-top20 ">
                        <label for="name_university">Name *</label>
                        <input type="text" name="name_university" id="name-university" class="form-control input-lg" placeholder="University Name" value="Aaa univer">
                    </div>

                    <div  class="form-group">
                        <label for="university_country_id">Select University Country *</label>
                        {{Form::select('university_country_id', $instructorForm->optionsField ('countriesOptions'),null, [
                                             'placeholder' => 'Select',
                                             'id' => 'university-country-id',
                                             'class' => 'form-control '.($errors->has('university_country_id') ? ' is-invalid ' : null)])}}
                    </div>

                    <div  class="form-group">
                        <label for="university_timezone_id">Select University Time Zone *</label>
                        {{Form::select('university_timezone_id', $instructorForm->optionsField ('timezonesOptions'),null, [
                                               'placeholder' => 'Select',
                                               'id' => 'university-timezone-id',
                                               'class' => 'form-control'.($errors->has('university_timezone_id') ? ' is-invalid ' : null)])}}
                    </div>

                    <div id="messageUniversity" class="colorBase4">

                    </div>

                </div>
            </div>
            <div class="modal-footer modal-footer-uni">
                <button type="button" class="btn background_colorAAAAAA colorWhite " data-dismiss="modal">Close</button>
                <button type="button" id="add-university-button" class="btn backgroundColor35b4b4 colorWhite add-university-button">Add</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_videopassword" class="hidden-print modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">

                @include('common.web.password')

            </div>
            <div class="modal-footer modal-footer-uni">
                <button type="button" class="btn background_colorAAAAAA colorWhite" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

@include('common.web.footer')

<script>

    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});


        jQuery(document).on('click', '.show-hide-password', function (event) {

            event.preventDefault();

            showOrHidePasswordContent(jQuery(this), 'password')
            showOrHidePasswordContent(jQuery(this), 'password_confirmation')
        });

        function showOrHidePasswordContent (element, passwordFieldId){

            var fieldPassword = jQuery('#'+passwordFieldId);

            if (fieldPassword.attr('type') == "password") {

                fieldPassword.removeAttr("type");
                fieldPassword.attr("type","text");

                element.html('Hide')

            } else {

                fieldPassword.removeAttr("type");
                fieldPassword.attr('type','password');

                element.html('Show')
            }
        }

        @if ($showInstructorForm)
        changeNameContact('Instructor')

        @endif


        jQuery(document).on('click', '.add-university-button', function (event) {

            event.preventDefault();
            //clean warning div
            $('#messageUniversity').html('')

            var universityName = document.getElementById("name-university").value;

            if (universityName === "") {
                alert("University name is required.");
                return;
            }

            var countryUniversityId = document.getElementById("university-country-id").value;
            if (countryUniversityId === "") {
                alert("University Country name is required.");
                return;
            }

            var universityTimezoneId = document.getElementById("university-timezone-id").value;
            if (universityTimezoneId === "") {
                alert("University Time Zone is required.");
                return;
            }

            var action = document.getElementById('create-university-action').value;

            console.log(action)

            jQuery.ajax({
                context: this,
                url: action,
                type:"POST",
                data: {'university_name':  universityName,'country_university_id':countryUniversityId, 'university_timezone_id':universityTimezoneId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success:function(response, data){

                    var dropdown = document.getElementById("university-id");

                    //proceso para añadir y reordenar opciones
                    var opciones = Array.from(dropdown.options);

                    // Agregar la nueva opción al array
                    opciones.push(new Option(response.name, response.id));

                    // Ordenar el array alfabéticamente basándose en el texto de las opciones
                    opciones.sort(function(a, b) {
                        return a.text.localeCompare(b.text);
                    });

                    // Borrar y agregar
                    dropdown.innerHTML = "";
                    // Agregar las opciones ordenadas al desplegable
                    opciones.forEach(function(opcion) {
                        dropdown.add(opcion);
                    });


                },
                error: function(response, textStatus, xhr) {

                    if (response.status == 422) {
                        $('#messageUniversity').html('Error while creating university. Data incorrect.')
                    }
                    else if (response.status != 422){
                        $('#messageUniversity').html('Error while creating university.')
                    }
                },
                statusCode: {

                    422: function (data){
                        jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                            $('#messageUniversity').html('Error while creating university.')
                        })
                    }
                }
            });


        });
    });
</script>

</body>
</html>
