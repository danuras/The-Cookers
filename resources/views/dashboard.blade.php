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

    <!-- styles  -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- sweetalert2-->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2.min.css')}}">
    
  </head>
  <body>
    <!-- Navbar start -->
    <nav class="navbar">
      <div class="logo">
        <img class="logo-cookers" src="{{asset('assets/cookers.png')}}" alt="logo the cookers">
      </div>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav"> 
          <li class="nav-item action"><a class="nav-link active beranda" href="#home">Beranda</a></li>
          <li class="nav-item action"><a class="nav-link active tentang" href="#about">Tentang Kami</a></li>
          <li class="nav-item action"><a class="nav-link active resep" href="#resep">Resep</a></li>
          <li class="nav-item action"><a class="nav-link active kontak" href="#contact">Kontak</a></li>
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
      </div>

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

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- sweetalert2-->
    <script src="{{asset('plugins/sweetalert2.min.js')}}"></script>
    <!-- script -->
    <script src="{{asset('js/script.js')}}"></script>
  </body>
</html>
