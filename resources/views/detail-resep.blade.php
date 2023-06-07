<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="{{asset ('css/style-detailresep.css')}}" />
        <link
            rel="stylesheet"
            type="text/css"
            href="fontawesome/css/all.min.css"
        />

        <title>Detail Resep</title>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <img
                    src="{{asset ('assets/img/logo.png')}}"
                    alt=""
                />
                <!-- <a class="navbar-brand text-white" href="index.html"><strong>Bakso</strong> Solo Baru</a> -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link mr-4" href="#">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-4" href="#">RECEIPT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-4" href="#">FAVOURITE</a>
                        </li>

                        <li>
                            <button class="upload-resep">Upload Receipt</button>
                        </li>

                        <li>
                            <button class="profil">Profile</button>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link mr-4" href="#">MY RECEIPT</a>
                        </li> -->

                        <!-- <form>
                            <input
                                type="text"
                                id="kolom-pencarian"
                                class="pencarian"
                                placeholder="Search"
                            />
                            <i class="fa-thin fa-magnifying-glass"></i>
                        </form> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Akhir Navbar -->

        <!-- Menu -->
        <div class="container">
            <ul class="menu">
                <img
                    src="{{asset ('assets/img-detailresep/mendoan.jpg')}}"
                    alt=""
                />
            </ul>

            <h5 class="judul">Fried "Tempe" Receipt</h5>
            <hr />

            <div class="navbar-2">
                <p class="waktu">Waktu memasak 45 menit</p>
                <img
                    class="fork"
                    src="{{asset ('assets/img-detailresep/fork.png')}}"
                    alt=""
                />
                <p class="porsi">7 porsi</p>
            </div>

            <hr />
            <div class="navbar-3">
                <ul class="star">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </ul>

                <p class="rating">3.9/250</p>

                <button class="btn-rate">Rate</button>

                <img
                    class="bookmark"
                    src="{{asset ('assets/img-detailresep/bookmark.png')}}"
                    alt=""
                />

                <p class="fav">Favourite</p>
                <ul class="share">
                    <i class="fa fa-share"></i>
                </ul>

                <p class="p-share">Share</p>
            </div>

            <hr />

            <img
                class="youtube"
                src="{{asset ('assets/img-detailresep/youtube.png')}}"
                alt=""
            />
            <h5 class="tutorial">Watch Video Tutorial</h5>

            <hr />

            <div class="bahan">
                <h4>Bahan - Bahan</h4>
                <div class="square"></div>
                <li>300 gram tepung terigu</li>
                <li>1 sdm tepung beras</li>
                <li>1 sdt baking powder</li>
                <li>10 buah tempe (1 papan tempe)</li>
                <li>1/2 liter minyak goreng</li>
            </div>

            <div class="bumbu">
                <h4>Bumbu - Halus</h4>
                <div class="square"></div>
                <li>2 sdt ketumbar</li>
                <li>3 siung bawang putih</li>
                <li>2 butir bawang merah</li>
                <li>2 butir kemiri</li>
                <li>2 cm kunyit</li>
                <li>Garam secukupnya</li>
                <li>Penyedap rasa (opsional)</li>
            </div>

            <div class="cara">
                <h4>Cara Membuat</h4>
                <div class="square"></div>
            </div>

            <div class="step">
                <h5 class="langkah1">Langkah 1</h5>
                <ul class="check">
                    <i class="fa fa-check"></i>
                </ul>
            </div>
            <p class="ket">
                Campurkan tepung terigu dan tepung beras sampai merata
            </p>

            <hr />

            <div class="step">
                <h5 class="langkah1">Langkah 2</h5>
                <ul class="check">
                    <i class="fa fa-check"></i>
                </ul>
            </div>
            <p class="ket">
                Jika Moms menggunakan tempe biasa potong kotak-kotak dan
                pastikan saat dipotong tebal-tebal agar mendapat tekstur lembek
            </p>

            <hr />

            <div class="step">
                <h5 class="langkah1">Langkah 3</h5>
                <ul class="check">
                    <i class="fa fa-check"></i>
                </ul>
            </div>
            <p class="ket">
                Campurkan tepung terigu, tepung beras, baking powder dan hingga
                rata
            </p>

            <hr />

            <div class="step">
                <h5 class="langkah1">Langkah 4</h5>
                <!-- <ul class="check">
                    <i class="fa fa-check"></i>
                </ul> -->
            </div>
            <p class="ket">
                Panaskan minyak di atas kompor, lalu goreng hingga matang
                keemasan
            </p>

            <hr />

            <div class="step">
                <h5 class="langkah1">Langkah 5</h5>
                <!-- <ul class="check">
                    <i class="fa fa-check"></i>
                </ul> -->
            </div>
            <p class="ket">Tiriskan dan mendoan hangat siap disajikan</p>

            <hr />

            <h6>31 Komentar</h6>
            <div class="komentar">
                <img
                    class="profpict"
                    src="{{asset ('assets/img-detailresep/profpict.png')}}"
                    alt=""
                />

                <form>
                    <input
                        type="text"
                        id="kolom-komentar"
                        class="kol-komentar"
                        placeholder="Add comment..."
                    />
                </form>
            </div>

            <div class="komentar2">
                <img
                    class="profpict2"
                    src="{{asset ('assets/img-detailresep/profpict2.png')}}"
                    alt=""
                />

                <p class="kalimat">
                    assalamualaikum warahmatullahi wabarakatuh... resepnya
                    mantab
                </p>
            </div>

            <br />
            <br />
        </div>
        <!-- Akhir Menu -->

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script
            src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"
        ></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.js"></script>
    </body>
</html>
