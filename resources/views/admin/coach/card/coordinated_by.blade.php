<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light">
        <span class="text-corporate-dark-color fw-bold">
            <i class="fa fa-graduation-cap me-1"></i>  Coordinated by
        </span>
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
                    @foreach ($coaches as $coachCoordinator)

                        <tr>
                            <td>
                                <a href="{{route('get.admin.coach.show', $coachCoordinator->id)}}"
                                   class="text-primary me-3" title="Show coach">
                                    {{$coachCoordinator->writeFullName()}}
                                </a>
                            </td>
                            @if ($showAction)
                                <td>
                                    <a  href="{{route('get.admin.coach.remove_coordinated', [$coachCoordinator->id, $coach->hashId()])}}"
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
                        Este coach no depende de ningún coordinador.
                    </div>

                    <a href="{{route('get.admin.coach.assign_coordinator', $coach->hashId())}}"
                       title="Assign coach to {{$coach->writeFullName()}}"
                       class="open-modal d-block mt-3 float-end"

                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title='Assign coordinated coach'>
                        <i class="fa fa-plus text-success"></i> Assign coach coordinator
                    </a>
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
    </div>
</div>
