@extends('layouts.app')

@section('content')

<div class="row margin-top-20">

    <div class="col-md-6">

        <div class="cursor_pointer custom-color-background-instructor padding-5" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            <span class="text-corporate-dark-color align-svg">
                <svg fill="#186e74" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34zm192-34l-136-136c-9.4-9.4-24.6-9.4-33.9 0l-22.6 22.6c-9.4 9.4-9.4 24.6 0 33.9l96.4 96.4-96.4 96.4c-9.4 9.4-9.4 24.6 0 33.9l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0l136-136c9.4-9.2 9.4-24.4 0-33.8z"/></svg>

            </span>

            <span class="box_sessions_tag"><strong> All Languages</strong></span> 
        </div>

        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton1">
            <form method="GET">
                <button type="submit" class="dropdown-item cursor_pointer" name="language" value="all">All Languages</button>
            </form>
            @foreach ($languages as $language)
                <form method="GET">
                    <button type="submit" class="dropdown-item cursor_pointer" name="language" value="{{ $language->name }}">{{ $language->name }}</button>
                </form>
            @endforeach
        </div>
    </div>

</div>


@foreach ($conversations as $conversation)
    @php
    $hasChapters = $chapter->where('conversation_guide_id', $conversation->id)->isNotEmpty();
    @endphp
    @if ($hasChapters)
        <div class="card float-none margin-top-10 card-list-courses-instructor">
            <div class="card-body">
                <div class="row">
                    <div class="text-corporate-dark-color col-6 mb-3 small-font-size-rem-1-1 border-bottom-inst">
                        <strong>{{ $conversation->name }}</strong>
                    </div>
                    <div class="col-4 mb-3 border-bottom-inst">
                        <svg fill="#39b4b3" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                        <a class="a-title text-corporate-color" href="#"><u>Download all</u></a>
                    </div>
                    <div class="col-2 mb-3">
                        <div class="cursor_pointer padding-5" data-bs-toggle="collapse" href="#collapseLingroLanguage{{ $conversation->id }}" role="button" aria-expanded="false" aria-controls="collapseLanguage{{ $conversation->id }}">
                            <svg fill="#545454" xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="collapse" id="collapseLingroLanguage{{ $conversation->id }}">
                @foreach ($chapter as $chapterItem)
                    @if ($chapterItem->conversation_guide_id === $conversation->id)
                        <div class="row mb-2">
                            <div class="col-md-10 text-corporate-color">
                                <u>{{ $chapterItem->name }}</u>
                            </div>
                            <div class="col-md-2">
                                <div class="cursor_pointer">
                                    <svg fill="#545454" xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
@endforeach



@endsection
