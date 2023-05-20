<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Cookers</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{asset('assets/cookers.png')}}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />

    <!-- <script src="https://unpkg.com/feather-icons"></script> -->

    <!-- styles css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <!-- CSS sweetalert2-->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2.min.css')}}">

    <!-- script javascript -->
    <script src="{{asset('js/script.js')}}"></script>
  </head>
  <body>
    <!-- Navbar start -->
    <nav class="navbar">
      <div class="logo">
        <a href="#" class="navbar-logo">the<span>cookers</span>.</a>
      </div>

      <div class="navbar-nav">
        <a class="menu-list beranda" href="#home">Beranda</a>
        <a class="menu-list tentang" href="#about">Tentang Kami</a>
        <a class="menu-list resep" href="#resep">Resep</a>
        <a class="menu-list kontak" href="#contact">Kontak</a>
        
        <!-- daftar masuk keluar -->
        @if (!auth()->check())
        <a class="auth daftar" href="{{route('register')}}">Daftar</a>
        <a class="auth masuk" href="{{route('login')}}">Masuk</a>
        @else
        <a href="#" class="auth keluar" id="log" onclick="logoutConfirmation()">Keluar</a>
        @endif
      </div>

      <div class="navbar-extra">
        <a href="#" id="search"><i data-feather="search"></i></a>
        <a href="#" id="buku-resep"><i data-feather="book"></i></a>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>
    <!-- Navbar end -->

    <!-- Hero Section Start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Ayo <span>Masak!</span></h1>
        <p>
          Dapatkan Inspirasi Kuliner Terbaru dengan Resep Pilihan Terbaik Kami!
        </p>
        <!-- button call to action -->
        <a href="#">
          <button class="btn btn-call-to-action">Masak Sekarang</button>
        </a>
        
      </main>
    </section>
    <!-- Hero Section End -->

    <!-- Feather Icons -->
    <!-- <script>
      feather.replace();
    </script> -->
    
    <!-- My JavaScript -->
    <script src="{{asset('js/script.js')}}"></script>

    <!-- JS pop up konfirmasi logout-->
    <script src="{{asset('plugins/sweetalert2.min.js')}}"></script>
  </body>
</html>
