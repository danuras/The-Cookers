<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $recipe->name }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="sweetalert2.min.css">

    <link rel="stylesheet" href="{{ asset('css/style-main-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-detailresep.css') }}" />

</head>

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-detailresep.css') }}" />

    <title>{{ $recipe->name }}</title>
</head> --}}

<body>
    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container">
            <a class="navbar-brand p-0" href="/">
                <img src="{{ asset('assets/cookers.png') }}" alt="logo" width="60" height="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item pe-3">
                        <a class="nav-link" href="{{ route('recipes.upload-image') }}">Upload Resep</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="nav-link" href="{{ route('profiles.index') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn-auth">
                            <a class="nav-link" href="#" onclick="logoutConfirmation()">Keluar</a>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- navbar end --}}

    <!-- Menu -->
    <div class="container">
        <ul class="menu">
            <img src="{{ asset($recipe->image_url) }}" alt="" />
        </ul>

        <h5 class="judul">{{ $recipe->name }}</h5>
        <hr />

        <div class="navbar-2">
            <p class="waktu">Waktu memasak {{ $recipe->cooking_time }} menit</p>
            <img class="fork" src="{{ asset('assets/fork.png') }}" alt="" />
            <p class="porsi">{{ $recipe->portion }} porsi</p>
        </div>

        <hr />
        <div class="navbar-3">
            <ul class="star">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </ul>

            <p class="rating">{{ $avg_ratting }}/5</p>

            <button class="btn-rate">Nilai</button>

            <img class="bookmark" src="{{ asset('assets/bookmark.png') }}" alt="" />

            <p class="fav">Favorit</p>
            <ul class="share">
                <i class="fa fa-share"></i>
            </ul>

            <p class="p-share">Bagikan</p>
        </div>

        <hr />

        <a href="{{ $recipe->video_url }}"><img class="youtube" src="{{ asset('assets/youtube.png') }}"
                alt="" /></a>
        <h5 class="tutorial">Lihat video tutorial</h5>

        <hr />

        <div class="bahan">
            <h4>Bahan - Bahan</h4>
            <div class="square"></div>
            @foreach ($ingredients as $ingredient)
                <li>{{ $ingredient->value }}</li>
            @endforeach
        </div>

        <div class="cara">
            <h4>Cara Membuat</h4>
            <div class="square"></div>
        </div>

        @for ($i = 0; $i < count($steps); $i++)
            <div class="step">
                <h5 class="langkah1">Langkah {{ $i + 1 }}</h5>
                <ul class="check">
                    <i class="fa fa-check"></i>
                </ul>
            </div>
            <p class="ket">
                {{ $steps[$i]->value }}
            </p>
            <center>
                @foreach (json_decode($steps[$i]->images ?? '[]') as $image)
                    <img id="gambar-preview" src="{{ asset($image) }}" alt="Preview Gambar" width="80"
                        height="80">
                @endforeach
            </center>

            <hr />
        @endfor

        <h6>{{ count($comments) }} Komentar</h6>
        <div class="komentar">
            <img class="profpict" src="{{ asset('assets/profpict.png') }}" alt="" />

            <form>
                <input type="text" id="kolom-komentar" class="kol-komentar" placeholder="Add comment..." />
            </form>
        </div>
        @foreach ($comments as $comment)
            <div class="komentar2">
                @if ($comment->user->photo_profile)
                    <img class="profpict2" src="{{ asset($comment->user->photo_profile) }}" alt="" />
                @else
                    <img class="profpict2" src="{{ asset('assets/default/profile.png') }}" alt="" />
                @endif

                <p class="kalimat">
                    {{ $comment->value }}
                </p>


            </div>
            @foreach (json_decode($comment->images) as $image)
                <img id="gambar-preview" src="{{ asset($image) }}" alt="Preview Gambar" width="80"
                    height="80">
            @endforeach
        @endforeach

        <br />
        <br />
    </div>
    <!-- Akhir Menu -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>
