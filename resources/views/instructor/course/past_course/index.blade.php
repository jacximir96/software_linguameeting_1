@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

<div class="row">
    <div class="col-md-12">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Past Courses</strong></span>
    </div>
</div>

<div class="row margin-top-20"></div>
<div class="row margin-top-10"></div>

<!-- Incluir jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<!-- Incluir SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<button onclick="exportTableToExcel()">Exportar a Excel</button>

@if (method_exists($data, 'pastCourses') && count($data->pastCourses()) > 0)
    @include('instructor.course.past_course.table', [
        'sections' => $data->commonResponse()->sections(),
    ])
@else
    @include('admin.instructor.card.no_data', [
        'message' => "Don't Have Data",
    ])
@endif

<script>
$(document).ready(function() {
    $('#table-instructor').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
    });
});

function exportTableToExcel() {
    var table = document.getElementById("table-instructor");
    var workbook = XLSX.utils.table_to_book(table, {sheet:"Sheet JS"});
    XLSX.writeFile(workbook, "ExportacionTabla.xlsx");
}
</script>



@endsection