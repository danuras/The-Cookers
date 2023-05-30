<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Responsive Profile Page</title>

        <link rel="icon" type="image/png" href="{{asset('assets/cookers.png')}}">
        <linkrel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
        <link rel="stylesheet" href="css/style-profil.css" />
    </head>
    <body>
        <div class="header__wrapper">
            <header>
                <button>
                    <a href="/">
                        Kembali
                    </a>
                </button>
            </header>
            <div class="cols__container">
                <div class="left__col">
                    <div class="img__container">
                        <img src={{ asset('images/img-profil/user.jpeg') }} alt="Anna Smith" />
                        <span></span>
                    </div>
                    <h2>Shani Indira</h2>
                    <!-- <p>UX/UI Designer</p> -->
                    <p>shani@gmail.com</p>

                    <ul class="about">
                        <li><span>25</span>Saved</li>
                        <!-- <li><span>3</span></li> -->
                        <li><span>3</span>Receipt</li>
                    </ul>

                    <div class="content">
                        <p>Semanis coklat, selembut sutra.</p>

                        <ul>
                            <li><i class="fab fa-twitter"></i></li>
                            <i class="fab fa-pinterest"></i>
                            <i class="fab fa-facebook"></i>
                            <i class="fab fa-dribbble"></i>
                        </ul>
                    </div>
                </div>
                <div class="right__col">
                    <nav>
                        <ul>
                            <li><a href="">saved</a></li>
                            <li><a href="">receipt</a></li>
                            <!-- <li><a href="">groups</a></li>
                            <li><a href="">about</a></li> -->
                        </ul>
                        <button>
                            <a href="{{ route('profiles.edit',$profiles->id) }}">
                                Pengaturan Akun
                            </a>
                        </button>
                    </nav>

                    <div class="saved">
                        <img
                            src={{asset('images/img-profil/donat.jpg')}}
                            alt="saved"
                        />
                        <img
                            src={{asset('images/img-profil/ayam-bakar.jpg')}}
                            alt="saved"
                        />
                        <img
                            src={{asset('images/img-profil/brownies.jpg')}}
                            alt="saved"
                        />
                        <img
                            src={{asset('images/img-profil/burger.jpg')}}
                            alt="saved"
                        />
                        <img
                            src={{asset('images/img-profil/ikan-bumbu.jpg')}}
                            alt="saved"
                        />
                        <img
                            src={{asset('images/img-profil/kue-lumpur.jpg')}}
                            alt="saved"
                        />
                    </div>

                    <div class="resep">
                        <img
                            src="{{asset('images/img-profil/ayam-goreng.jpg')}}"
                            alt="resep"
                        />
                        <img
                            src={{asset('images/img-profil/nasi-goreng.jpg')}}
                            alt="resep"
                        />
                        <img
                            src={{asset('images/img-profil/salad.jpg')}}
                            alt="resep"
                        />
                        <img
                            src={{asset('images/img-profil/salmon.jpg')}}
                            alt="resep"
                        />
                        <img
                            src={{asset('images/img-profil/spageti.jpg')}}
                            alt="resep"
                        />
                        <img
                            src={{asset('images/img-profil/tumis-tahu.jpg')}}
                            alt="resep"
                        />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
