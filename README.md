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
    <li>Dowload xampp lalu install</li>
    <li>Buka phpmyadmin</li>
    <li>Pada phpmyadmin, buat database bernama <code style="white-space: pre;">cookers</code> dengan perintah <code style="white-space: pre;">create database cookers</code> pada query</li>
    <li>Tambahkan <code style="white-space: pre;">xampp/php</code> ke enviroment variables agar dapat menjalankan php di cmd</li>
    <li>Download Composer dengan cara run kode pada cmd (instruksi pada website Composer)<b>
    <li>Pada cmd, run <code style="white-space: pre;">composer install</code> di folder projek yang sudah diclone</li>
    <li>Duplikat file <code style="white-space: pre;">.env.example</code> lalu rename hasil duplikatnya dengan <code style="white-space: pre;">.env</code></li>
    <li>konfigurasi file <code style="white-space: pre;">.env</code> seperti yang sudah di kirim digrup whatsapp (copas aja semua isinya lalu tempel di <code style="white-space: pre;">.env</code>)</li>
    <li>Run <code style="white-space: pre;">php artisan migrate</code> untuk membuat table-table database</li>
    <li>Run <code style="white-space: pre;">php artisan db:seed --class=DatabaseSeeder</code> untuk mengisi data di database dengan data dami. Data daminya berupa akun user a@a dengan password = password</li>
</ol>

<h2>Cara Me-run projek</h2>
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

<h2>Cara konfigurasi file yang digunakan sebagai ui/tampilan web</h2>
<ol>
    <li>Folder <code style="white-space: pre;">resources/views</code>, folder ini digunakan untuk menyimpan file html view/tampilan dari website. ekstensinya .blade.php misal <code style="white-space: pre;">dashboard.blade.php</code></li>
    <li>Folder <code style="white-space: pre;">public</code>, folder ini digunakan untuk menyimpan file asset yang dapat diakses oleh file ui di folder <code style="white-space: pre;">resources/views</code>. untuk mengaksesnya dapat dengan cara seperti ini: <code style="white-space: pre;">href="{{asset('css/style.css')}}"</code>, dengan kode seperti itu akan meload file <code style="white-space: pre;">style.css</code> yang disimpan di folder <code style="white-space: pre;">public/css/style.css</code></li>
    <li>Folder <code style="white-space: pre;">public</code> juga dapat digunakan untuk menyimpan dan meload data asset bertipe lainnya seperti javascript dan gambar hanya saja untuk meloadnya pakai fungsi <code style="white-space: pre;">asset</code> seperti dicontoh sebelumnya </li>
    <li>Tampilan bisa dicek dengan merun projek seperti yang dijelaskan sebelumnya</li>
    <li>Untuk dapat berpindah dari page 1 ke page lainnya perlu dilakukan pembuatan dan pemanggilan route</li>
</ol>

<h2>Cara Pembuatan route</h2>
<ol>
    <li>Folder <code style="white-space: pre;">App/Http/Controller</code>, folder ini digunakan untuk menyimpan file controller yang berisi beberapa fungsi. Untuk membuat route, buat fungsi untuk memanggil file yang digunakan sebagai tampilan misal:
<pre><code class="language-php">
public function showRegistrationView()
{
    $this->loadLocale();
    return view('auth.register');
}
</code></pre>
        kode itu digunakan untuk memanggil file view yang tersimpan di folder <code style="white-space: pre;">resources/views/auth/register.blade.php</code>
    </li>
    <li>File <code style="white-space: pre;">web.php</code> pada folder <code style="white-space: pre;">routes/web.php</code> digunakan untuk menyimpan route yang digunakan misal:
        <pre><code class="language-php">Route::get('register', [AuthController::class, 'showRegistrationView'])->name('register');</code></pre>
        baris code diatas digunakan untuk membuat route <code style="white-space: pre;">/register</code> url ini dapat diterapkan pada file desain lain untuk menampilkan tampilan register. untuk menampilkan tampilan halaman register dapat menggunakan kode seperti ini:
<pre><code class="language-php">&lt;a class="menu-list" href="{{route('register')}}">@lang('dashboard.signup')&lt;/a&gt;   </code></pre></li>
    <li>route register itu dapat diakses dengan memasukan url <code style="white-space: pre;">127.0.0.1/register</code>pada web browser</li>
</ol>
        <h2>Link (sementara): https://thecookerrs.000webhostapp.com/</h2>

   
