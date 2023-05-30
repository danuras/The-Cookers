const navbar = document.createElement('header');

navbar.innerHTML = `
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
          <li>
            <a class="auth" href="#" id="log" onclick="logoutConfirmation()">
              Keluar
            </a>
          </li>
      </ul>
    </nav>
`;

const navbarContainer = document.getElementById('navbar-container');
navbarContainer.appendChild(navbar)

const logoutLink = document.getElementById('log');
logoutLink.setAttribute('onclick', 'logoutConfirmation()')

const script = document.createElement('script');
script.src = "{{asset('js/script.js')}}";
document.head.appendChild(script);