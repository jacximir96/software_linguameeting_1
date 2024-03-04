@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color ">
            <span class="fw-bold">
                <i class="fas fa-calendar-day me-1"></i>
                Create Make-up
            </span>
            <div>

                <span class="d-inline-block me-2">
                    You have <span class="fw-bold">{{$makeupAvailability->makeupsCollection()->countComplimentary()->get()}} complimentary</span> Make-Ups
                </span>
                <span class="d-inline-block me-2">
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <span class="d-inline-block">
                    You have <span class="fw-bold">{{$makeupAvailability->numMaxAvailableForPurchase()->get()}} Make-Ups for purchase</span>

                    @if ($makeupAvailability->numMaxAvailableForPurchase()->get())
                        <a href="{{route('get.student.session.book.makeup.buy', $enrollmentSession->enrollment->hashId())}}"
                           class="text-white bg-corporate-color p-1 rounded fw-bold open-modal "
                           data-modal-reload="yes"
                           data-modal-height="h-90"
                           data-modal-size="modal-lg"
                           data-modal-title="Buy Make-up"
                           title="Buy Make-ups">Buy Make-ups</a>
                    @endif
                </span>
            </div>
        </div>

        <div class="card-body mb-5">
            <div class="row mt-0 d-flex justify-content-center">
                <div class="col-xl-6  align-items-stretch">
                    @if ($isBoookedSession)
                        @include('student.enrollment.session.makeup.missed_booked_session')
                    @else
                        @include('student.enrollment.session.makeup.missed_not_booked_session')
                    @endif

                    <div class="row mt-5">
                        <div class="col-12">
                            @include('student.enrollment.session.makeup.weeks_selector')
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12" id="div-info-weeks">
                            <div class="row">
                                <div class="col-12" id="week-browser"></div>
                                <div class="col-12" id="form-other-options" style="display:none">
                                    @include('student.enrollment.session.makeup.form_search_more_options', ['searchCoachFrom' => $searchCoachForm])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 align-items-stretch " id="div-info-weeks">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-center" style="height: 500px" id="select-warning">
                            <span class="d-block bg-corporate-color-light  p-2 rounded font-weight-bold text-decoration-underline">
                                <i class="fa fa-arrow-left me-2"></i> <span class="">Select Coaching week in the options on the left</span>
                            </span>
                        </div>
                        <div class="col-12" id="week-browser"></div>
                        <div class="col-12" id="form-other-options" style="display:none">
                            @include('student.enrollment.session.makeup.form_search_more_options')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

                $(document).ready(function () {

                    jQuery(document).on('click', '.eventWeekMake', function (event) {

                        $('#select-warning').remove()
                        $('#form-other-options').fadeOut()
                        $('#form-other-options').hide()
                        $('#week-browser').html('')
                        $('#div-title-more-options').addClass('mt-4')

                        var weekId = $(this).data('week-id')
                        $('.div-week').removeClass('border-selected-week')
                        $('#div-week-'+weekId).addClass('border-selected-week')
                        $('#div-info-weeks').addClass('div-info-weeks')


                        $('#dateSession').prop("disabled", false);
                        $('#timeId').prop("disabled", false);
                        $('#coach').prop("disabled", false);


                        $("#dateSession").datepicker("destroy");

                        $("#dateSession").datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd",
                            numberOfMonths: 1,
                            minDate: $(this).data('date-start'),
                            maxDate: $(this).data('date-end'),
                            firstDay: 1
                        });

                        var url = "{{$urlApiShowFormSearch}}"

                        jQuery.ajax({
                            url: url,
                            type: "GET",
                            data: [],
                            context: this,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response, data) {

                                $('#week-browser').hide();
                                $('#week-browser').html(response);

                                $('#week-browser').fadeIn('slow');
                                $('#form-other-options').fadeIn('slow');
                            },
                            error: function (response, textStatus, xhr) {

                                $.notify(response, {
                                    className: "error",
                                    position: "top-center",
                                    showDuration: 400,
                                    hideDuration: 400,
                                    autoHideDelay: 2000,
                                });
                            },
                        });
                    });

                    jQuery(document).on('click', '.weekNavigator', function (event) {

                        event.preventDefault()

                        var url = $(this).attr('href')

                        jQuery.ajax({
                            url: url,
                            type: "GET",
                            data: [],
                            context: this,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response, data) {

                                $('#week-browser').hide();
                                $('#week-browser').html(response);

                                $('#week-browser').fadeIn('slow');
                                $('#form-other-options').fadeIn('slow');
                            },
                            error: function (response, textStatus, xhr) {

                                $.notify(response, {
                                    className: "error",
                                    position: "top-center",
                                    showDuration: 400,
                                    hideDuration: 400,
                                    autoHideDelay: 2000,
                                });
                            },
                        });

                    });
                });

    </script>
@endsection
