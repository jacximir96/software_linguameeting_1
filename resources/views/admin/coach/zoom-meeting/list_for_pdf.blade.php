@extends('layouts.app_pdf')

@section('content')

    @include('common.file.head')

    <div class="content" style="padding-top:3cm; padding-left:1.5cm;">

        <table border="0" align="left" class="w-100 fs-10"  cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th class="fs-14 text-start" colspan="3">List of zoom meetings</th>
            </tr>
            </thead>
        </table>

        <table border="0" align="left" class="w-100 mt-10 fs-10"  cellpadding="0" cellspacing="0">
            <thead>
            <tr >
                <th class="text-start h-30"><strong>Coach</strong></th>
                <th class="text-start"><strong>Join Url</strong></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="3"></td>
            </tr>
            @forelse ($coaches as $coach)
                <tr>
                    <td class="w-25">
                        {{$coach->writeFullName()}}
                    </td>
                    <td>
                        @if ($coach->zoomMeeting)
                            {{$coach->zoomMeeting->join_url}}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        @if ($coach->zoomUser)
                            {{$coach->zoomUser->zoom_email}}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>

                @if ($loop->iteration % 15 === 0)
                    </tbody>
                    </table>
                    </div>
                    <div style="page-break-after: always"></div>

                    <div class="content" style="padding-top:3cm; padding-left:1.5cm;">
                        <table border="0" align="left" class="w-100 fs-10"  cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="fs-14 text-start" colspan="3">List of zoom meetings</th>
                            </tr>
                            </thead>
                        </table>

                        <table border="0" align="left" class="w-100 mt-10 fs-10"  cellpadding="0" cellspacing="0">
                            <thead>
                            <tr >
                                <th class="text-start h-30"><strong>Coach</strong></th>
                                <th class="text-start"><strong>Join Url</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3"></td>
                            </tr>

                @endif

            @empty
                <tr>
                    <td class="text-center" colspan="3">
                        Coaches not found
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
@endsection
