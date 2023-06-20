<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Masuk</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"
        integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}" />
</head>

<body>
    {{-- header --}}
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md text-center pt-5">
                    <h1>Masuk</h1>
                    <p class="">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
                </div>
    </header>
    {{-- header end --}}


    {{-- form --}}
    <section class="form-masuk">
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif

        <div class="container">
            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data" autocomplete="on">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="login" class="form-label">Email atau Username</label>
                            <input type="text" name='login' class="form-control" id="login"
                                aria-describedby="login" value='{{ old("login") }}' />
                            @error('login')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name='password' value='{{ old('password') }}'
                                    class="form-control" id="password" aria-describedby="password"
                                    autocomplete="new-password" />
                                <span class="input-group-text" type="button">
                                    <i class="fa-solid fa-eye" id="show-password"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" id="remember_me" name="remember_me">
                            <label for="remember_me">Ingat Saya</label>
                        </div>
                        @error('logine')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="text-end">
                            <button type="submit" id="btn-submit" class="">Masuk</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('reset-password') }}" method="GET" enctype="multipart/form-data">
                <div class="row justify-content-center pt-4">
                    <div class="col-md-4 text-end">
                        <button type="submit" id="btn-lupa-password" class="">Lupa Password</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    {{-- form end --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/script-auth.js') }}"></script>
</body>

</html>
