<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Cookers</title>

    <!-- Feathere Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />

    <!-- My styles -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />

    <!-- CSS sweetalert2-->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2.min.css')}}">
  </head>
  <body>
    <!-- 
  @if ($message = Session::get('success'))
            <script>
                $(function() {
                    Swal.fire({
                        title: 'Success',
                        text: "{{ $message }}",
                        icon: 'success'
                    });
                });
            </script>
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif -->
    <!-- Navbar start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo">the<span>cookers</span>.</a>

      <div class="navbar-nav">
        <a class="menu-list" href="#home">@lang('dashboard.home')</a>
        <a class="menu-list" href="#about">@lang('dashboard.aboutus')</a>
        <a class="menu-list" href="#resep">@lang('dashboard.recipe')</a>
        <a class="menu-list" href="#contact">@lang('dashboard.contact')</a>
        
        @if (!auth()->check())
        <a class="menu-list" href="{{route('register')}}">@lang('dashboard.signup')</a>
        <a class="menu-list" href="{{route('login')}}">@lang('dashboard.signin')</a>
        @else
        <!-- <a class="menu-list" href="{{ route('logout') }}">@lang('dashboard.logout')</a> -->
        <a href="#" class="logout" id="log" onclick="logoutConfirmation()">@lang('dashboard.logout')</a>
        @endif
        <a class="menu-list" href="{{ route('profiles.index') }}">@lang('dashboard.profile')</a>
        <form class="menu-list" method="POST" action="{{ route('change-locale') }}">
            @csrf
            <select class="menu-list" style='background:transparent' name="locale" onchange="this.form.submit()">
                @if(session('locale') == 'id')
                    <option style='background:#ffcf9c' value="en" >en</option>
                    <option style='background:#ffcf9c' value="id" selected>id</option>
                @else
                    <option style='background:#ffcf9c' value="en" selected>en</option>
                    <option style='background:#ffcf9c' value="id">id</option>
                @endif
            </select>
        </form>
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
        <h1>@lang('dashboard.lets') <span>@lang('dashboard.cook')!</span></h1>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores,
          similique?
        </p>
        <a href="#" class="cta">@lang('dashboard.cooknow')</a>
      </main>
    </section>
    <!-- Hero Section End -->

    <!-- Feather Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My JavaScript -->
    <script src="{{asset('js/script.js')}}"></script>

    <!-- JS sweetalert2-->
    <script src="{{asset('plugins/sweetalert2.min.js')}}"></script>
    <script>
        function logoutConfirmation() {
            Swal.fire({
                title: 'Logout?',
                text: "Apakah Anda yakin",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                  let url = "{{ route('logout') }}";
                  document.location.href = url;
                }
            })
        }
    </script>
  </body>
</html>
