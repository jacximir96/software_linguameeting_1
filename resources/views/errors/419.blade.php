@extends('errors.minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))


@section('image')
    <div style="background-image: url('/images/page-expired.jpg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('content')
    <div class="mx-auto my-10 text-center">
        <p class="text-xl text-gray-600 leading-tight">{{ __('The page has expired due to inactivity.') }}</p>
        <p class="text-xl text-gray-600 leading-tight">{{ __('You will be redirected to the previous page shortly.') }}</p>
        <p class="text-xl text-gray-600 leading-tight">{{ __('If not, click the button below.') }}</p>
        <a href="javascript:history.back()" class="mt-4 inline-block bg-blue-500 text-white px-6 py-3 rounded">Go Back</a>
    </div>
    <script>
        setTimeout(function() {
            window.history.back();
        }, 3000); // Redirigir automáticamente después de 3 segundos (puedes ajustar el tiempo según tus preferencias)
    </script>
@endsection
