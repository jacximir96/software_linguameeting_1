<table>
    <thead>
        <tr>
            <th colspan="6">List of instructors</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><strong>Last Name</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Role</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>University</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($instructors as $instructor)
        <tr>
            <td>{{$instructor->lastname}}</td>
            <td>
                {{$instructor->name}}

                @if ( ! $instructor->isActive())
                    (Disabled)
                @endif

                @if ( $instructor->isDeleted()!='')
                    (Deleted)
                @endif
            </td>
            <td>{{$instructor->getRoleName()->first()}}</td>
            <td>{{$instructor->email}}</td>
            <td>{{$instructor->university->first()->name ?? ''}}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Instructors not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
