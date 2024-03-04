<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.multidatespicker.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/moment-timezone.min.js')}}"></script>
<script src="{{asset('js/notify.min.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/ckeditor4/ckeditor.js')}}"></script>
<script src="{{asset('js/fullcalendar/lib/main.min.js')}}"></script>
<script src="{{asset('js/fullcalendar/lib/locales/es.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/web/rater.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@if (isset($loadExpanderJs))
    <script src="{{asset('js/jquery.expander.min.js')}}"></script>
@endif

<script src="{{asset('js/linguameeting/functions.js?v=1.04')}}"></script>
<script src="{{asset('js/linguameeting/modal.js?v=1.06')}}"></script>
<script src="{{asset('js/linguameeting/main.js?v=1.07')}}"></script>
<script src="{{asset('js/linguameeting/coaching-form.js?v=1.06')}}"></script>
<script src="{{asset('js/linguameeting/search-form.js?v=1.08')}}"></script>
<script src="{{asset('js/linguameeting/users.js?v=1.03')}}"></script>
<script src="{{asset('js/linguameeting/course.js?v=1.02')}}"></script>
<script src="{{asset('js/linguameeting/coach.js?v=1.00')}}"></script>
<script src="{{asset('js/linguameeting/billing.js?v=1.00')}}"></script>
<script src="{{asset('js/linguameeting/student.js?v=1.00')}}"></script>
<script src="{{asset('js/linguameeting/front_back.js?v=1.00')}}"></script>

@auth
@if (user()->isInstructor())
    <script src="{{asset('js/chart/Chart.min.js')}}"></script>
    <script src="{{asset('js/linguameeting/instructor.js?v=1.00')}}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

@endif
@endauth

