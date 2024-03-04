/* 
 * Developed by wilowi
 */

angular.module('lingroApp', []).controller('lingroCtrl', ['$scope', '$compile', '$timeout', '$window', function ($scope, $compile, $timeout, $window) {

	$scope.principalUrl = principalUrl;
	$scope.buttonsDisabled = false;
        
                $scope.modalUniversity = function () {
            $('#modal_university').modal('show');
        };

        $scope.modalLanguage = function () {
            $('#modal_language').modal('show');
        };
        
        $scope.modalRegisterForm = function () {
            $('#modal_register').modal('show');
        };
        
        $scope.doCreateUniversity = function () {

            var params = new Object();
            params.controller = 'universityController';
            params.function = 'doCreateUniversity';
            params.id_zone = $('#time_zone_university').val();
            params.name_university = $('#name_university').val();
            params.id_country = $('#country_university').val();

            if (params.name_university != '') {

                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    var datos_extra = Data.extra.split('|-|');
                    if (Data.control_peticion == 'OK') {

                        $('.event_create_uni').each(function () {

                            $(this).append('<option value="' + datos_extra[0] + '">' + datos_extra[1] + '</option>');
                        });

                        $('#modal_university').modal('hide');
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');

                    } else {
                        $('#messageUniversity').empty();
                        $('#messageUniversity').html(Data.resultado);
                    }
                });
            } else {
                $('#messageLanguage').empty();
                $('#messageLanguage').html('You need to enter a name.');
            }

        };

        $scope.createNewLanguage = function () {

            var params = new Object();
            params.controller = 'universityController';
            params.function = 'doCreateLanguage';
            params.name_language = $('#nameLanguageNew').val();

            if (params.name_language != '') {

                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    var datos_extra = Data.extra.split('|-|');
                    if (Data.control_peticion == 'OK') {

                        $('.event_create_language').each(function () {

                            $(this).append('<option value="' + datos_extra[0] + '">' + datos_extra[1] + '</option>');
                        });

                        $('#modal_language').modal('hide');
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');

                    } else {
                        $('#messageLanguage').empty();
                        $('#messageLanguage').html(Data.resultado);
                    }
                });

            } else {
                $('#messageLanguage').empty();
                $('#messageLanguage').html('You need to enter a name.');
            }

        };
        
        $scope.doRegisterForm = function () {

            $scope.buttonsDisabled = true;
            var params = new Object();
            params.controller = 'universityController';
            params.function = 'register';
            params.user = $scope.username;
            params.lastname = $scope.lastname;
            params.email = $scope.email;
            params.password = $scope.password;
            params.confirmpassword = $scope.confirmpassword;
            params.user_rol = $scope.user_rol;
            params.country = $scope.country;
            params.time_zone = $scope.time_zone;
            params.university = $scope.university;
            params.language = $scope.instructor_language;
            params.call = 'webForm';

            if ($('#aceptTerms').is(':checked')) {
                params.aceptTerms = 1;
            } else {
                params.aceptTerms = 0;
            }

            if (validarFormulario(params, 'registerTeacherUni')) {

                var valores = JSON.stringify(params);
                sendToServer(valores, $scope.afterRegisterForm);

            } else {
                $scope.buttonsDisabled = false;
                $('#messageResultRegister').empty();
                $('#messageResultRegister').html('<span class="color20">Complete all required fields, enter valid email and acept the terms and conditions.</span>');
                $('#modal_register').modal('hide');
                $('#modal_result_register').modal('show');
            }

        };
        
        $scope.afterRegisterForm = function (Data) {

            $scope.buttonsDisabled = false;
            $('#modal_register').modal('hide');
            $('.modal-backdrop').remove();
            $('.ng-scope').removeClass('modal-open');
            //$('#container-principal').html($compile(Datos.resultado)($scope));
            $('#loading').css('display', 'none');

            $('#messageResultRegister').empty();
            $('#messageResultRegister').html(Data.resultado);
            $('#modal_result_register').modal('show');

            if (Data.control_peticion == 'OK') {

                $('#register-form-link').removeClass('btnCalendarSelected');
                $('#register-form-link').addClass('btnCalendar');
                $('#login-form-link').addClass('btnCalendarSelected');
                $('#login-form-link').removeClass('btnCalendar');
            }


        };

	// --- FUNCIONES do ---
	$scope.doLogin = function () {

	    $scope.buttonsDisabled = true;
	    var params = new Object();
	    params.controller = 'webController';
	    params.function = 'login';
	    params.user = $scope.login;
	    params.password = $scope.password;
	    var valores = JSON.stringify(params);
	    sendToServer(valores, $scope.afterLogin);
	};
        
        $scope.searchJira = function(){
            
            $scope.buttonsDisabled = true;
	    var params = new Object();
	    params.controller = 'webController';
	    params.function = 'searchJira';
	    params.query = $('#searchQuery').val();
	    var valores = JSON.stringify(params);
	    sendToServer(valores, $scope.afterSearchSupport);
            
        };
        
        $scope.afterSearchSupport = function(Data){
            
            
            $('#resultSearch').empty();
            $('#resultSearch').html(Data.resultado);
            
        };


	$scope.doForgotEmail = function () {

	    $scope.buttonsDisabled = true;

	    var params = new Object();
	    params.controller = 'webController';
	    params.function = 'forgotEmail';
	    params.email = $('#email-forgot').val();

	    if (validarFormulario(params)) {


		var valores = JSON.stringify(params);
		sendToServer(valores, $scope.afterForgot);

	    } else {
		$scope.buttonsDisabled = false;
		alert('Please, enter a valid email');
	    }

	};

	$scope.afterForgot = function (Datos) {

	    $scope.buttonsDisabled = false;
	    alert(Datos.resultado);
	};

	$scope.doStep3 = function () {

	    $('#loading').css('display', 'block');
	    $scope.buttonsDisabled = true;
	    $window.location.hash = '#header';
	    history.pushState("", document.title, window.location.pathname
		    + window.location.search);
	    var error_paypal = false;
	    var params = new Object();
	    params.controller = 'webController';
	    params.function = 'payment';
	    params.code = $('#code_university').val();
	    params.username = $('#username').val();
	    params.lastname = $('#lastname').val();
	    params.email = $('#email').val();
	    params.emailRepeat = $('#emailRepeat').val();
	    params.password = $('#password').val();
	    params.confirmPassword = $('#confirmPassword').val();

	    var notPayment = false;
	    if ($('#payPal').is(':checked')) {
		params.payment = $('#payPal').val();
	    } else if ($('#payPalCredit').is(':checked')) {
		params.payment = $('#payPalCredit').val();
	    } else if ($('#payEnvivoCode').is(':checked')) {
		params.payment = $('#payEnvivoCode').val();
	    } else if ($('#payFree').is(':checked')) {
		params.payment = $('#payFree').val();
	    } else {
		notPayment = true;
	    }

	    params.code_linguameeting = $scope.codelinguameeting;
	    params.type_course = $('#typeCourse').val();
	    params.id_course = $('#idCourse').val();
	    //params.id_user = $('#idUser').val();
	    params.id_section = $('#idSection').val();
	    params.userLingro = $('#userLingro').val();

	    if ($('#check_terms').is(':checked')) {
		params.terms = 'on';
	    } else {
		params.terms = '';
	    }

	    if (validarFormulario(params, 'registerStudent') && !error_paypal && !notPayment) {
		var valores = JSON.stringify(params);
		sendToServer(valores, $scope.afterPayment);
	    } else {
			$('#loading').css('display', 'none');
			$scope.buttonsDisabled = false;
			$('#textMessageForm').empty();
			$('#textMessageForm').html("Complete all required fields, enter valid email, accept terms license and select the payment type");
			$('#modal_message_form').modal('show');
	    }
	};

	$scope.doStep3Test = function (nonce = "") {

		$('#loading').css('display', 'block');
		$scope.buttonsDisabled = true;
		$window.location.hash = '#header';
		history.pushState("", document.title, window.location.pathname
			+ window.location.search);
		var error_paypal = false;
		var params = new Object();
		params.controller = 'webController';
		params.function = 'payment';
		params.code = $('#code_university').val();
		params.username = $('#username').val();
		params.lastname = $('#lastname').val();
		params.email = $('#email').val();
		params.emailRepeat = $('#emailRepeat').val();
		params.password = $('#password').val();
		params.confirmPassword = $('#confirmPassword').val();

		var notPayment = false;
		if ($('#payPal').is(':checked')) {
			params.payment = $('#payPal').val();
		} else if ($('#brainTree').is(':checked')) {
			params.payment = $('#brainTree').val();
			params.paymentMethodNonce = nonce;
		}else if ($('#payPalCredit').is(':checked')) {
			params.payment = $('#payPalCredit').val();
		} else if ($('#payEnvivoCode').is(':checked')) {
			params.payment = $('#payEnvivoCode').val();
		} else if ($('#payFree').is(':checked')) {
			params.payment = $('#payFree').val();
		} else {
			notPayment = true;
		}

		params.code_linguameeting = $scope.codelinguameeting;
		params.type_course = $('#typeCourse').val();
		params.id_course = $('#idCourse').val();
		//params.id_user = $('#idUser').val();
		params.id_section = $('#idSection').val();
		params.userLingro = $('#userLingro').val();

		if ($('#check_terms').is(':checked')) {
			params.terms = 'on';
		} else {
			params.terms = '';
		}
		if (validarFormulario(params, 'registerStudent') && !error_paypal && !notPayment) {
			var valores = JSON.stringify(params);
			sendToServer(valores, $scope.afterPayment);
		} else {
			$('#loading').css('display', 'none');
			$scope.buttonsDisabled = false;
			$('#textMessageForm').empty();
			$('#textMessageForm').html("Complete all required fields, enter valid email, accept terms license and select the payment type");
			$('#modal_message_form').modal('show');
		}
	};

	
	$scope.viewSessionsCoach = function (id) {


            $('.viewSession').each(function () {

                $(this).removeClass('background_color0E0E65');
                $(this).addClass('background_color3');

                var coach_id = $(this).attr('coach_id');

                if (coach_id == id) {

                    $(this).removeClass('background_color3');
                    $(this).addClass('background_color0E0E65');

                }
            });
        };



	$scope.afterDo = function (Datos) {

	    $scope.buttonsDisabled = false;
            $('#loadingRegisterFlex').css('display', 'none');

	    if (Datos.extra == 'SESSION_FALSE') {
		$window.location.href = Datos.resultado;
	    } else {
		$('#container-principal').html($compile(Datos.resultado)($scope));
		$('#loading').css('display', 'none');
	    }



	};

	$scope.afterLogin = function (Datos) {

	    $scope.buttonsDisabled = false;

	    if (Datos.resultado == 'loginTrue') {
		$window.location.href = 'panel';

	    } else {
		$('#container-principal').html($compile(Datos.resultado)($scope));
		$('#loading').css('display', 'none');
	    }

	};

	$scope.afterRegCode = function (Datos) {

	    $scope.buttonsDisabled = false;
	    $('#loading').css('display', 'none');

		if (Datos.extra == 'CODE_TRUE') {

                    $window.location.href = Datos.resultado;

		} else {

                    $('#loading').css('display', 'none');
                    $scope.buttonsDisabled = false;
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html("You must provide a valid Class ID. Contact with your university / instructor");
                    $('#modal_message_form').modal('show');

                }


	};

	$scope.afterPayment = function (Data) {

	    $scope.buttonsDisabled = false;
	    //console.log(Datos);
	    $('#loading').css('display', 'none');
            console.log(Data);

	    if (Data.extra == 'PAYMENT-OK' || Data.extra =='LOGIN-NEXT') {

		$window.location.href = Data.resultado;
		
	    } else if (Data.extra == 'PAYMENT-BT-OK' || Data.extra == 'PAYMENT-FREE' || Data.extra == 'PAYMENT-CODE' || Data.extra == 'NEXT-STEPS') {

		
                
                if (Data.msg != '' && Data.type_msg == 'ERROR') {
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html(Data.msg);
                    $('#modal_message_form').modal('show');
                    
                }else{
                    
                    $('#step2Code').empty();
                    $('#step2Code').html($compile(Data.resultado)($scope));
                    $('#headerImages').empty();
                    $('#headerImages').html('<img src="../images/register_step_3.png">');
                    
                    if(Data.tabs=='ERROR'){
                        $('#textMessageForm').empty();
                        $('#textMessageForm').html(Data.msg);
                        $('#modal_message_form').modal('show');
                    }
                }
                
                
                
                
	    } else {
                
                $('#loading').css('display', 'none');
                $scope.buttonsDisabled = false;
                $('#textMessageForm').empty();
                $('#textMessageForm').html(Data.resultado);
                $('#modal_message_form').modal('show');
	    }

	    iniRegister();

	};

	$scope.afterRegister = function (Datos) {

	    $scope.buttonsDisabled = false;
	    $('#loading').css('display', 'none');

	    if (Datos.extra == 'REGISTER-OK') {
		$('#container-principal').html($compile(Datos.resultado)($scope));
	    } else {
		alert(Datos.resultado);
	    }

	};

	$scope.showCalendarCoaching = function (type) {

	    if (type == 'A') {
		$('.calendar_coaching_week' + type).css('display', 'block');
		$('.calendar_coaching_weekB').css('display', 'none');
	    } else if (type == 'B') {
		$('.calendar_coaching_week' + type).css('display', 'block');
		$('.calendar_coaching_weekA').css('display', 'none');
	    }

	    $('.event-select-coach-session').each(function () {

		$(this).addClass('background_avail');
		$(this).removeClass('background_color7');
		$(this).removeClass('event-select-coach-session');
	    });

	};


	/* Functions modal */
	
	$scope.modalViewCoach = function (ses) {

		    $('#modal_coach' + ses).modal('show');

		};
                
        $scope.modalRate = function () {
            
            $('#modal_rate').modal('show');

        };


	$scope.modalCreateProgram = function () {

	    $('#modal_create').modal('show');

	};
        
        $scope.modalDonateProgram = function () {

	    $('#modal_donate').modal('show');

	};
        
        

	$scope.modalForgotPassword = function () {
	    $('#modal_forgot').modal('show');
	};

	$scope.modalTerms = function () {

	    $('#modal_terms').modal('show');
	};

	$scope.contactForm = function () {

	    $scope.buttonsDisabled = true;
	    var params = new Object();
	    var form = $('form')[0];
	    var formData = new FormData(form);
	    formData.append('controller', 'webController');
	    formData.append('function', 'contactForm');
            formData.append('kindContact', $('#changeNameContact').attr('value'));
	    params.name = $('#name').val();
	    params.message = $('#message').val();
	    params.email = $('#email').val();
            params.issuetype = $('#issuetype').val();

	    if (params.message !== '' && params.name != '' && params.email != '' && validarEmail(params.email) && params.issuetype >0 ) {

		$.ajax({
		    url: rutaAjax,
		    type: 'POST',
		    data: formData,
		    success: function (Data) {
			$scope.buttonsDisabled = false;
			if (Data.resultado == 'KO') {
			    alert("You are not a human");
			    console.log(Data);
			} else {
			    alert("Thank you for your email. We will shortly contact you.");
			    $window.location.href = 'contact';
			}

		    },
		    error: function (Data) {
			$scope.buttonsDisabled = false;
			alert("Error");
		    },
		    async: true,
		    cache: false,
		    contentType: false,
		    processData: false
		});


	    } else {
		$scope.buttonsDisabled = false;
		alert("You need to write your name, valid email, issue type and message");
	    }


	};

        
        $scope.doPayExperience = function (id_experience) {

            
            var params = new Object();
            params.controller = 'webController';
            params.function = 'doPayExperience';
            params.id_experience = id_experience;
            params.name = $('#nameExperience').val();
            params.lastname = $('#lastnameExperience').val();
            params.email = $('#emailExperience').val();
            params.school = $('#schoolExperience').val();
            params.codigoLinguaMeetingExp = $('#codigoLinguaMeetingExp').val();

            if ($('#payPal').is(':checked')) {
                params.payment = $('#payPal').val();
            } else if ($('#payEnvivoCode').is(':checked')) {
                params.payment = $('#payEnvivoCode').val();
            }

            if (params.payment != '' && params.payment != 'undefined' && params.email != '' && params.email != 'undefined') {
                $('.loading-div').css('display','block');
                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    if (Data.extra == 'PAYMENT-OK') {

                        window.location.href = Data.resultado;

                    } else if (Data.extra == 'PAYMENT-CODE') {

                        window.location.href = Data.resultado;
                        
                    } else {
                        alert(Data.resultado);
                    }

                });
            } else {

                alert("You need to select a payment option and fill the field email");
            }
            
            
        };
        
        $scope.doPayExperienceFree = function (id_experience) {

            
            var params = new Object();
            params.controller = 'webController';
            params.function = 'doPayExperience';
            params.id_experience = id_experience;
            params.name = $('#nameExperience').val();
            params.lastname = $('#lastnameExperience').val();
            params.email = $('#emailExperience').val();
            params.school = $('#schoolExperience').val();
            params.payment = 'free';

            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

               if (Data.extra == 'PAYMENT-OK') {

                        window.location.href = Data.resultado;

                    } else if (Data.extra == 'PAYMENT-CODE') {

                        window.location.href = Data.resultado;
                        
                    } else {
                        alert(Data.resultado);
                    }

            });

            
        };
        
        $scope.doDonateExperience = function(id_experience){
            
            
            var params = new Object();
            params.controller = 'webController';
            params.function = 'doDonateExperience';
            params.id_experience = id_experience;
            params.name = $('#nameDonation').val();
            params.lastname = $('#lastnameDonation').val();
            params.email = $('#emailDonation').val();
            params.amount = $('#amountDonation').val();

            if (parseInt(params.amount) > 0) {
                
                $('.loading-div').css('display','block');
                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    if (Data.extra == 'PAYMENT-OK') {

                        window.location.href = Data.resultado;

                    }else {
                        alert(Data.resultado);
                    }

                });

            } else {

                alert("You need to fill the field amount");
            }
            
        };
        
        $scope.rateExperience = function (id_experience) {

            $('#loadingRegisterFlex').css('display', 'block');
            var params = new Object();
            params.controller = 'webController';
            params.function = 'rateExperience';
            params.id_experience = id_experience;
            params.name = $('#nameExperienceRate').val();
            params.lastname = $('#lastnameExperienceRate').val();
            params.email = $('#emailExperienceRate').val();
            params.stars = $("#rating").rate("getValue");
            params.comment = $("#rateText").val();


            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                window.location.href = Data.resultado;

            });
        };
        

	
	$scope.afterSearchSession = function(Datos){
	    
	    $scope.buttonsDisabled = false;

	    $('#modal_loading').modal('hide');
				if ($('.modal-backdrop').is(':visible')) {
				    $('body').removeClass('modal-open');
				    $('.modal-backdrop').remove();
				}
				;
				$('.ng-scope').removeClass('modal-open');
	    if (Datos.extra == 'SESSION_FALSE') {
		
		$window.location.href = Datos.resultado;
		
	    } else {
		$('#sessionsSearched-_-'+Datos.extra).empty();
		$('#sessionsSearched-_-'+Datos.extra).html($compile(Datos.resultado)($scope))
		$('#loading').css('display', 'none');
		
		
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
		
		
	    }
	    
	};

	$scope.selectSessionFlex = function(date,hour,name_coach){

	    $('#modal_register_flex').modal('show');
	    $('#selectedFlexSes').empty();
	    $('#selectedFlexSes').html('<strong>'+date+' - '+hour+'</strong> with coach <strong>'+name_coach+'</strong>');
	    
	};
	
	$scope.registerSessionFlex = function(){
	    
	    
	    $scope.buttonsDisabled = true;
	    $('#loadingRegisterFlex').css('display', 'block');
	    $('#modal_register_flex').modal('hide');
	    $('.modal-backdrop').remove();
	    $('.ng-scope').removeClass('modal-open');
	    
	    var params = new Object();
	    params.controller = 'webController';
	    params.function = 'registerSessionFlex';
	    params.id_course = $('#idCourse').val();
	    params.id_user = $('#idUser').val();
	    params.id_section = $('#idSection').val();
	    params.session_selected = new Object();

	    params.session_selected.id_coach = $('.event-select-coach-session').attr('id_coach');
	    params.session_selected.schedule = $('.event-select-coach-session').attr('schedule');
	    params.session_selected.scheduleOld = $('.event-select-coach-session').attr('scheduleold');
	    params.session_selected.inverse = $('.event-select-coach-session').attr('inverse');
	    params.session_selected.day = $('.event-select-coach-session').attr('day');
	    params.session_selected.id_hour = $('.event-select-coach-session').attr('id_hour');
	    params.session_selected.date = $('.event-select-coach-session').attr('date');
            params.session_selected.id_cont_btn = $('.event-select-coach-session').attr('id_cont_btn');
            params.session_selected.dateCoach = $('.event-select-coach-session').attr('dateCoach');

	    //console.log(params);
	    if (params.session_selected.schedule !== undefined && params.session_selected.schedule !=='') {

		//console.log(params);
		var valores = JSON.stringify(params);
		sendToServer(valores, function(Data){
                    
                    if(Data.resultado=='OK'){
                    
                        $('#envelopeSession'+Data.extra).empty();
                        $('#envelopeSession'+Data.extra).html('<div>Session selected: <strong>'+Data.tabs+'</strong>.</div>');

                    }else{
			
			if(Data.control_peticion=='MoreSessions'){
			    
			    alert(Data.extra);
			    
			}else{
			    
			    alert('Error when saving the sessions. Try again. If the problem persists, please contact support');
			    
			}                        

                    }
                    
                });

	    } else {
		
		$scope.buttonsDisabled = false;
		$('#loadingRegisterFlex').css('display', 'none');
		alert("Please select a session.");
		
	    }	    
	    
	};

	$scope.modalContactSupport = function () {

	    $('#modal_contat_support_sessions').modal('show');

	};
	$scope.doContactSupportSessions = function (type_request) {

	    $('#loading').css('display', 'block');
	    $('.loading-div').css('display', 'block');

	    var params = new Object();
	    params.controller = 'studentsController';
	    params.function = 'contactSupportSessions';
	    params.type_request = type_request;
	    params.hours = $('#writeHours').val();
	    params.msg = $('#addMsg').val();
	    params.id_user = $('#idUser').val();

	    if ($('#weekNewdaymon').is(':checked')) {
		params.monday = true;
	    } else {
		params.monday = false;
	    }
	    if ($('#weekNewdaytue').is(':checked')) {
		params.tuesday = true;
	    } else {
		params.tuesday = false;
	    }
	    if ($('#weekNewdaywed').is(':checked')) {
		params.wednesday = true;
	    } else {
		params.wednesday = false;
	    }
	    if ($('#weekNewdaythu').is(':checked')) {
		params.thursday = true;
	    } else {
		params.thursday = false;
	    }
	    if ($('#weekNewdayfri').is(':checked')) {
		params.friday = true;
	    } else {
		params.friday = false;
	    }
	    if ($('#weekNewdaysat').is(':checked')) {
		params.saturday = true;
	    } else {
		params.saturday = false;
	    }
	    if ($('#weekNewdaysun').is(':checked')) {
		params.sunday = true;
	    } else {
		params.sunday = false;
	    }

	    var daysNull = false;
	    if (!params.monday && !params.tuesday && !params.wednesday && !params.thursday && !params.friday && !params.saturday && !params.sunday) {
		daysNull = true;
	    }

	    if (params.hours != '' && !daysNull) {

		var valores = JSON.stringify(params);
		sendToServer(valores, function (Datos) {

		    $scope.buttonsDisabled = false;
		    $('#modal_contat_support_sessions').modal('hide');
		    $('.modal-backdrop').remove();
		    $('.ng-scope').removeClass('modal-open');
		    $('#modal_loading').modal('hide');
		    $('.loading-div').css('display', 'none');
		    $('#loading').css('display', 'none');


		    if (Datos.msg != '') {

			if (Datos.type_msg == 'INFO') {

			    $('#setTextModalInfo').empty();
			    $('#setTextModalInfo').append(Datos.msg);

			    $('#modal_info').modal('show');

			} else if (Datos.type_msg == 'WARNING') {

			    $('#setTextModalWarning').empty();
			    $('#setTextModalWarning').append(Datos.msg);
			    $('#modal_warning').modal('show');

			} else if (Datos.type_msg == 'ERROR') {

			    $('#setTextModalError').empty();
			    $('#setTextModalError').append(Datos.msg);
			    $('#modal_error').modal('show');

			}

		    }

		});

	    } else {

		$('#loading').css('display', 'none');
		$('.loading-div').css('display', 'none');
		$scope.buttonsDisabled = false;

		alert('You must select some days and hours');

	    }

	};
        
        $scope.showPrivacy = function(type){
            
            
            if(type=='student'){
                
                $('#politicsInstructor').css('display','none');
                $('#politicsStudent').css('display','block');
                $('#btnStudent').removeClass('backgroundColor35b4b4');
                $('#btnStudent').addClass('backgroundColor007aa5');
                $('#btnInstructor').removeClass('backgroundColor007aa5');
                $('#btnInstructor').addClass('backgroundColor35b4b4');
                
            }else if (type=='instructor'){
                
                $('#politicsStudent').css('display','none');
                $('#politicsInstructor').css('display','block');
                $('#btnInstructor').removeClass('backgroundColor35b4b4');
                $('#btnInstructor').addClass('backgroundColor007aa5');
                $('#btnStudent').removeClass('backgroundColor007aa5');
                $('#btnStudent').addClass('backgroundColor35b4b4');
            }
            
            
        };
        
        $scope.showTerms = function(type){
            
            
            if(type=='student'){
                
                $('#termsInstructor').css('display','none');
                $('#termsStudent').css('display','block');
                $('#btnStudent').removeClass('backgroundColor35b4b4');
                $('#btnStudent').addClass('backgroundColor007aa5');
                $('#btnInstructor').removeClass('backgroundColor007aa5');
                $('#btnInstructor').addClass('backgroundColor35b4b4');
                
            }else if (type=='instructor'){
                
                $('#termsStudent').css('display','none');
                $('#termsInstructor').css('display','block');
                $('#btnInstructor').removeClass('backgroundColor35b4b4');
                $('#btnInstructor').addClass('backgroundColor007aa5');
                $('#btnStudent').removeClass('backgroundColor007aa5');
                $('#btnStudent').addClass('backgroundColor35b4b4');
            }
            
            
        };
        
        $scope.changeCalendarWeek = function (arrow) {

            if (arrow == 'right') {

                $('#dev-table1').addClass('notDisplay');
                $('#dev-table2').removeClass('notDisplay');

                $('#arrow_left').removeClass('opacity06');
                $('#arrow_left').addClass('cursor_pointer');
                $('#arrow_right').addClass('opacity06');
                $('#arrow_right').removeClass('cursor_pointer');

                $('#arrow_left').attr('ng-click', "changeCalendarWeek('left')");
                $('#arrow_right').attr('ng-click', "");


            } else if (arrow == 'left') {

                $('#dev-table1').removeClass('notDisplay');
                $('#dev-table2').addClass('notDisplay');

                $('#arrow_right').removeClass('opacity06');
                $('#arrow_right').addClass('cursor_pointer');
                $('#arrow_left').addClass('opacity06');
                $('#arrow_left').removeClass('cursor_pointer');

                $('#arrow_right').attr('ng-click', "changeCalendarWeek('right')");
                $('#arrow_left').attr('ng-click', "");
            }

        };
        
         $scope.modalBookSessionCalendar = function (date, hour, id) {

            $('.viewSession').each(function () {

                $(this).removeClass('background_color0E0E65');
                $(this).addClass('background_color3');

            });

            $('#sessionSelectedBook' + date + hour + id).removeClass('background_color3');
            $('#sessionSelectedBook' + date + hour + id).addClass('background_color0E0E65');
            $('#modal_book_session' + date + hour + id).modal('show');

        };
        
        $scope.calendarSessions = function (week_id, isDateEnd, reschedule, idStudentSession, fromMakeUp, missed, typeSession) {

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'calendarSessions';
            params.week_id = week_id;
            params.isDateEnd = isDateEnd;
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.idStudentSession = idStudentSession;
            params.enroll_id = $('#enrollId').val();
            params.fromReschedule = reschedule;
            params.fromMakeUp = fromMakeUp;
            params.session_missed = missed;
            params.type_session = typeSession;
            params.fromWeb = 'yes';

            $('.loading-div').css('display', 'block');
            
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });

            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {

                if (Data.msg != '' && Data.type_msg == 'ERROR') {
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html(Data.msg);
                    $('#modal_message_form').modal('show');

                } else {

                    $('#step2Code').empty();
                    $('#step2Code').html($compile(Data.resultado)($scope));
                    $('.modal-backdrop').remove();
                    $('.ng-scope').removeClass('modal-open');

                }

                $('#loading').css('display', 'none');
                $('.eventbookSession').css('display', 'none');
                $('.loading-div').each(function(){
                    
                    $(this).css('display', 'none');
                });
                $('.loading-div').css('display', 'none');


            });


        };
        
        $scope.searchSessionCourse = function (week_id, isDateEnd, hour_id, reschedule,idStudentSession) {

            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');
            $('.eventCollapse').empty();

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'searchSessionCourse';
            params.week_id = week_id;
            params.isDateEnd = isDateEnd;
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.dateSelect = $('#dateSession'+idStudentSession).val();
            params.time = $('#selectTime'+idStudentSession).val();
            params.coachSelect = $('#coachSelect' + idStudentSession).val();
            params.hour_id = hour_id;
            params.reschedule = reschedule;
            params.enroll_id = $('#enrollId').val();
            params.idStudentSession = idStudentSession;
            params.fromWeb = 'yes';
            $(window).scrollTop(0);
            
            if(params.coachSelect!='undefined' && params.coachSelect!=''){
        
        params.function = 'searchSessionCourseCoach';
    }
            
            if (params.dateSelect != '' && params.dateSelect != 'undefined' && (parseInt(params.time) > 0 || (params.coachSelect!='' && params.coachSelect!='undefined') ))  {


                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {
                                        

                    if (Data.msg != '' && Data.type_msg == 'ERROR') {
                        $('#textMessageForm').empty();
                        $('#textMessageForm').html(Data.msg);
                        $('#modal_message_form').modal('show');

                    } else {

                        $('#step2Code').empty();
                        $('#step2Code').html($compile(Data.resultado)($scope));
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');
                        
                    }
                    
                    $('#loading').css('display', 'none');
                    $('.loading-div').css('display', 'none');
                    

                });
                

	    } else {
                $('#loading').css('display', 'none');
                $scope.buttonsDisabled = false;
                $('#textMessageForm').empty();
                $('#textMessageForm').html("Complete all required fields, enter a date and time or coach.");
                $('#modal_message_form').modal('show');
		
	    }
            

        };
        
        $scope.selectTimeCoach = function(week_id,isDateEnd,coach_id,hour_id){
            
            
            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'selectTimeCoach';
            params.week_id = week_id;
            params.coach_id = coach_id;
            params.isDateEnd = isDateEnd;
            params.idStudentSession = $('#idStudentSession').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.dateSelect = $('#dateSession'+params.idStudentSession).val();
            params.time = $('#selectTime'+params.idStudentSession).val();
            params.coachSelect = $('#coachSelect' + params.idStudentSession).val();
            params.hour_id = hour_id;
            params.enroll_id = $('#enrollId').val();

            if (params.dateSelect!='' && params.dateSelect!='undefined' && (parseInt(params.time) > 0 || (params.coachSelect!='' && params.coachSelect!='undefined') )) {

                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {
                                        

                    if (Data.msg != '' && Data.type_msg == 'ERROR') {
                        $('#textMessageForm').empty();
                        $('#textMessageForm').html(Data.msg);
                        $('#modal_message_form').modal('show');

                    } else {

                        $('#step2Code').empty();
                        $('#step2Code').html($compile(Data.resultado)($scope));
                        
                    }
                    
                    $('#loading').css('display', 'none');
                    $('.loading-div').css('display', 'none');

                });

	    } else {
                $('#loading').css('display', 'none');
                $scope.buttonsDisabled = false;
                $('#textMessageForm').empty();
                $('#textMessageForm').html("Complete all required fields, enter a date and time or coach.");
                $('#modal_message_form').modal('show');
		
	    }
            
        };

        $scope.modalBookSession = function(id){
            
            $('.sessionsToSelect').each(function(){
                
                $(this).removeClass('background_color0E0E65');
                $(this).addClass('backgroundColor35b4b4');
                
            });
            
            $('#sessionSelectedBook'+id).removeClass('backgroundColor35b4b4');
            $('#sessionSelectedBook'+id).addClass('background_color0E0E65');
            $('#modal_book_session'+id).modal('show');
            
            
        };
        
        $scope.stepSessions = function(){
            
            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');
            $(window).scrollTop(0);

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'stepSessions';
            params.week_id = $('#weekId').val();
            params.isDateEnd = $('#isDateEnd').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.time = $('#time_id').val();
            params.hour_id = $('#hour_id').val();
            params.enroll_id = $('#enrollId').val();
            
            var valores = JSON.stringify(params);
            sendToServer(valores, $scope.afterPayment);
            
        };
        
        $scope.bookCalendarSession = function (coach_id, schedules, hour_ini, search_next, reschedule, dateSelect, name_coach, lastname_coach, fromMake) {

            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');
            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'bookSession';
            params.week_id = $('#weekId').val();
            params.isDateEnd = $('#isDateEnd').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.coach_id = coach_id;
            params.schedules = schedules;
            params.dateSelect = dateSelect;
            params.enroll_id = $('#enrollId').val();
            params.hour_ini = hour_ini;
            params.search_next = search_next;
            params.fromReschedule = reschedule;
            params.idStudentSession = $('#idStudentSession').val();
            params.fromCalendar = 1;
            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {


                if (Data.msg != '' && Data.type_msg == 'ERROR') {
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html(Data.msg);
                    $('#modal_message_form').modal('show');
                } else {

                    if (Data.extra == 'OK') {

                        $('.modal_book_session').each(function () {

                            var idCount = $(this).attr('idCount');
                            $('#modal_book_session' + idCount).modal('hide');
                        });
                        $('.loading-div').css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');
                        
                    } else if (Data.extra == 'OK-Next') {

                        $('.modal_book_session').each(function () {

                            var idCount = $(this).attr('idCount');
                            $('#modal_book_session' + idCount).modal('hide');
                        });

                        $('#buttonUpdateAllDay').attr('ng-click', 'bookSessionNext(' + coach_id + ')');

                        $('#nameUpdate').empty();
                        $('#nameUpdate').html('Would you like to book all sessions with ' + name_coach + ' ' + lastname_coach + '?');
                        $('#textSelectSession').empty();
                        $('#textSelectSession').html($compile(Data.resultado)($scope));
                        $('#modal_book_next').modal('show');
                    } else if (Data.extra == 'DASHBOARD') {
                        window.location.href = 'panel';
                    } else {

                        $('#step2Code').empty();
                        $('#step2Code').html(Data.resultado);
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');
                    }

                }

                $('#loading').css('display', 'none');
                $('.loading-div').css('display', 'none');
            });
        };
        
        $scope.bookSession = function(coach_id,schedules,hour_ini,search_next,lastSession){
            
            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'bookSession';
            params.week_id = $('#weekId').val();
            params.isDateEnd = $('#isDateEnd').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.time = $('#time_id').val();
            params.hour_id = $('#hour_id').val();
            params.coach_id = coach_id;
            params.schedules = schedules;
            params.dateSelect = $('#dateSelect').val();
            params.enroll_id = $('#enrollId').val();
            params.hour_ini = hour_ini;
            params.search_next = search_next;
            params.idStudentSession = $('#idStudentSession').val();
            params.lastSession = lastSession;
            params.coachSelect = $('#coachSelect').val();
            
            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {


                if (Data.msg != '' && Data.type_msg == 'ERROR') {
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html(Data.msg);
                    $('#modal_message_form').modal('show');

                } else {
                    
                    if (Data.extra == 'OK') {

                        $('.modal_book_session').each(function(){
                            
                            var idCount = $(this).attr('idCount');
                            
                             $('#modal_book_session'+idCount).modal('hide');
                        });
                       

                        
                    } 
                    else if(Data.extra == 'OK-Next'){
                        
                        $('.modal_book_session').each(function(){
                            
                            var idCount = $(this).attr('idCount');
                            
                             $('#modal_book_session'+idCount).modal('hide');
                        });
                        
                        $('#textSelectSession').empty();
                        $('#textSelectSession').html(Data.resultado);
                        $('#modal_book_next').modal('show');
                    }
                    else {

                        $('#step2Code').empty();
                        $('#step2Code').html($compile(Data.resultado)($scope));

                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');
                    }



                }

                $('#loading').css('display', 'none');
                $('.loading-div').css('display', 'none');

            });
            
        };
        
        $scope.bookSessionLastMinute = function(coach_id,schedules,hour_ini,search_next,lastSession,dateSelect){
            
            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'bookSession';
            params.week_id = $('#weekId').val();
            params.isDateEnd = $('#isDateEnd').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.time = $('#time_id').val();
            params.hour_id = $('#hour_id').val();
            params.coach_id = coach_id;
            params.schedules = schedules;
            params.dateSelect = dateSelect;
            params.enroll_id = $('#enrollId').val();
            params.hour_ini = hour_ini;
            params.search_next = search_next;
            params.idStudentSession = $('#idStudentSession').val();
            params.lastSession = lastSession;
            
            var valores = JSON.stringify(params);
            sendToServer(valores, function (Data) {


                if (Data.msg != '' && Data.type_msg == 'ERROR') {
                    $('#textMessageForm').empty();
                    $('#textMessageForm').html(Data.msg);
                    $('#modal_message_form').modal('show');

                } else {
                    
                    if (Data.extra == 'OK') {

                        $('.modal_book_session').each(function () {

                            var idCount = $(this).attr('idCount');

                            $('#modal_book_session' + idCount).modal('hide');
                        });

                        $('#loading').css('display', 'none');
                        $('.loading-div').css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');

                        
                    } 
                    else if(Data.extra == 'OK-Next'){
                        
                        $('.modal_book_session').each(function(){
                            
                            var idCount = $(this).attr('idCount');
                            
                             $('#modal_book_session'+idCount).modal('hide');
                        });
                        
                        $('#textSelectSession').empty();
                        $('#textSelectSession').html($compile(Data.resultado)($scope));
                        $('#modal_book_next').modal('show');
                    }
                    else {

                        $('#step2Code').empty();
                        $('#step2Code').html($compile(Data.resultado)($scope));

                        
                        $('.modal-backdrop').remove();
                        $('.ng-scope').removeClass('modal-open');
                    }



                }

                $('#loading').css('display', 'none');
                        $('.loading-div').css('display', 'none');

            });
            
        };
        
        $scope.selectLastMinute = function (week_id, isDateEnd, hour_id, reschedule) {

            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'selectLastMinute';
            params.idStudentSession = $('#idStudentSession').val();
            params.week_id = week_id;
            params.isDateEnd = isDateEnd;
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.dateSelect = $('#dateSession' + params.idStudentSession).val();
            params.time = $('#selectTime' + params.idStudentSession).val();
            params.hour_id = hour_id;
            params.enroll_id = $('#enrollId').val();
            params.typeController = 'panel';
            params.fromReschedule = reschedule;
            params.fromWeb = 'yes';

            if (params.dateSelect != '' && params.dateSelect != 'undefined' && parseInt(params.time) > 0) {

                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });

                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    if (Data.msg != '' && Data.type_msg == 'ERROR') {
                        $('#textMessageForm').empty();
                        $('#textMessageForm').html(Data.msg);
                        $('#modal_message_form').modal('show');

                    } else {

                        $('#step2Code').empty();
                        $('#step2Code').html($compile(Data.resultado)($scope));

                    }

                    $('#loading').css('display', 'none');
                    $('.loading-div').css('display', 'none');


                });

            } else {
                $('#loading').css('display', 'none');
                $('#textMessageForm').empty();
                $('#textMessageForm').html("Complete all required fields, enter a date and time or coach.");
                $('#modal_message_form').modal('show');

            }

        };
        
        $scope.bookSessionNext = function (coach_id) {

            $('#loading').css('display', 'block');
            $('.loading-div').css('display', 'block');

            var params = new Object();
            params.controller = 'studentsController';
            params.function = 'bookSessionNext';
            params.week_id = $('#weekId').val();
            params.isDateEnd = $('#isDateEnd').val();
            params.code = $('#code_university').val();
            params.id_user = $('#idUser').val();
            params.time = $('#time_id').val();
            params.hour_id = $('#hour_id').val();
            params.coach_id = coach_id;
            params.dateSelect = $('#dateSelect').val();
            params.enroll_id = $('#enrollId').val();
            params.nextSessions = [];

            var checked = false;
            var contWeek = 0;
            $('.eventWeekNext').each(function () {
                
                if ($(this).is(':checked')) {
                    checked = true;

                    var week_id = $(this).attr('week_id');
                    var schedules = $(this).attr('schedules');
                    var hour_ini = $(this).attr('hour_ini');
                    var dateSelectNext = $(this).attr('dateSelectNext');
                    var new_coach_id = $(this).attr('new_coach_id');

                    params.nextSessions[contWeek] = new Object();
                    params.nextSessions[contWeek].week_id = week_id;
                    params.nextSessions[contWeek].schedules = schedules;
                    params.nextSessions[contWeek].hour_ini = hour_ini;
                    params.nextSessions[contWeek].dateSelectNext = dateSelectNext;
                    params.nextSessions[contWeek].coach_id = new_coach_id;
                    contWeek = contWeek+1;
                }
                
            });
            
            if(checked){
            
                var valores = JSON.stringify(params);
                sendToServer(valores, function (Data) {

                    $('#modal_book_next').modal('hide');

                    if (Data.msg != '' && Data.type_msg == 'ERROR') {
                        $('#textMessageForm').empty();
                        $('#textMessageForm').html(Data.msg);
                        $('#modal_message_form').modal('show');

                    } else {


                        $window.location.href = Data.resultado;
                    
                    }

                    $('#loading').css('display', 'none');
                    $('.loading-div').css('display', 'none');

                });
            
            }else{
                
                $('#textMessageForm').empty();
                $('#textMessageForm').html('You need to select one or more sessions or Skip');
                $('#modal_message_form').modal('show');
            }
            
        };


    }])
	.directive('ngEnter', ngEnter);


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

    // video audio	
    $('.audio-stop').click(function () {
	$("video").prop('muted', false);
	$(".audio-stop").css('display', 'none');
	$(".audio").css('display', 'block');
    });

    $('.audio').click(function () {
	$("video").prop('muted', true);
	$(".audio").css('display', 'none');
	$(".audio-stop").css('display', 'block');
    });


    // carousel time
    $('#slider-students').carousel({
	interval: 2000
    });

    // button contact recaptcha
    $('#btnContactCaptcha').prop('disabled', true);

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

    $(document).ready(function () {
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

    });

    // first call
    var params = new Object();
    params.controller = 'webController';
    params.function = 'checkChat';
    var valores = JSON.stringify(params);
    sendToServerBack(valores, function (Data) {

	var options = jQuery.parseJSON(Data.resultado);

	if (options.enable_chat == 1) {

	    $('#jsd-widget').css('visibility', 'hidden');
	    $('#reamazejs-container').css('display', 'block');
	} else {

	    $('#reamazejs-container').css('display', 'none');
	    $('#jsd-widget').css('visibility', 'visible');
	}

    });
    setInterval(updateChat, 60000);
    function updateChat() {

	var params = new Object();
	params.controller = 'webController';
	params.function = 'checkChat';

	var valores = JSON.stringify(params);
	sendToServerBack(valores, function (Data) {

	    var options = jQuery.parseJSON(Data.resultado);

	    if (options.enable_chat == 1) {

		$('#jsd-widget').css('visibility', 'hidden');
		$('#reamazejs-container').css('display', 'block');
	    } else {

		$('#reamazejs-container').css('display', 'none');
		$('#jsd-widget').css('visibility', 'visible');
	    }

	});



    }



});


doPayExperienceNew = function (id_experience, nonce) {


	var params = new Object();
	params.controller = 'webController';
	params.function = 'doPayExperience';
	params.id_experience = id_experience;
	params.name = $('#nameExperience').val();
	params.lastname = $('#lastnameExperience').val();
	params.email = $('#emailExperience').val();
	params.school = $('#schoolExperience').val();
	params.codigoLinguaMeetingExp = $('#codigoLinguaMeetingExp').val();

	// if ($('#payPal').is(':checked')) {
	// 	params.payment = $('#payPal').val();
	// } else
	if ($('#payEnvivoCode').is(':checked')) {
		params.payment = $('#payEnvivoCode').val();
	}else{
		params.payment = $('#brainTree').val();
		params.paymentMethodNonce = nonce;
	}

	if (params.payment != '' && params.payment != 'undefined' && params.email != '' && params.email != 'undefined') {
		$('.loading-div').css('display','block');
		var valores = JSON.stringify(params);
		sendToServer(valores, function (Data) {

			//if (Data.extra == 'PAYMENT-OK') {
			if (Data.extra == 'PAYMENT-BT-OK') {
				window.location.href = Data.resultado;
			} else if (Data.extra == 'PAYMENT-CODE') {
				window.location.href = Data.resultado;
			} else {
				alert(Data.resultado);
			}
		});
	} else {
		alert("You need to select a payment option and fill the field email");
	}
};

doDonateExperienceNew = function(id_experience, nonce){


	var params = new Object();
	params.controller = 'webController';
	params.function = 'doDonateExperience';
	params.id_experience = id_experience;
	params.name = $('#nameDonation').val();
	params.lastname = $('#lastnameDonation').val();
	params.email = $('#emailDonation').val();
	params.amount = $('#amountDonation').val();
	params.paymentMethodNonce = nonce;

	if (parseInt(params.amount) > 0) {

		$('.loading-div').css('display','block');
		var valores = JSON.stringify(params);
		sendToServer(valores, function (Data) {

			if (Data.extra == 'PAYMENT-BT-OK') {
				window.location.href = Data.resultado;
			}else {
				alert(Data.resultado);
			}

		});

	} else {

		alert("You need to fill the field amount");
	}

};


iniRegister = function () {


    /*$(".event_datepicker_ini").click(function () {
     
     var cont = $(this).attr('contDatepicker');
     $("#date_iniSession-_-"+cont).datepicker({
     defaultDate: "+1w",
     changeMonth: true,
     dateFormat: "yy-mm-dd",
     numberOfMonths: 2,
     firstDay: 1
     });
     
     $("#dateIniNewAvail").datepicker("show");
     
     });*/

    /*$('.clockpicker').clockpicker({
	placement: 'top',
	align: 'left',
	donetext: 'Done',
	twelvehour: true
    });*/

};

datepicker_session_flex = function (id,date_ini,date_end) {
    
    var aux_date_ini = 0;
    var aux_date_end = 365;
    
    if(date_ini!=''){
        aux_date_ini = date_ini;
    }
    
    if(date_end!=''){
        
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

clockpickerSession = function(id,duration_course){
    
    var choices = ["00", "30"];
    
    if(duration_course==15){
       choices = ["00","15", "30","45"];
    }
    
    $('#clockpicker'+id).clockpicker({
        placement: 'bottom',
        align: 'left',
        donetext: 'Done',
        twelvehour: true,
        afterShow: function () {  // Remove all unwanted minute display.
            $(".clockpicker-minutes").find(".clockpicker-tick").filter(function (index, element) {
                return !($.inArray($(element).text(), choices) != -1)
            }).remove();
        },
        afterHourSelect: function () {  // To know if the hour is selected.
            setTimeout(function () {
                hourSelected = true;
            }, 50);
        }
    });
    
    $('#clockpicker'+id).clockpicker('show');
    
};

doStep3Web = function (nonce = "") {

	$('#loading').css('display', 'block');
	window.location.hash = '#header';
	history.pushState("", document.title, window.location.pathname
		+ window.location.search);
	var error_paypal = false;
	var params = new Object();
	params.controller = 'webController';
	params.function = 'payment';
	params.code = $('#code_university').val();
	params.username = $('#username').val();
	params.lastname = $('#lastname').val();
	params.email = $('#email').val();
	params.emailRepeat = $('#emailRepeat').val();
	params.password = $('#password').val();
	params.confirmPassword = $('#confirmPassword').val();

	var notPayment = false;
	if ($('#payPal').is(':checked')) {
		params.payment = $('#payPal').val();
	} else if ($('#brainTree').is(':checked')) {
		params.payment = $('#brainTree').val();
		params.paymentMethodNonce = nonce;
	}else if ($('#payPalCredit').is(':checked')) {
		params.payment = $('#payPalCredit').val();
	} else if ($('#payEnvivoCode').is(':checked')) {
		params.payment = $('#payEnvivoCode').val();
	} else if ($('#payFree').is(':checked')) {
		params.payment = $('#payFree').val();
	} else {
		notPayment = true;
	}

	params.code_linguameeting = $('#codigoLinguaMeeting').val();
	params.type_course = $('#typeCourse').val();
	params.id_course = $('#idCourse').val();
	params.id_section = $('#idSection').val();
	params.userLingro = $('#userLingro').val();

	if ($('#check_terms').is(':checked')) {
		params.terms = 'on';
	} else {
		params.terms = '';
	}

	if (validarFormulario(params, 'registerStudent') && !error_paypal && !notPayment) {
		var valores = JSON.stringify(params);
		sendToServer(valores, angular.element(document.getElementById('body')).scope().afterPayment);
	} else {
		$('#loading').css('display', 'none');
		$('#textMessageForm').empty();
		$('#textMessageForm').html("Complete all required fields, enter valid email, accept terms license and select the payment type");
		$('#modal_message_form').modal('show');
	}
};

modalVideo = function(id){
    
    $('#modal_video' + id).modal('show');
    
};

modalViewMoreExp = function(id){
    
    $('#modal_viewMoreExp').modal('show');
    
};

modalText = function(id){
    
    $('#modal_view' + id).modal('show');
    
};

changeArrow = function(id){
    
    
    var ele = $('.'+id);
    
    
    ele.find('[data-fa-i2svg]')
          .toggleClass('fa-chevron-down')
          .toggleClass('fa-angle-right');
    
    
    /*if (ele.hasClass('fa-chevron-down')) {
        ele.removeClass('fa-chevron-down').addClass('fa-chevron-up');
    } else {
        ele.addClass('fa-chevron-down').removeClass('fa-chevron-up');
    }*/
    
    
};

changeCaseStudyHIW = function(type){
    
  if(type=="Crystal"){
      
      $('#CaseStudyCrystal').css('display','block');
      $('#CaseStudyKate').css('display','none');
      
  }else if(type=="Kate"){
      
      $('#CaseStudyKate').css('display','block');
      $('#CaseStudyCrystal').css('display','none');
  }
  else if(type=="CrystalMedia"){
      
      $('#CaseStudyCrystalMedia').css('display','block');
      $('#CaseStudyKateMedia').css('display','none');
  }
  else if(type=="KateMedia"){
      
      $('#CaseStudyKateMedia').css('display','block');
      $('#CaseStudyCrystalMedia').css('display','none');
  }
    
};

changeStepStudent = function(step){
    
    if(step=="step1"){
      
      $('.StepHIWStudent1').css('display','block');
      $('.watchVideo').css('display','block');
      $('.StepHIWStudent2').css('display','none');
      $('.StepHIWStudent3').css('display','none');
      
  }else if(step=="step2"){
      
      $('.StepHIWStudent2').css('display','block');
      $('.StepHIWStudent1').css('display','none');
      $('.watchVideo').css('display','none');
      $('.StepHIWStudent3').css('display','none');
  }
  else if(step=="step3"){
      
      $('.StepHIWStudent3').css('display','block');
      $('.StepHIWStudent1').css('display','none');
      $('.watchVideo').css('display','none');
      $('.StepHIWStudent2').css('display','none');
  }
    
};

changeNameContact = function(name){
    
    $('#changeNameContact').empty();
    
    switch(name){
        
        case 'Professor':
            $('#changeNameContact').html("I'm a Professor");
            $('#changeNameContact').attr('value','Professor');
            break;

        case 'Instructor':
            $('#changeNameContact').html("I'm an Instructor");
            $('#changeNameContact').attr('value','Instructor');
            $('#formInstructor').removeClass('notDisplay');
            $('#formStudent').addClass('notDisplay');
            $('#envelopeInstructorSupport').removeClass('notDisplay');
            $('#envelopeStudentSupport').addClass('notDisplay');
            break;

        case 'DepartmentChair':
            $('#changeNameContact').html("I'm a Department Chair");
            $('#changeNameContact').attr('value','DepartmentChair');
            break;

        case 'CourseCoordinator':
            $('#changeNameContact').html("I'm a Course Coordinator");
            $('#changeNameContact').attr('value','CourseCoordinator');
            break;

        case 'Student':
            $('#changeNameContact').html("I'm a Student");
            $('#changeNameContact').attr('value','Student');
            $('#formStudent').removeClass('notDisplay');
            $('#formInstructor').addClass('notDisplay');
            $('#envelopeInstructorSupport').addClass('notDisplay');
            $('#envelopeStudentSupport').removeClass('notDisplay');
            break;

        case 'Individual':
            $('#changeNameContact').html("I'm an Independent Learner");
            $('#changeNameContact').attr('value','Individual');
            break;

        case 'ProspectiveCoach':
            $('#changeNameContact').html("I'm a Prospective Coach");
            $('#changeNameContact').attr('value','ProspectiveCoach');
            break;

        case 'Other':
            $('#changeNameContact').html("Other");
            $('#changeNameContact').attr('value','Other');
            break;
            
        default:
            
            $('#changeNameContact').html("Other");
            $('#changeNameContact').attr('value','Other');
            break;


    };
    
};

translateTestimonial = function(language,number){
    
    if(language=='spanish'){
        
        $('#testimonialSpanish' + number).removeClass('notDisplay');        
        $('#testimonialEnglish' + number).addClass('notDisplay');
        
        
    }else if(language=='english'){
        
        $('#testimonialEnglish' + number).removeClass('notDisplay');        
        $('#testimonialSpanish' + number).addClass('notDisplay');
        
    }
    
};


$(document).ready(function () {

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
        autoplay: false,
        prevArrow: '<i class="fas fa-chevron-left colorBase4 arrowSliderLeft cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase4 arrowSliderRight cursor_pointer"></i>'

      });
      
      $(".centerCarouselMedia").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: false,
        prevArrow: '<i class="fas fa-chevron-left colorBase4 arrowSliderLeft cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase4 arrowSliderRight cursor_pointer"></i>'

      });
      
      $(".universitiesCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 3,
        autoplay:true,
        autoplaySpeed: 2000,
        arrows: false

      });
      
      $(".universitiesCarouselMedia").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay:true,
        autoplaySpeed: 2000,
        arrows: false

      });
      
      $(".testimonialsCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed: 7000,
        prevArrow: '<i class="fas fa-chevron-left colorWhite arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorWhite arrowSliderRightTest cursor_pointer"></i>'

      });
      
      $(".testimonialsInstCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed: 7000,
        prevArrow: '<i class="fas fa-chevron-left colorWhite arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorWhite arrowSliderRightTest cursor_pointer"></i>'

      });
      
      $(".experiencesHomeCarousel").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay:true,
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
        autoplay:true,
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
        autoplay:true,
        autoplaySpeed: 5000,
        prevArrow: '<i class="fas fa-chevron-left colorBase2 arrowSliderLeftTest cursor_pointer"></i>',
        nextArrow: '<i class="fas fa-chevron-right colorBase2 arrowSliderRightTest cursor_pointer"></i>'

      });
      
    $('#selectNumber').change(function(){
        
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
        
        if ( params.type==0  || params.duration==0 || params.number==0){
            
            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');
            
            if(params.type==0){
                
                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');
                
            }else{
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }
            
            if(params.duration==0){
                
                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');
                
            }else{
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }
            
            if(params.number==0){
                
                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');
                
            }else{
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }
            
        }else{
            
            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');
            
	    
	    var valores = JSON.stringify(params);
	    sendToServer(valores, function(Data){
                
                $('#resultPricingSearch').empty();
                if(Data.resultado==''){
                    
                    $('#resultPricingSearch').html('This session package does not exist.');
                }
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });
            
        }
        
        
    });
    
    $('#selectDuration').change(function(){
        
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
        
        if ( params.type==0  || params.duration==0 || params.number==0){
            
            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');
            if(params.type==0){
                
                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');
                
            }else{
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }
            
            if(params.duration==0){
                
                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');
                
            }else{
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }
            
            if(params.number==0){
                
                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');
                
            }else{
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }
            
        }else{
            
            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');
	    
	    var valores = JSON.stringify(params);
	    sendToServer(valores, function(Data){
                
                $('#resultPricingSearch').empty();
                if(Data.resultado==''){
                    
                    $('#resultPricingSearch').html('This session package does not exist.');
                }
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });
            
        }
        
        
    });
    
    $('#selectType').change(function(){
        
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
        
        if ( params.type==0  || params.duration==0 || params.number==0){
            
            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)');
            if(params.type==0){
                
                $('#selectType').addClass('formPricingLinguaError');
                $('#selectType').removeClass('formPricingLingua');
                
            }else{
                $('#selectType').removeClass('formPricingLinguaError');
                $('#selectType').addClass('formPricingLingua');
            }
            
            if(params.duration==0){
                
                $('#selectDuration').addClass('formPricingLinguaError');
                $('#selectDuration').removeClass('formPricingLingua');
                
            }else{
                $('#selectDuration').removeClass('formPricingLinguaError');
                $('#selectDuration').addClass('formPricingLingua');
            }
            
            if(params.number==0){
                
                $('#selectNumber').addClass('formPricingLinguaError');
                $('#selectNumber').removeClass('formPricingLingua');
                
            }else{
                $('#selectNumber').removeClass('formPricingLinguaError');
                $('#selectNumber').addClass('formPricingLingua');
            }
            
        }else{
            
            $('#selectType').removeClass('formPricingLinguaError');
            $('#selectDuration').removeClass('formPricingLinguaError');
            $('#selectNumber').removeClass('formPricingLinguaError');
            $('#selectType').addClass('formPricingLingua');
            $('#selectDuration').addClass('formPricingLingua');
            $('#selectNumber').addClass('formPricingLingua');
	    
	    var valores = JSON.stringify(params);
	    sendToServer(valores, function(Data){
                
                $('#resultPricingSearch').empty();
                if(Data.resultado==''){
                    
                    $('#resultPricingSearch').html('This session package does not exist.');
                }
                
                
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });
            
        }
        
        
    });
    
    $('#unlimetedExperiences').change(function(){
        
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
        
        if ( params.type==0  || params.duration==0 || params.number==0){
            
            $('#resultPricingSearch').empty();
            $('#resultPricingSearch').html('Please complete the missing field(s)')
            
        }else{
            
            
	    
	    var valores = JSON.stringify(params);
	    sendToServer(valores, function(Data){
                
                $('#resultPricingSearch').empty();
                $('#resultEstimator').empty();
                $('#resultEstimator').html(Data.resultado);
            });
            
        }
        
        
    });

    
});

closeGetStarted = function(){
  
    $('#navbarWeb').addClass('fixed-top');
    $('#addonHeader').remove();
    
};