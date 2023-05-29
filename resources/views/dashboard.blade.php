<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Cookers</title>

  <link rel="icon" type="image/png" href="{{asset('assets/cookers.png')}}">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('plugins/sweetalert2.min.css')}}">
  
</head>
<body>
  <header>
    <div class="logo">
      <img class="logo-cookers" 
        src="{{asset('assets/cookers.png')}}" 
        alt="logo the cookers"
      >
    </div>
    <div class="hamburger">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <nav>
      <ul>
        <li>
          <a class="menu" href="#home">
            Beranda
          </a>
        </li>
          <li>
            <a class="menu" href="#about">
              Tentang Kami
            </a>
          </li>
          <li>
            <a class="menu" href="#resep">
              Resep
            </a>
          </li>
          <li>
            <a class="menu" href="#contact">
              Kontak
            </a>
          </li>
          @if (!auth()->check())
          <li>
            <a class="auth" href="{{route('register')}}">
              Daftar
            </a>
          </li>
          <li>
            <a class="auth" href="{{route('login')}}">
              Masuk
            </a>
          </li>
          @else
          <li>
            <a class="auth" href="#" id="log" onclick="logoutConfirmation()">
              Keluar
            </a>
          </li>
          <li>
            <a class="profil" href="{{route('profiles.index')}}">
              Profil
            </a>
          </li>
          @endif
      </ul>
    </nav>
  </header>
  <main>
    <div class="hero">
      <div class="content">
        <h1>
          Ayo 
          <span>
            Masak!
          </span>
        </h1>
        <p>
          Dapatkan Inspirasi Kuliner Terbaru dengan Resep Pilihan Terbaik Kami
        </p>
        <a href="#">
          <button class="btn btn-call-to-action">Masak Sekarang</button>
        </a>
      </div>
      <div class="kanan">
        <a href=""></a>
      </div>
    </div>
  </main>

  <script src="{{asset('plugins/sweetalert2.min.js')}}"></script>
  <script src="{{asset('js/script.js')}}"></script>
</body>

</html>
