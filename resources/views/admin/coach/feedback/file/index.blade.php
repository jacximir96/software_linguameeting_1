@extends('layouts.app_pdf')

@section('content')

    @include('common.file.head')

    <div class="content">

        @if ($wrapper->language()->isSpanish())
            @include('admin.coach.feedback.file.header_es')
        @else
            @include('admin.coach.feedback.file.header_en')
        @endif

        <table border="1" align="left" class="w-100 mt-20" cellpadding="1" cellspacing="0">
            <thead>
            <tr>
                <th>FEEDBACK</th>
                <th>OBSERVATIONS</th>
                <th>COMMENTS</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($wrapper->feedbackSortedByTypes() as $typeFeedback)

                <tr>
                    <td colspan="3">
                        <span class="bold text-corporate-color">
                             @if ($wrapper->language()->isSpanish())
                                {{$types->get($typeFeedback->id())->es_title}}
                            @else
                                {{$types->get($typeFeedback->id())->eng_title}}
                            @endif
                        </span>
                    </td>
                </tr>

                @foreach ($typeFeedback->subtypes() as $subtypeFeedback)
                    <?php //dd($observations->get($subtypeFeedback->observationId())) ?>
                    <tr style="page-break-inside: auto">
                        <td class="ps-5 w-30 wa-top">{{$subtypes->get($subtypeFeedback->id())->titleByLanguage($wrapper->language())}}</td>
                        <td class="w-35 wa-top">
                            @if ($observations->get($subtypeFeedback->observationId()))
                                {{$observations->get($subtypeFeedback->observationId())->titleByLanguage($wrapper->language())}}
                            @else
                                -
                            @endif
                        </td>
                        <td class="w-35 wa-top">

                            @if($observations->get($subtypeFeedback->suggestionId()))
                                {{$observations->get($subtypeFeedback->suggestionId())->titleByLanguage($wrapper->language())}}
                            @else
                                -
                            @endif


                            @if ($subtypeFeedback->hasAlternativeText())
                                <br>
                                {{ $subtypeFeedback->alternativeText() ?? '-' }}

                            @endif

                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
