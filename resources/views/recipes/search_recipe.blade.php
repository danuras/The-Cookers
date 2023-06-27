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
</head>

<body>
    <main>
        <div class="row pt-3">
            {{-- section kiri - bagian cari dengan detail --}}
            <div class="col-md-4">
                <div class="container sticky-md-top pt-5 pb-5" id="kotak-cari-spesifik">
                    <div class="row">
                        <form method = "GET" id = "form-search-detail">
                            @method("GET")
                            <p>Cari resep yang lebih spesifik?</p>
                            <div class="mb-3">
                                <label for="nama-resep" class="form-label">Nama Resep</label>
                                <input type="text" class="form-control" id="nama-resep">
                            </div>
                            <div class="mb-3">
                                <label for="bahan-resep" class="form-label">Bahan</label>
                                <input type="text" class="form-control" id="bahan-resep">
                            </div>
                            <button type="submit" class="" id="btn-cari-spesifik">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- section kanan - bagian cari biasa dan menampilkan hasil pencarian --}}
            <div class="col-md-8">
                {{-- bagian cari resep biasa --}}
                <div class="row">
                    <div class="col-md">
                        <nav class="navbar navbar-light">
                            <div class="container-fluid">
                                <form id = 'form-search-biasa' class="d-flex ms-auto" method = "GET">
                                    @method('GET')
                                    <input class="form-control me-2" type="search" placeholder="Cari Resep"
                                        aria-label="Search" id = "searchInput">
                                    <button class="" id="btn-cari-biasa" type="submit">Cari</button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
                {{-- bagian menampilkan hasil cari --}}
                <div class="row pt-3">
                    @foreach ($recipes as $recipe)
                        <div class="col-md-4">
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
        if(searchValue == ""){
            searchValue = " ";
        }
        formAction = formAction.replace(':search', encodeURIComponent(searchValue));
        document.getElementById("form-search-biasa").action = formAction;
        document.getElementById("form-search-biasa").submit(); // Submit form setelah URL diubah
    });
    document.getElementById("form-search-detail").addEventListener("submit", function(e) {
        e.preventDefault(); // Mencegah submit form
        var nameRecipe = document.getElementById("nama-resep").value;
        
        if(nameRecipe == ""){
            nameRecipe = " ";
        }
        
        var ingredientRecipe = document.getElementById("bahan-resep").value;
        if(ingredientRecipe == ""){
            ingredientRecipe = " ";
        }
        var formAction = "{{ route('recipes.detail-result-recipe', ['name' => ':name', 'ingredient' => ':ingredient']) }}";
        formAction = formAction.replace(':name', encodeURIComponent(nameRecipe));
        formAction = formAction.replace(':ingredient', encodeURIComponent(ingredientRecipe));
        document.getElementById("form-search-detail").action = formAction;
        document.getElementById("form-search-detail").submit(); // Submit form setelah URL diubah
    });
    </script>
</body>

</html>
