<center><h1>Cara Pemakaian</h1></center>

<h2>Kebutuhan alat</h2>
<ol>
<li>PHP versi 8.1&gt;</li>
<li>Composer</li>
<li>Xampp</li>
</ol>

<h2>Instalasi</h2>
<ol>
    <li>Run <code style="white-space: pre;">git clone https://github.com/danuras/The-Cookers.git</code></li>
<li>Pada xampp buat database bernama <code style="white-space: pre;">cookers</code> dengan perintah <code style="white-space: pre;">create database cookers</code></li>
<li>Run <code style="white-space: pre;">composer install</code> di folder projek yang sudah diclone</li>
    <li>duplikat file <code style="white-space: pre;">.env.example</code> lalu rename hasil duplikatnya dengan <code style="white-space: pre;">.env</code></li>
    <li>konfigurasi file <code style="white-space: pre;">.env</code> seperti yang sudah di kirim digrup whatsapp</li>
    <li>Run <code style="white-space: pre;">php artisan migrate</code> untuk membuat table-table database</li>
</ol>

<h2>Cara Merun projek</h2>
<ol>
    <li>Run phpmyadmin dari xampp</li>
    <li>Run <code style="white-space: pre;">php artisan serve</code> untuk menjalankan projek</li>
    <li>Buka url <code style="white-space: pre;">127.0.0.1</code> pada browser</li>
</ol>

<h2>Cara mengosongkan isi database</h2>
<ol>
    <li>Run <code style="white-space: pre;">php artisan migrate:rollback</code></li>
    <li>Run <code style="white-space: pre;">php artisan migrate</code></li>
</ol>
