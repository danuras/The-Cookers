<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style-profil.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-home.css') }}" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="/">
                <img src="{{ asset('assets/logo.png') }}" alt="" />
            </a>
            <!-- <a class="navbar-brand text-white" href="index.html"><strong>Bakso</strong> Solo Baru</a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="/">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="/recipes/search-recipe/">RESEP</a>
                    </li>
                    <li>
                        <button class="btn">
                            <a href="{{ route('recipes.upload-image') }}">Upload Resep</a>
                        </button>
                    </li>
                    <li>
                        <button class="btn">
                            <a href="{{ route('profiles.index') }}">Profil</a>
                        </button>
                    </li>
                    <li>
                        <button class="btn">
                            <a href="#" onclick="logoutConfirmation()">Keluar</a>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="hamburger">
                <ul>
                    <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <div class="header__wrapper">
        <header></header>
        <div class="cols__container">
            <div class="left__col">
                <div class="img__container">
                    @if ($profiles->photo_profile)
                        <img src="{{ asset($profiles->photo_profile) }}" alt="profile.png" width="200"
                            height="200">
                    @else
                        <img src="{{ asset('assets/default/profile.png') }}" alt="Foto Profil Default" width="200"
                            height="200">
                    @endif
                </div>
                <h2>{{ $profiles->name }}</h2>
                <p>{{ $profiles->username }}</p>
                <p>{{ $profiles->email }}</p>
                <br>
                <p>{{ $profiles->info }}</p>
                <br>
                <p>{{ $profiles->bio }}</p>

                <ul class="about">
                    <li><span>3</span>Resep</li>
                </ul>

                <div class="content">
                    <p>{{ $profiles->info }}</p>
                </div>
            </div>
            <div class="right__col">
                <div id="sub-nav">
                    <button>
                        <a href="{{ route('recipes.user-recipe', $profiles->id) }}">Resep Saya</a>
                    </button>
                    <button>
                        <a href="{{ route('profiles.edit', $profiles->id) }}">
                            Pengaturan akun
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
