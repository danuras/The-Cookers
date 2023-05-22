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
    
  </head>
  <body>
    <!-- Navbar start -->
    <nav class="navbar">
      <div class="logo">
        <a href="#" class="navbar-logo">the<span>cookers</span>.</a>
      </div>

      <ul> 
        <li><a class="menu-list beranda" href="#home">Beranda</a></li>
        <li><a class="menu-list tentang" href="#about">Tentang Kami</a></li>
        <li><a class="menu-list resep" href="#resep">Resep</a></li>
        <li><a class="menu-list kontak" href="#contact">Kontak</a></li>
        <!-- daftar masuk keluar -->
        @if (!auth()->check())
        <li><a class="menu-list daftar" href="{{route('register')}}">
          <button class="btn btn-menu daftar">Daftar</button>
        </a></li>
        <li><a class="menu-list masuk" href="{{route('login')}}">
          <button class="btn btn-menu masuk">Masuk</button>
        </a></li>
        @else
        <li><a href="#" class="menu-list keluar" id="log" onclick="logoutConfirmation()">
          <button class="btn btn-menu keluar">Keluar</button>
        </a></li>
        @endif
      </ul>

      <div class="menu-toggle">
        <input type="checkbox">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
    <!-- Navbar end -->

    <!-- Hero Section Start -->
    <main>
      <div class="hero">
        <div class="content">
          <h1>Ayo <span>Masak!</span></h1>
          <p>
            Dapatkan Inspirasi Kuliner Terbaru dengan Resep Pilihan Terbaik Kami!
          </p>
          <!-- button call to action -->
          <a href="#">
            <button class="btn btn-call-to-action">Masak Sekarang</button>
          </a>
        </div>
      </div>
    </main>
    <!-- Hero Section End -->

    <!-- Feather Icons -->
    <!-- <script>
      feather.replace();
    </script> -->
    
    <!-- My JavaScript -->
    <!-- <script src="{{asset('js/script.js')}}"></script> -->

    <!-- JS pop up konfirmasi logout-->
    <script src="{{asset('plugins/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
  </body>
</html>
