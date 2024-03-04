<table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
    <thead>
    <tr>
        <th>#</th>
        <th>ID</th>
        <th class="w-15">Code</th>
        <th class="w-15">University</th>
        <th class="w-20">Course</th>
        <th>Used</th>
        <th class="w-15">Student/Concept</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($codes as $code)

        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$code->id}}</td>
            <td>{{$code->code}}</td>
            <td>
                @if ($code->payment)
                    @if ($code->payment->hasDetailWithEnrollment())
                        <span class="d-block">{{$code->payment->enrollment()->course()->university->name}}</span>
                    @else
                        -
                    @endif
                @else
                    @if ($code->request)
                        {{$code->request->university->name}}
                    @else
                        -
                    @endif
                @endif
            </td>
            <td>
                @if ($code->payment)
                    @if ($code->payment->hasDetailWithEnrollment())
                        <span class="d-block">{{$code->payment->enrollment()->course()->name}}</span>
                        <span class="d-block small">{{$code->payment->enrollment()->course()->conversationPackage->name}}</span>
                        <span class="d-block small">{{$code->payment->enrollment()->course()->conversationPackage->isbn}}</span>
                    @else
                        -
                    @endif
                @else
                    -
                @endif
            </td>
            <td>
                @if ($code->isUsed())
                    <span class="badge bg-success">Sí</span>
                @else
                    <span class="badge bg-danger">No</span>
                @endif
            </td>
            <th class="">
                @if ($code->payment)
                    @if ($code->payment->hasDetailWithEnrollment())
                        <a href="{{route('get.admin.student.show', $code->payment->enrollment()->user->hashId())}}" target="_blank">
                            {{$code->payment->enrollment()->user->writeFullName()}}
                        </a>
                    @else
                        {{$code->payment->detail->first()->writePayable()}}
                    @endif
                @else
                    -
                @endif
            </th>
            <td class="">
                @if ($code->payment)
                    {!! toDatetimeInTwoRow($code->payment->paid_at, $timezone->name) !!}
                @else
                    -
                @endif
            </td>
            <td>
                @include('admin.university.bookstore.code.actions', ['code' => $code])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
