@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.config.conversation-guide.card.general_data',[
                'guide' => $guide
            ])

            @include('admin.config.conversation-guide.card.courses',[
                'courses' => $guide->course
            ])
        </div>

        <div class="col-xl-6">

            @include('admin.config.conversation-guide.card.files',[
               'files' => $guide->conversationGuideFile
           ])

            @include('admin.config.conversation-guide.card.chapters',[
                'chapters' => $guide->chapter
            ])
        </div>
    </div>


@endsection
