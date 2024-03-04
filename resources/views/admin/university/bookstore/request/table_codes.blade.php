<table id="datatablesSimple" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
    <thead>
    <tr class="small">
        <th>Code</th>
        <th>Used</th>
        <th>Student</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($codes as $code)
        <tr>
            <td>
                {{$code->code}}
            </td>
            <td>
                @if ($code->isUsed())
                    <span class="badge bg-success">Sí</span>
                @else
                    <span class="badge bg-danger">No</span>
                @endif
            </td>
            <td>
                @if ($code->payment)
                    {{$code->payment->writeFullName()}}
                @else
                    -
                @endif

                @if ($code->isUsed())
                    @if ($code->used_at)
                        <span class="small d-block">{{toDatetimeInOneRow($code->used_at) ?? '-'}}</span>
                    @endif
                @endif
            </td>
            <td>
                @include('admin.university.bookstore.code.actions', ['code' => $code])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
