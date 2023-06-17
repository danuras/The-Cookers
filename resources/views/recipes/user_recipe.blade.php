<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-home.css') }}" />
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css" />

    <title>Resep Saya</title>
</head>

{{-- navbar --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <img src='{{ asset('assets/logo.png') }}' alt="" />
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
                    <a class="nav-link mr-4" href="#">RESEP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-4" href="#">FAVORIT</a>
                </li>

                <li>
                    <button class="upload-resep">
                        <a href="{{ route('recipes.upload-image') }}">Upload Resep</a>
                    </button>
                </li>

                <li>
                    <button class="profil">
                        <a href="{{ route('profiles.index') }}">Profil</a>
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
{{-- navbar end --}}

{{-- list resep --}}
<section>
    <div class="container">
        <div class="row">
            <div class="col-md">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>namaResep1</td>
                            <td>
                                <a href="#" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>namaResep2</td>
                            <td>
                                <a href="#" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>namaResep3</td>
                            <td>
                                <a href="#" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</section>
{{-- list resep end --}}
