@extends('layouts.app')

@section('content')

<div class="row margin-top-20">

    <div class="col-md-12">

        <input type="hidden" value="[s/$baseUrl/s]" id="baseUrl">
        <div class="card cardCommon mt-4">

            <div class="card-body">

                <div class="row margin-top-20 text-18">

                    <div class="col-md-12">

                        @if ($showKeys)
                        Deactivate Canvas Integration <span onclick="activateCanvas(0);"><i class="fas fa-toggle-on cursor_pointer text-corporate-dark-color text-20" ></i></span>

                        @else
                        Activate Canvas Integration <span onclick="activateCanvas(1);"><i class="fas fa-toggle-off cursor_pointer text-corporate-dark-color text-20"></i></span>
                        
                        @endif

                    </div>


                </div>


                @if ($showKeys)

                <div class="row margin-top-20">

                    <div class="col-md-12">
                        <label for="consumerKey"><strong>Launch Url:</strong></label>
                        <input type="text" value="{{$launchUrl}}" class="form-control" disabled id="launchUrl"/>
                        <button id="button1" onclick="CopyToClipboard('launchUrl')" class="mt-2 btn btn-primary text-12">Copy</button>
                    </div>

                </div>

                <div class="row margin-top-20">

                    <div class="col-md-6">
                        <label for="consumerKey"><strong>Consumer Key:</strong></label>
                        <input type="text" value="{{$canvas->consumer_key}}" class="form-control" disabled id="consumerKey"/>
                        <button id="button1" onclick="CopyToClipboard('consumerKey')" class="mt-2 btn btn-primary text-12">Copy</button>
                    </div>

                    <div class="col-md-6">
                        <label for="consumerSecret"><strong>Shared Secret:</strong></label>
                        <input type="text" value="{{$canvas->consumer_secret}}" class="form-control" disabled id="consumerSecret"/>
                        <button id="button1" onclick="CopyToClipboard('consumerSecret')" class="mt-2 btn btn-primary text-12">Copy</button>
                    </div>

                </div>
                @endif

                <div class="row margin-top-20 text-18 color5">

                    <div class="col-md-12">
                        Note: Please paste the Launch URL and Keys into Canvas.
                    </div>

                </div>

                <div class="row margin-top-20 text-18 color5">

                    <div class="col-md-12">
                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1927774209" target="_blank">Canvas Integration Manual</a>
                    </div>

                </div>

                <div class="row margin-top-20 text-18 color5">

                    <div class="col-md-12">
                        <a href="https://www.youtube.com/watch?v=L1t0USKNb_I" target="_blank">Video Tutorial</a>
                    </div>

                </div>


            </div> <!-- enc card body -->

        </div>

    </div>

</div>


@endsection
