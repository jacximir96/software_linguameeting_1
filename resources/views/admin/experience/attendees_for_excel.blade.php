<table>
    <thead>
        <tr>
            <th colspan="3">{{$experience->title}}</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><strong>Last Name</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Attendance</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3"></td>
    </tr>
    @forelse ($registeredUsers as $registeredUser)

        <tr>
            <td>{{$registeredUser->user->lastname}}</td>
            <td>{{$registeredUser->user->name}}</td>
            <td>{{$registeredUser->user->email}}</td>
            <td>{{$registeredUser->attendance ? '1' : '0'}}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Attendees not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
