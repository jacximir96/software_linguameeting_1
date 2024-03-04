<table>
    <thead>
        <tr>
            <th colspan="4">List of zoom meetings</th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th><strong>Last Name</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Zoom Email</strong></th>
            <th><strong>Meeting Join Url</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($coaches as $coach)
        <tr>
            <td>
                {{$coach->lastname}}
            </td>
            <td>
                {{$coach->name}}
            </td>
            <td>
                @if ($coach->zoomUser)
                    {{$coach->zoomUser->zoom_email}}
                @else
                    -
                @endif
            </td>
            <td>
                @if ($coach->zoomMeeting)
                    {{$coach->zoomMeeting->join_url}}
                @else
                    -
                @endif
            </td>
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
