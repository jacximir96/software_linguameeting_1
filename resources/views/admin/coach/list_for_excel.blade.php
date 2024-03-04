<table>
    <thead>
        <tr>
            <th colspan="6">List of coaches</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><strong>Last Name</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Nickname</strong></th>
            <th><strong>Country</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($coaches as $coach)
        <tr>
            <td>{{$coach->lastname}}</td>
            <td>
                {{$coach->name}}

                @if ( ! $coach->isActive())
                    (Disabled)
                @endif

                @if ( $coach->isDeleted()!='')
                    (Deleted)
                @endif
            </td>
            <td>{{$coach->email}}</td>
            <td>{{$coach->nickname ?? ''}}</td>
            <td>{{$coach->country->name ?? ''}}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Coaches not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
