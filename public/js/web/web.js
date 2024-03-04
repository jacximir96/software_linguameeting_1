

$(document).ready(function () {

    // --- view more (coaches.html)
    $('#view-more').unbind('click');
    $('#view-more').click(function () {
        $("#coach-more").slideToggle("slow", function () {

        });

    });

    // --- Events FAQ
    $('.eventFaq').each(function () {
        var id_faq = $(this).attr('id-faq');

        $(this).unbind('click');
        $(this).click(function () {
            $("#responseFaq" + id_faq).slideToggle("slow", function () {

            });
        });
    });

    // --- Events ISSUES
    $('.eventIssue').each(function () {
        var id_faq = $(this).attr('id-issue');

        $(this).unbind('click');
        $(this).click(function () {
            $("#responseIssue" + id_faq).slideToggle("slow", function () {

            });
        });
    });


    // carousel time
    $('#slider-students').carousel({
        interval: 2000
    });

    $('.event-select').unbind('click');
    $('.event-select').click(function () {

        $('.event-select').each(function () {

            $(this).removeClass('background_color7');
            $(this).removeClass('event-select-coach-session');
            $(this).addClass('background_avail');


        });

        $(this).removeClass('background_avail');
        $(this).removeClass('backgroundColor007aa5');
        $(this).addClass('background_color7');
        $(this).addClass('event-select-coach-session');
    });

    $("#email").on('paste', function (e) {
        e.preventDefault();
        //alert('Esta acción está prohibida');
    });

    $("#email").on('copy', function (e) {
        e.preventDefault();
        //alert('Esta acción está prohibida');
    });

    $("#emailRepeat").on('paste', function (e) {
        e.preventDefault();
        //alert('Esta acción está prohibida');
    });

    $("#emailRepeat").on('copy', function (e) {
        e.preventDefault();
        //alert('Esta acción está prohibida');
    });
    
    var options = {
        max_value: 5,
        step_size: 1,
        initial_value: 5
    };
    $(".ratingExperience").rate(options);

    $(".centerCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 3,
        autoplay: false

    });

    $(".centerCarouselMedia").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: false

    });

    $(".universitiesCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false

    });

    $(".universitiesCarouselMedia").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false

    });

    $(".testimonialsCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 7000

    });

    $(".testimonialsInstCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 7000

    });

    $(".experiencesHomeCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: '<i class="fas fa-chevron-left colorBase2 arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase2 arrowSliderRightTest cursor_pointer"></i>'

    });

    $(".experiencesHomeCarouselMedia").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: '<i class="fas fa-chevron-left colorBase2 arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase2 arrowSliderRightTest cursor_pointer"></i>'

    });

    $(".instHIWCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: '<i class="fas fa-chevron-left colorBase2 arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase2 arrowSliderRightTest cursor_pointer"></i>'

    });

    $('#selectNumber').change(function () {

        var params = new Object();
        params.type = $('#selectType').val();
        params.duration = $('#selectDuration').val();
        params.number = $('#selectNumber').val();
        params.controller = 'webController';
        params.function = 'searchPricing';
        params.experiences = 0;

        if ($('#unlimetedExperiences').is(':checked')) {
            params.experiences = 1;
        }

        if (params.type == 0 || params.duration == 0 || params.number == 0) {

            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');

            if (params.type == 0) {

                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');

            } else {
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }

            if (params.duration == 0) {

                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');

            } else {
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }

            if (params.number == 0) {

                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');

            } else {
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }

        } else {

            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');


            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                $('#resultPricingSearch').empty();
                if (Data.resultado == '') {

                    $('#resultPricingSearch').html('This session package does not exist.');
                }
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });

        }


    });

    $('#selectDuration').change(function () {

        var params = new Object();
        params.type = $('#selectType').val();
        params.duration = $('#selectDuration').val();
        params.number = $('#selectNumber').val();
        params.controller = 'webController';
        params.function = 'searchPricing';
        params.experiences = 0;

        if ($('#unlimetedExperiences').is(':checked')) {
            params.experiences = 1;
        }

        if (params.type == 0 || params.duration == 0 || params.number == 0) {

            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');
            if (params.type == 0) {

                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');

            } else {
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }

            if (params.duration == 0) {

                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');

            } else {
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }

            if (params.number == 0) {

                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');

            } else {
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }

        } else {

            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');

            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                $('#resultPricingSearch').empty();
                if (Data.resultado == '') {

                    $('#resultPricingSearch').html('This session package does not exist.');
                }
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });

        }


    });

    $('#selectType').change(function () {

        var params = new Object();
        params.type = $('#selectType').val();
        params.duration = $('#selectDuration').val();
        params.number = $('#selectNumber').val();
        params.controller = 'webController';
        params.function = 'searchPricing';
        params.experiences = 0;

        if ($('#unlimetedExperiences').is(':checked')) {
            params.experiences = 1;
        }

        if (params.type == 0 || params.duration == 0 || params.number == 0) {

            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');
            if (params.type == 0) {

                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');

            } else {
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }

            if (params.duration == 0) {

                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');

            } else {
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }

            if (params.number == 0) {

                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');

            } else {
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }

        } else {

            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');

            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                $('#resultPricingSearch').empty();
                if (Data.resultado == '') {

                    $('#resultPricingSearch').html('This session package does not exist.');
                }


                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });

        }


    });

    $('#unlimetedExperiences').change(function () {

        var params = new Object();
        params.type = $('#selectType').val();
        params.duration = $('#selectDuration').val();
        params.number = $('#selectNumber').val();
        params.controller = 'webController';
        params.function = 'searchPricing';
        params.experiences = 0;

        if ($('#unlimetedExperiences').is(':checked')) {
            params.experiences = 1;
        }

        if (params.type == 0 || params.duration == 0 || params.number == 0) {

            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)')

        } else {



            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                $('#resultPricingSearch').empty();
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });

        }


    });


});


validarFormulario = function (data, tipo) {

    var resultado = true;

    if (tipo == 'linguameeting') {

        if (data.nombre != '' && data.apellidos != '' && data.dni != '' && data.fecha_nac != '' && data.lugar_nac != '' && data.sexo != '' && data.domicilio != ''
                && data.poblacion != '' && data.provincia != '' && data.cp != '') {

            resultado = true;

            if (data.email != '') {

                resultado = validarEmail(data.email);

            }


        } else {
            resultado = false;
        }

    } else if (tipo == 'registerCoach') {

        if (data.username != '' && data.lastname != '' && data.email != '' && data.password != '' && data.confirmpassword != '' && data.time_zone != 0 && data.country != 0) {

            resultado = true;

            if (data.email != '') {

                resultado = validarEmail(data.email);

            }


        } else {
            resultado = false;
        }

    } else if (tipo == 'registerStudent') {

        if (data.userLingro == 1 || data.userCanvas == 1) {

            if (data.username != '' && data.lastname != '' && data.email != '' && data.emailRepeat != '' && data.terms != '' && data.payment != '') {

                resultado = true;

                if (data.email == data.emailRepeat) {
                    if (data.email != '') {

                        resultado = validarEmail(data.email);

                    } else if (data.emailRepeat != '') {
                        resultado = validarEmail(data.emailRepeat);
                    }
                }


            } else {
                resultado = false;
            }

        } else {

            if (data.username != '' && data.lastname != '' && data.email != '' && data.emailRepeat != '' && data.password != '' && data.confirmPassword != '' && data.terms != '' && data.payment != '') {

                resultado = true;

                if (data.email == data.emailRepeat) {
                    if (data.email != '') {

                        resultado = validarEmail(data.email);

                    } else if (data.emailRepeat != '') {
                        resultado = validarEmail(data.emailRepeat);
                    }
                } else if (data.password != data.confirmPassword) {
                    resultado = false;
                }


            } else {
                resultado = false;
            }
        }



    } else if (tipo == 'form_profile') {

        if (data.username != '' && data.lastname != '' && data.email != '' && data.time_zone != 0 && data.country != 0) {

            resultado = true;

            if (data.email != '') {

                resultado = validarEmail(data.email);

            }


        } else {
            resultado = false;
        }

    } else if (tipo == 'form_message') {

        if ((data.senders.length > 0 || data.university != 0) && data.message != '') {
            resultado = true;
        } else {
            resultado = false;
        }

    } else if (tipo == 'forgotPassword') {

        if (data.email != '') {

            resultado = true;
            resultado = validarEmail(data.email);

        } else {
            resultado = false;
        }

    } else if (tipo == 'registerStudentPanel') {

        if (data.terms != '' && data.payment != '') {

            resultado = true;

        } else {
            resultado = false;
        }

    }

    return resultado;

};

validarEmail = function (sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
};



datepicker_session_flex = function (id, date_ini, date_end) {

    var aux_date_ini = 0;
    var aux_date_end = 365;

    if (date_ini != '') {
        aux_date_ini = date_ini;
    }

    if (date_end != '') {

        aux_date_end = date_end;
    }

    $("#dateSession" + id).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: "yy-mm-dd",
        numberOfMonths: 1,
        minDate: aux_date_ini,
        maxDate: aux_date_end,
        firstDay: 1
    });

    $("#dateSession" + id).datepicker("show");

};


modalVideo = function (id) {

    $('#modal_video' + id).modal('show');

};

modalViewMoreExp = function (id) {

    $('#modal_viewMoreExp').modal('show');

};

modalText = function (id) {

    $('#modal_view' + id).modal('show');

};

changeArrow = function (id) {


    var ele = $('.' + id);


    ele.find('[data-fa-i2svg]')
            .toggleClass('fa-chevron-down')
            .toggleClass('fa-angle-right');


    /*if (ele.hasClass('fa-chevron-down')) {
     ele.removeClass('fa-chevron-down').addClass('fa-chevron-up');
     } else {
     ele.addClass('fa-chevron-down').removeClass('fa-chevron-up');
     }*/


};

changeCaseStudyHIW = function (type) {

    if (type == "Crystal") {

        $('#CaseStudyCrystal').css('display', 'block');
        $('#CaseStudyKate').css('display', 'none');

    } else if (type == "Kate") {

        $('#CaseStudyKate').css('display', 'block');
        $('#CaseStudyCrystal').css('display', 'none');
    } else if (type == "CrystalMedia") {

        $('#CaseStudyCrystalMedia').css('display', 'block');
        $('#CaseStudyKateMedia').css('display', 'none');
    } else if (type == "KateMedia") {

        $('#CaseStudyKateMedia').css('display', 'block');
        $('#CaseStudyCrystalMedia').css('display', 'none');
    }

};

changeStepStudent = function (step) {

    if (step == "step1") {

        $('.StepHIWStudent1').css('display', 'block');
        $('.watchVideo').css('display', 'block');
        $('.StepHIWStudent2').css('display', 'none');
        $('.StepHIWStudent3').css('display', 'none');

    } else if (step == "step2") {

        $('.StepHIWStudent2').css('display', 'block');
        $('.StepHIWStudent1').css('display', 'none');
        $('.watchVideo').css('display', 'none');
        $('.StepHIWStudent3').css('display', 'none');
    } else if (step == "step3") {

        $('.StepHIWStudent3').css('display', 'block');
        $('.StepHIWStudent1').css('display', 'none');
        $('.watchVideo').css('display', 'none');
        $('.StepHIWStudent2').css('display', 'none');
    }

};

changeNameContact = function (name) {

    $('#changeNameContact').empty();

    switch (name) {

        case 'Professor':
            $('#changeNameContact').html("I'm a Professor");
            $('#changeNameContact').attr('value', 'Professor');
            break;

        case 'Instructor':
            $('#changeNameContact').html("I'm an Instructor");
            $('#changeNameContact').attr('value', 'Instructor');
            $('#formInstructor').removeClass('notDisplay');
            $('#formStudent').addClass('notDisplay');
            $('#envelopeInstructorSupport').removeClass('notDisplay');
            $('#envelopeStudentSupport').addClass('notDisplay');
            break;

        case 'DepartmentChair':
            $('#changeNameContact').html("I'm a Department Chair");
            $('#changeNameContact').attr('value', 'DepartmentChair');
            break;

        case 'CourseCoordinator':
            $('#changeNameContact').html("I'm a Course Coordinator");
            $('#changeNameContact').attr('value', 'CourseCoordinator');
            break;

        case 'Student':
            $('#changeNameContact').html("I'm a Student");
            $('#changeNameContact').attr('value', 'Student');
            $('#formStudent').removeClass('notDisplay');
            $('#formInstructor').addClass('notDisplay');
            $('#envelopeInstructorSupport').addClass('notDisplay');
            $('#envelopeStudentSupport').removeClass('notDisplay');
            break;

        case 'Individual':
            $('#changeNameContact').html("I'm an Independent Learner");
            $('#changeNameContact').attr('value', 'Individual');
            break;

        case 'ProspectiveCoach':
            $('#changeNameContact').html("I'm a Prospective Coach");
            $('#changeNameContact').attr('value', 'ProspectiveCoach');
            break;

        case 'Other':
            $('#changeNameContact').html("Other");
            $('#changeNameContact').attr('value', 'Other');
            break;

        default:

            $('#changeNameContact').html("Other");
            $('#changeNameContact').attr('value', 'Other');
            break;


    }
    ;

};

translateTestimonial = function (language, number) {

    if (language == 'spanish') {

        $('#testimonialSpanish' + number).removeClass('notDisplay');
        $('#testimonialEnglish' + number).addClass('notDisplay');


    } else if (language == 'english') {

        $('#testimonialEnglish' + number).removeClass('notDisplay');
        $('#testimonialSpanish' + number).addClass('notDisplay');

    }

};

closeGetStarted = function () {

    $('#navbarWeb').addClass('fixed-top');
    $('#addonHeader').remove();

};

showPrivacy = function (type) {


    if (type == 'student') {

        $('#politicsInstructor').css('display', 'none');
        $('#politicsStudent').css('display', 'block');
        $('#btnStudent').removeClass('backgroundColor35b4b4');
        $('#btnStudent').addClass('backgroundColor007aa5');
        $('#btnInstructor').removeClass('backgroundColor007aa5');
        $('#btnInstructor').addClass('backgroundColor35b4b4');

    } else if (type == 'instructor') {

        $('#politicsStudent').css('display', 'none');
        $('#politicsInstructor').css('display', 'block');
        $('#btnInstructor').removeClass('backgroundColor35b4b4');
        $('#btnInstructor').addClass('backgroundColor007aa5');
        $('#btnStudent').removeClass('backgroundColor007aa5');
        $('#btnStudent').addClass('backgroundColor35b4b4');
    }


};

showTerms = function (type) {


    if (type == 'student') {

        $('#termsInstructor').css('display', 'none');
        $('#termsStudent').css('display', 'block');
        $('#btnStudent').removeClass('backgroundColor35b4b4');
        $('#btnStudent').addClass('backgroundColor007aa5');
        $('#btnInstructor').removeClass('backgroundColor007aa5');
        $('#btnInstructor').addClass('backgroundColor35b4b4');

    } else if (type == 'instructor') {

        $('#termsStudent').css('display', 'none');
        $('#termsInstructor').css('display', 'block');
        $('#btnInstructor').removeClass('backgroundColor35b4b4');
        $('#btnInstructor').addClass('backgroundColor007aa5');
        $('#btnStudent').removeClass('backgroundColor007aa5');
        $('#btnStudent').addClass('backgroundColor35b4b4');
    }


};

modalUniversity = function () {
    $('#modal_university').modal('show');
};

modalLanguage = function () {
    $('#modal_language').modal('show');
};

