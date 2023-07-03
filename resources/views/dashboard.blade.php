<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Cookers</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2.min.css') }}">

</head>

<body>
    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container">
            <a class="navbar-brand p-0" href="#">
                <img src="{{ asset('assets/cookers.png') }}" alt="logo" width="60" height="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item pe-3">
                        <a class="nav-link disabled" href="#">Beranda</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="nav-link disabled" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="nav-link disabled" href="#">Kontak</a>
                    </li>
                    <li class="nav-item pe-3">
                        <button class="btn-auth">
                            <a class="nav-link active" href="{{ route('register') }}">Daftar</a>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn-auth">
                            <a class="nav-link active" href="{{ route('login') }}">Masuk</a>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- navbar end --}}

    {{-- hero --}}
    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-md" id="headline">
                    <h1>Ayo Masak!</h1>
                    <p>Dapatkan Inspirasi Kuliner Terbaru dengan Resep Pilihan Terbaik Kami</p>
                    <button>
                        <a href="{{ route('register') }}">Masak Sekarang</a>
                    </button>
                </div>
                <div class="col-md">

                </div>
            </div>
        </div>
    </section>
    {{-- hero end --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
