<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-chalkboard-teacher me-1"></i>
                    Student details
                </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Fullname', 'value' => $student->writeFullName(), 'valueIsBold' => true])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'ID', 'value' => $student->id])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Email', 'value' => $student->email])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Country', 'value' => $student->country->name])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Timezone', 'value' => $student->timezone->name])
            </div>
        </div>


        <div class="row gx-3 mb-4">

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Skype', 'value' => $student->skype ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Phone', 'value' => $student->phone ?? '-'])
            </div>

            <div class="col-md-4">
                @include('common.card_field', ['tag' => 'Phone-WhatsApp', 'value' => $student->whatsapp ?? '-'])
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <div class="col-md-6">
                <label class="small mb-1 d-block fw-bold "></label>
                <a href="{{route('get.admin.student.edit', $student->hashId())}}" class="text-primary me-3"><i class="fa fa-edit"></i> Edit</a>

                <a  href="{{route('get.impersonate.start',$student->hashId())}}"
                    class="me-3"
                    title="Access as {{$student->name}}">
                    <i class="fa fa-user-friends"></i> Simulation as {{$student->name}}
                </a>

            </div>
        </div>

    </div>
</div>
