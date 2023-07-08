<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cari Resep</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style-cari-resep.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-main-navbar.css') }}">
</head>

<body>
    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light shadow sticky-md-top">
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

    <main>
        <div class="row pt-3">
            {{-- section kiri - bagian cari biasa dan menampilkan hasil pencarian --}}
            <div class="col-md-8">
                {{-- bagian cari resep biasa --}}
                <div class="row">
                    <div class="col-md">
                        <nav class="navbar">
                            <div class="container-fluid">
                                <form id='form-search-biasa' class="d-flex" method="GET">
                                    @method('GET')
                                    <input class="form-control me-2" type="search" placeholder="Cari Resep"
                                        aria-label="Search" id="searchInput">
                                    <button class="" id="btn-cari-biasa" type="submit">Cari</button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
                {{-- bagian menampilkan hasil cari --}}
                <div class="row pt-3">
                    @foreach ($recipes as $recipe)
                        <div class="col-md-4 pb-3">
                            <div class="card border">
                                <img src="{{ asset($recipe->image_url) }}" class="card-img-top" alt="gambar resep"
                                    style="width: 100%; height: 200px; object-fit: cover;" />
                                <a href="/recipes/{{ $recipe->id }}/detail">
                                    <div class="card-body text-center">
                                        <button class="button"
                                            data-fullname="{{ $recipe->name }}">{{ \Illuminate\Support\Str::limit($recipe->name, 20) }}</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach                
                    {!! $recipes->links('vendor.pagination.bootstrap-4') !!}
                </div>
            </div>
            {{-- section kanan - bagian cari dengan detail --}}
            <div class="col-md-4">
                <div class="container pt-5 pb-5" id="kotak-cari-spesifik">
                    <div class="row">
                        <form method="GET" id="form-search-detail">
                            @method('GET')
                            <p>Cari resep yang lebih spesifik?</p>
                            <div class="mb-3">
                                <label for="bahan-resep" class="form-label">Bahan</label>
                                <input type="text" class="form-control" id="bahan-resep">
                            </div>
                            <button type="submit" class="" id="btn-cari-spesifik">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        document.getElementById("form-search-biasa").addEventListener("submit", function(e) {
            e.preventDefault(); // Mencegah submit form
            var searchValue = document.getElementById("searchInput").value;
            var formAction = "{{ route('recipes.result-recipe', ['search' => ':search']) }}";
            if (searchValue == "") {
                searchValue = " ";
            }
            formAction = formAction.replace(':search', encodeURIComponent(searchValue));
            document.getElementById("form-search-biasa").action = formAction;
            document.getElementById("form-search-biasa").submit(); // Submit form setelah URL diubah
        });
        document.getElementById("form-search-detail").addEventListener("submit", function(e) {
            e.preventDefault(); // Mencegah submit form

            var ingredientRecipe = document.getElementById("bahan-resep").value;
            if (ingredientRecipe == "") {
                ingredientRecipe = " ";
            }
            var formAction =
                "{{ route('recipes.detail-result-recipe', ['ingredient' => ':ingredient']) }}";
            formAction = formAction.replace(':ingredient', encodeURIComponent(ingredientRecipe));
            document.getElementById("form-search-detail").action = formAction;
            document.getElementById("form-search-detail").submit(); // Submit form setelah URL diubah
        });
    </script>
</body>

</html>
