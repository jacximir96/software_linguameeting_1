<div class="row mt-4">
    <div class="col-12">
        <span class="h6 fw-bold">Course Information</span>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-4 opacity-75">
        <i class="fa fa-chalkboard-teacher fa-fw"></i> Name
    </div>
    <div class="col-xl-8 ">
        {{$courseSummary->course()->name}}
    </div>
</div>

@if ($courseSummary->course()->serviceType->hasConversationGuide())
<div class="row mt-3">
    <div class="col-xl-4 opacity-75">
        <i class="fa fa-clipboard-list fa-fw"></i> Sessions
    </div>
    <div class="col-xl-8">

        @php $conversationPackage = $courseSummary->course()->conversationPackage; @endphp
        <span class="d-block">{{$conversationPackage->number_session}} Sessions</span>

        <span class="d-block">{{$conversationPackage->sessionType->name}}</span>
        <span class="d-block">{{$conversationPackage->duration_session}} Minutes</span>
        <span class="d-block">{{$courseSummary->course()->language->name}} Language<br></span>
    </div>
</div>
@endif

<div class="row mt-4">
    <div class="col-xl-4 opacity-75">
        Total sections
    </div>
    <div class="col-xl-8 d-flex justify-content-start">
        {{$courseSummary->course()->section->count()}}
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 opacity-75">
        <hr>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-sm-4 col-md-6 col-xl-4">
        <span class="bg-white text-corporate-color rounded p-1 fw-bold">
             Total Price
        </span>
    </div>
    <div class="col-12 col-sm-8 col-md-6 col-xl-8 mt-3  mt-sm-0">
        <span class="bg-white text-corporate-color rounded p-1 fw-bold">{{$courseSummary->formatPrice($courseSummary->course()->price())}}</span>
    </div>
</div>
