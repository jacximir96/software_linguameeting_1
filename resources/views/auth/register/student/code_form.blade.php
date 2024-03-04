<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">

                <div class="row mt-3">
                    <div class="col-12">
                        @include('flash::message')
                    </div>
                </div>

                @include('common.form_message_errors')

                <form method="POST" action="{{ route('post.public.register.student.code') }}">
                    @csrf

                    <div class="row">

                        <div class="col-xl-6">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Código</label>
                            <input id="code"
                                   type="text"
                                   name="code"
                                   value="{{ old('code') }}"
                                   class="form-control @error('code') is-invalid @enderror"
                                   required
                                   autocomplete="code" autofocus>

                            @error('code')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                               Register
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</main>

@include('common.web.footer')

</body>
</html>
