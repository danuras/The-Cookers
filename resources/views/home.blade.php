<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-home.css') }}" />

    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="sweetalert2.min.css">

    <title>HOME</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <!-- Menu -->
    <main>
        <div class="row">
            <div class="col-md">
                <h3 class="text-center">RESEP TERBARU</h3>
            </div>
                @foreach ($n_recipes as $recipe)
                    <div class="col-md-2">
                        <div class="card border">
                            <img src="{{ asset($recipe->image_url) }}" class="card-img-top" alt="..." />
                            <a href="/recipes/{{ $recipe->id }}/detail">
                                <div class="card-body">
                                    <button class="button">{{ $recipe->name }}</button>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
        </div>


        <h3 class="text-center">RESEP POPULER</h3>

        <div class="row">
            @foreach ($f_recipes as $recipe)
                <div class="col-md-2">
                    <div class="card border">
                        <img src="{{ asset($recipe->image_url) }}" class="card-img-top" alt="..." />
                        <a href="/recipes/{{ $recipe->id }}/detail">
                            <div class="card-body">
                                <button class="button">{{ $recipe->name }}</button>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <br>
        <br>
    </main>
    </div>
    <!-- Akhir Menu -->

    <script src="{{ asset('js/script-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
