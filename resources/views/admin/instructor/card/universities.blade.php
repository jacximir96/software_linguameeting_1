<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-building me-1"></i>  Universities
        </span>
    </div>
    <div class="card-body">

        <div class="row d-none d-sm-block">
            <div class="col-12">

                <table class="table table-hover">
                    <thead>
                    <tr clasS="small">
                        <th class="w-75">Name</th>
                        <th>Action</th>
                    </tr>

                    </thead>

                    <tbody>

                    @forelse ($instructor->university as $university)
                        <tr>
                            <td> {{$university->name}}</td>

                            <td>
                                <a href="{{route('get.admin.university.instructor.delete', [$instructor->hashId(), $university->hashId()])}}"
                                   onclick="return confirm('Are you sure to remove this university?');"
                                   class="btn btn-sm btn-danger d-none">
                                    Delete
                                </a>

                                <a href="{{route('get.admin.university.instructor.delete', [$instructor->hashId(), $university->hashId()])}}"
                                   onclick="return confirm('Are you sure to remove this university?');"
                                   class="d-block">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center small">
                                <span class="bg-warning text-white p-1 rounded">Instructor without university</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        <div class="row d-block d-sm-none">
            @foreach ($instructor->university as $university)
                <div class="col-12">
                    <span class="fw-bold">
                        {{$university->name}}
                    </span>


                    <a href="{{route('get.admin.university.instructor.delete', [$instructor->hashId(), $university->hashId()])}}"
                       onclick="return confirm('Are you sure to remove this university?');"
                       class="">
                        <i class="fa fa-times text-danger ms-3"></i>
                    </a>

                </div>
            @endforeach
        </div>

        <div class="row mt-2">
            <div class="col-12 text-end">

                <a href="{{route('get.admin.university.instructor.assign', $instructor->hashId())}}"
                   class="open-modal text-success"
                   data-modal-reload="yes"
                   data-reload-type="parent"
                   data-modal-title='Assign University'>
                    <i class="fa fa-plus"></i> Assign University
                </a>
            </div>
        </div>

    </div>
</div>
