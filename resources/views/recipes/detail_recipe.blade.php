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
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/style-detailresep.css') }}" /> --}}

</head>

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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Resep
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('recipes.search-recipe') }}">Cari Resep</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.user-recipe') }}">Resep Saya</a></li>
                        </ul>
                    </li>
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

    {{-- main --}}
    <main>
        <div class="container">
            {{-- gambar resep --}}
            <div class="row pt-3">
                <div class="col-md d-flex justify-content-center">
                    <img src="{{ asset($recipe->image_url) }}" alt="gambar resep" draggable="false"
                        style="width: 50%; height: 300px; object-fit: cover;" />
                </div>
            </div>
            {{-- nama resep --}}
            <div class="row pt-3">
                <div class="col-md text-center">
                    <h4>{{ $recipe->name }}</h4>
                </div>
            </div>
            <hr>
            {{-- waktu dan porsi resep --}}
            <div class="row d-flex justify-content-between pt-3">
                <div class="col-md-3">
                    <p>Waktu memasak {{ $recipe->cooking_time }} menit</p>
                </div>
                <div class="col-md-2">
                    <p><img src="{{ asset('assets/fork.png') }}" alt="" style="width: 20px; height: 20px;" />
                        {{ $recipe->portion }} porsi
                    </p>
                </div>
            </div>
            <hr>
            {{-- video resep --}}
            <div class="row pt-3">
                <div class="col-md d-flex justify-content-center">
                    <div class="youtube" id="video-preview-container"></div>
                </div>
            </div>
            <hr>
            {{-- bahan-bahan --}}
            <div class="row pt-3">
                <div class="row pb-3">
                    <div class="col-md">
                        <h5 class="fw-bold">Bahan-bahan</h5>
                    </div>
                </div>
                @for ($i = 0; $i < count($ingredients); $i++)
                    <div class="row">
                        <div class="col-md">
                            <p>{{ $i + 1 }}. {{ $ingredients[$i]->value }}</p>
                        </div>
                    </div>
                @endfor
            </div>
            <hr>
            {{-- langkah-langkah --}}
            <div class="row pt-3">
                <div class="row pb-3">
                    <div class="col-md">
                        <h5 class="fw-bold">Langkah-langkah</h5>
                    </div>
                </div>
                @for ($i = 0; $i < count($steps); $i++)
                    <div class="row">
                        <div class="col-md">
                            <p>{{ $i + 1 }}. {{ $steps[$i]->value }}</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </main>
    {{-- main end --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/script-dashboard.js') }}"></script>
    <script>
        function extractVideoId(url) {
            var regExp =
                /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|\?v=)([^#&?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length === 11) {
                return match[2];
            } else {
                return null;
            }
        }
        var videoLink = '{{ $recipe->video_url }}';

        var videoId = extractVideoId(videoLink);

        var previewContainer = document.getElementById("video-preview-container");
        previewContainer.innerHTML = "";

        if (videoId) {
            var iframe = document.createElement("iframe");
            iframe.classList.add("video-preview");
            iframe.src = "https://www.youtube.com/embed/" + videoId;
            iframe.title = "YouTube Video";
            iframe.frameborder = "0";
            iframe.allow =
                "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
            iframe.allowfullscreen = true;
            iframe.width = "960";
            iframe.height = "540";
            previewContainer.appendChild(iframe);

        } else {
            previewContainer.innerHTML = "Link YouTube hilang";
        }
    </script>
</body>
