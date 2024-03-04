<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light">
        <span class="text-corporate-dark-color fw-bold">
            <i class="fa fa-graduation-cap me-1"></i>  Coordinator of
        </span>

        <a href="{{route('get.admin.coach.assign_coordinated', $coach->hashId())}}"
           title="Assign coach to {{$coach->writeFullName()}}"
           class="open-modal d-block text-success fw-bold"

           data-modal-reload="yes"
           data-reload-type="parent"
           data-modal-title='Assign coordinated coach'>
            <i class="fa fa-plus text-success"></i> Assign coach
        </a>
    </div>
    <div class="card-body">

        <div class="row d-none d-sm-block">
            <div class="col-12">
                @if ($coaches->count())
                <table  class="table table-hover">
                    <thead>
                    <tr>
                        <th class="w-75">Coach</th>
                        @if ($showAction)
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($coaches as $coachCoordinated)

                        <tr>
                            <td>
                                <a href="{{route('get.admin.coach.show', $coachCoordinated->id)}}"
                                   class="text-primary me-3" title="Show coach">
                                    {{$coachCoordinated->writeFullName()}}
                                </a>
                            </td>
                            @if ($showAction)
                                <td>
                                    <a  href="{{route('get.admin.coach.remove_coordinated', [$coach->hashId(), $coachCoordinated->id])}}"
                                        onclick="return confirm('Are you sure you want to delete this coach relationship?');"
                                        title="Remove relationship ">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <div class="bg-light p-2 rounded">
                        Este coach no es coordinador de ningún otro.
                    </div>
                @endif


            </div>
        </div>

        <div class="d-block d-sm-none">

            @foreach ($coaches as $coachCoordinated)

                <div class="row">

                    <div class="col-12">
                        <span class="fw-bold d-block">
                            Coordinator of assistant
                        </span>
                        <div class="d-block">
                            <a href="{{route('get.admin.coach.show', $coachCoordinated->id)}}"
                               class="text-primary me-3" title="Show coach">
                                {{$coachCoordinated->writeFullName()}}
                            </a>
                            @if ($showAction)
                                <a  href="#"
                                    onclick="return confirm('Are you sure you want to delete this coach relationship?');"
                                    title="Remove relationship ">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col-12 text-end mt-0">
                <a href="{{route('get.admin.coach.coordinator_of.show_all', $coach->hashId())}}"
                   class="open-modal d-block mt-1 text-primary float-end"
                   data-modal-size="modal-md"
                   data-modal-reload="yes"
                   data-reload-type="parent"
                   data-modal-title="Show all coach coordinated by: {{$coach->writeFullName()}}">
                    <i class="fa fa-list"></i> Show all
                </a>
            </div>
        </div>

    </div>




</div>
