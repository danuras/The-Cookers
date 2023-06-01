<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Profile My Receipt</title>
        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        />
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/style-profil.css') }}">
    </head>
    <body>
        <div class="header__wrapper">
            <header></header>
            <div class="cols__container">
                <div class="left__col">
                    <div class="img__container">
                        <img src="{{ asset('images/img-profil/user.jpeg') }}" alt="Anna Smith" />
                        <span></span>
                    </div>
                    <h2>Shani Indira</h2>
                    <!-- <p>UX/UI Designer</p> -->
                    <p>shani@gmail.com</p>

                    <ul class="about">
                        <li><span>25</span>Saved</li>
                        <li><span>3</span>Receipt</li>
                    </ul>

                    <div class="content">
                        <p>Semanis coklat, selembut sutra.</p>

                        <ul>
                            <li><i class="fab fa-twitter"></i></li>
                            <i class="fab fa-pinterest"></i>
                            <i class="fab fa-facebook"></i>
                            <i class="fab fa-instagram"></i>
                        </ul>
                    </div>
                </div>
                <div class="right__col">
                    <nav>
                        <ul>
                            <li><a href="">home</a></li>
                            <li>
                                <a
                                    href="file:///C:/Users/Asus/Downloads/The-Cookers/resources/views/profil/profil/index.html"
                                    >favorite</a
                                >
                            </li>
                            <li>
                                <a
                                    href="file:///C:/Users/Asus/Downloads/The-Cookers/resources/views/profil/profil_myreceipt/index.html"
                                    >my receipt</a
                                >
                            </li>
                        </ul>
                        <button>
                            <a href="{{ route('profiles.edit',$profiles->id) }}">
                                Account Setting
                            </a>
                        </button>
                    </nav>

                    <div class="line1">
                        <div class="saved">
                            <img
                                src="{{asset('images/img-profil/ayam-goreng.jpg')}}"
                                alt="resep"
                            />
                            <img
                                src="{{asset('images/img-profil/nasi-goreng.jpg')}}"
                                alt="resep"
                            />
                            <img
                                src="{{asset('images/img-profil/salad.jpg')}}"
                                alt="resep"
                            />
                        </div>

                        <div class="button1">
                            <button>
                                Ayam Goreng By Dinda
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                            <button>
                                Nasi Goreng by Fatya
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                            <button>
                                Salad Sayur by Salsa
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                        </div>
                    </div>

                    <div class="line2">
                        <div class="saved2">
                            <img
                                src="{{asset('images/img-profil/salmon.jpg')}}"
                                alt="resep"
                            />
                            <img
                                src="{{asset('images/img-profil/spageti.jpg')}}"
                                alt="resep"
                            />
                            <img
                                src="{{asset('images/img-profil/tumis-tahu.jpg')}}"
                                alt="resep"
                            />
                        </div>

                        <div class="button2">
                            <button>
                                Salmon By Kelvin
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                            <button>
                                Spaghetti by Liliana
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                            <button>
                                Tumis Tahu by Maria
                                <!-- <li>
                                    <i class="fa-thin fa-bookmark"></i>
                                </li> -->
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
