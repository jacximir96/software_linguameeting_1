@extends('layouts.app')

@section('content')

<div class="row">

    <div class="col-md-6">

        <div class="card chart-card-background">

            <div class="card-body float-none">

                <div class="">
                    <div class="title-dashboard-circle float-start">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" fill="white" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                    </div>

                    <div class="title-dashboard">

                        <span><strong>Student Attendance</strong></span>
                    </div>
                </div>



                <div class="float-none mt-5">

                    <span class="text-corporate-dark-color">Falling back (3)</span>
                    <div class="bar-dashboard-background">
                        <div class="bar-dashboard-fill bg-corporate-dark-color" style="width:30%;"></div>
                    </div>

                    <span class="text-corporate-dark-color">Doing ok (5)</span>
                    <div class="bar-dashboard-background">
                        <div class="bar-dashboard-fill bg-corporate-color" style="width:50%;"></div>
                    </div>

                    <span class="text-corporate-dark-color">Doing well (12)</span>
                    <div class="bar-dashboard-background">
                        <div class="bar-dashboard-fill color-bar-extra" style="width:70%;"></div>
                    </div>

                </div>

            </div>


        </div>

    </div>

    <div class="col-md-6">

        <div class="card chart-card-background">

            <div class="card-body float-none">

                <div class="">
                    <div class="title-dashboard-circle float-start">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" fill="white" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>

                    </div>

                    <div class="title-dashboard">

                        <span><strong>Registered students</strong></span>
                    </div>
                </div>

                <div class="chartRegisteredStudents float-none mt-4">

                    <canvas id="registeredStudents"></canvas>

                    </canvas>

                </div>

            </div>

        </div>




    </div>



</div>

<div class="row margin-top-20">

    <div class="col-md-12">

        <div class="card chart-card-background">

            <div class="card-body float-none">

                <div class="">
                    <div class="title-dashboard-circle float-start">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" fill="white" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C49.7 0 64 14.3 64 32V48l69-17.2c38.1-9.5 78.3-5.1 113.5 12.5c46.3 23.2 100.8 23.2 147.1 0l9.6-4.8C423.8 28.1 448 43.1 448 66.1V345.8c0 13.3-8.3 25.3-20.8 30l-34.7 13c-46.2 17.3-97.6 14.6-141.7-7.4c-37.9-19-81.3-23.7-122.5-13.4L64 384v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V400 334 64 32C0 14.3 14.3 0 32 0zM64 187.1l64-13.9v65.5L64 252.6V318l48.8-12.2c5.1-1.3 10.1-2.4 15.2-3.3V238.7l38.9-8.4c8.3-1.8 16.7-2.5 25.1-2.1l0-64c13.6 .4 27.2 2.6 40.4 6.4l23.6 6.9v66.7l-41.7-12.3c-7.3-2.1-14.8-3.4-22.3-3.8v71.4c21.8 1.9 43.3 6.7 64 14.4V244.2l22.7 6.7c13.5 4 27.3 6.4 41.3 7.4V194c-7.8-.8-15.6-2.3-23.2-4.5l-40.8-12v-62c-13-3.8-25.8-8.8-38.2-15c-8.2-4.1-16.9-7-25.8-8.8v72.4c-13-.4-26 .8-38.7 3.6L128 173.2V98L64 114v73.1zM320 335.7c16.8 1.5 33.9-.7 50-6.8l14-5.2V251.9l-7.9 1.8c-18.4 4.3-37.3 5.7-56.1 4.5v77.4zm64-149.4V115.4c-20.9 6.1-42.4 9.1-64 9.1V194c13.9 1.4 28 .5 41.7-2.6l22.3-5.2z"/></svg>

                    </div>

                    <div class="title-dashboard">

                        <span><strong>Session Completion</strong></span>
                    </div>
                </div>


                <div class="float-none mt-5">
                    <div>
                        <span class="text-corporate-dark-color">25% completed / 75% missed</span>
                        <div class="bar-dashboard-big-background">
                            <div class="bar-dashboard-big-fill color-bar-extra" style="width:25%;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>

</div>

<div class="row mt-5">


    <div class="col-md-6">

        <a class="a-title">
            <div class="">
                Student Activity <span><a class="text-corporate-color" href="#"><u>Download Gradebook</u></a></span>
            </div>
        </a>

    </div>

    <div class="col-md-6">

        <div class="float-end">
            <div class="input-group rounded">
                <select class="form-select " aria-label="">
                    <option value="">Filters</option>
                    <option value="">Course_name_1</option>
                    <option value="">Section_name_1</option>
                </select>
            </div>
        </div>

        <div class="text-right  float-end">
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>



    </div>

</div>

<div class="card float-none margin-top-10 card-list-courses-instructor">

    <div class="card-body">

        <table id="table-instructor" class="table" data-paging="false" data-searching="false" data-ordering="false">
            <thead>
                <tr>
                    <th class="">STUDENT</th>
                    <th class="">DATE</th>
                    <th>SESSION</th>
                    <th class="">FEEDBACK</th>
                    <th>RECORDING</th>
                    <th>COACH</th>
                    <th>COURSE</th>
                    <th>SECTION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>

                <!-- href="{{route('get.admin.course.coaching_form.create.update.academic_dates', 555)}}-->

                <tr>
                    <td><a class="text-corporate-color" href="{{route('get.instructor.students.show', 1188)}}"><u>Kristin Watson</u></a></td>
                    <td class="">
                        <u>Mar 03, 2023</u>
                    </td>
                    <td>1</td>
                    <td class="cursor_pointer">
                        1
                    </td>
                    <td>
                        <a href="" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"/></svg>
                        </a>
                    </td>
                    <td>Maria Centeno</td>
                    <td>
                        <u>Spring 2023 SPAN 1501</u>
                    </td>

                    <td>
                        Spring 2023 SPAN 1501 Section 1
                    </td>

                    <td>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <option value="">Actions </option>
                            <option value="">Add make-up for purchase</option>
                            <option value="">Access student portal</option>
                            <option value="">Change course/section</option>
                            <option value="">Seelogin information</option>
                            <option value="">Delete Student</option>
                            <option value="">Accommodations</option>
                            <option value="">Send Email</option>
                        </select>

                    </td>

                </tr>

            </tbody>
        </table>

    </div>

</div>


@endsection
