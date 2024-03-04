<table>
    <thead>
        <tr>
            <th colspan="6">List of universities</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><strong>Name</strong></th>
            <th><strong>Country</strong></th>
            <th><strong>Timezone</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($universities as $university)
        <tr>
            <td>{{$university->name}}</td>
            <td>{{$university->country->name}}</td>
            <td>{{$university->timezone->name}}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Universities not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
