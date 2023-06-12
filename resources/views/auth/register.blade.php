<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Daftar</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"
        integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}" />
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <div class="row pt-3">
                <div class="col">
                    <h1 class="">Daftar</h1>
                    <p class="">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->

    <!-- form -->
    <section class="form-daftar">
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="container">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" autocomplete="on">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        {{-- username --}}
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name='username' class="form-control" id="username"
                                aria-describedby="username" value='{{ old('username') }}' />
                            @error('username')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name='name' value='{{ old('name') }}' class="form-control"
                                id="nama" aria-describedby="nama" />
                            @error('name')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name='email' value='{{ old('email') }}' class="form-control"
                                id="email" aria-describedby="email" />
                            @error('email')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name='password' value='{{ old('password') }}'
                                    class="form-control" id="password" aria-describedby="password"
                                    autocomplete="new-password" />
                                <span class="input-group-text" type="button">
                                    <i class="fa-solid fa-eye" id="show-password"></i>
                                </span>
                                <div id="password" class="form-text">
                                    Password harus minimal 8 karakter, mengandung kombinasi huruf besar dan kecil, angka
                                    serta simbol.
                                </div>
                                @error('password')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- ulangi password --}}
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Ulangi Password</label>
                            <div class="input-group">
                                <input type="password" value='{{ old('password_confirmation') }}'
                                    name='password_confirmation' class="form-control" id="password-confirm"
                                    aria-describedby="password-confirm" />
                                <span class="input-group-text" type="button">
                                    <i class="fa-solid fa-eye" id="show-password-confirm"></i>
                                </span>
                                @error('password-confirm')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{-- foto profil --}}
                        <div class="mb-3">
                            <label for="foto-profil" class="form-label">Foto Profil</label>
                            <div>
                                @if (session('photo_profile_c'))
                                    <img id="gambar-preview" onclick='document.getElementById("pp").click()'
                                        src="{{ asset(session('photo_profile_c')) }}" alt="Preview Gambar"
                                        width="200" height="200">
                                    <input type="hidden" id='last_pp' name="last_pp"
                                        value="{{ session('photo_profile_c') }}" class="form-control">
                                @else
                                    <img id="gambar-preview" onclick='document.getElementById("pp").click()'
                                        src="{{ asset('assets/default/profile.png') }}" alt="profile.png"
                                        width="200" height="200">
                                @endif
                                <input type="file" onchange="tampilkanGambar(this);" id='pp'
                                    name="photo_profile" class="form-control" accept="image/*" hidden>
                                <div>
                                    <small class="form-text text-muted">Klik gambar untuk upload foto profil</small>
                                </div>
                                @error('photo_profile')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- jenis kelamin --}}
                        <div class="mb-3">
                            <label for="jenis-kelamin" class="form-label">Jenis kelamin</label>
                            <div class="input-group">
                                <select class="form-select" id="inputGroupSelect01" name='gender'>
                                    @if (old('gender') == 2)
                                        <option value="1">Laki-laki</option>
                                        <option value="2" selected>Perempuan</option>
                                        <option value="3">Tidak ingin memberitahu</option>
                                    @elseif(old('gender') == 3)
                                        <option value="1">Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                        <option value="3" selected>Tidak ingin memberitahu</option>
                                    @else
                                        <option value="1" selected>Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                        <option value="3">Tidak ingin memberitahu</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        {{-- info --}}
                        <div class="mb-3">
                            <label for="info" class="form-label">Info</label>
                            <input type="text" class="form-control" id="info" name="info"
                                value='{{ old('info') }}' aria-describedby="info" maxlength="100"
                                oninput="countCharacterInfo()" />
                            @error('info')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small id="infoCount" class="form-text text-muted">0/100</small>
                        </div>
                        {{-- bio --}}
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" rows="5" class="form-control" maxlength="500"
                                oninput="countCharacterBio()" autocomplete="off">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="alert alert-danger mt-1 mb-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small id="bioCount" class="form-text text-muted">0/500</small>
                        </div>
                        {{-- button submit --}}
                        <div class="pb-3">
                            <button type="submit" id="btn-submit">
                                Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- form end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/script-auth.js') }}"></script>
</body>

</html>
