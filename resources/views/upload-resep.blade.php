<!DOCTYPE html>
<html>
<head>
    <title>Tiga Halaman dalam Satu File HTML</title>
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/style-upload-resep.css')}}">
</head>
<body>
    <!-- Konten Halaman 1 -->
    <div id="page1" class="page active">
        <h1>Upload Resep</h1>
        <input id="upload-input" type="file" accept="image/*" onchange="previewImage(event)" />
        <br>
        <img id="preview" src="{{ asset ('assets/upload.png')}}"/>
        <p id="file-info"></p>
        <label for="upload-input" id="upload-label">Upload Gambar</label>
    </div>

    <!-- Konten Halaman 2 -->
    <div id="page2" class="page">
        <div class="container">
            <h2>Unggah Resep</h2>
            <div class="form-container">
              <form  method="post" enctype="multipart/form-data">
                <div class="preview-container">
                  <img id="preview1">
                  
                </div>
                <label for="nama_resep">Nama Resep:</label>
                <input type="text" id="nama_resep" name="nama_resep" required>
                
                <label for="deskripsi_resep">Deskripsi Resep:</label>
                <textarea id="deskripsi_resep" name="deskripsi_resep" rows="4" required></textarea>
                
                <label for="waktu_penyajian">Waktu Penyajian (menit):</label>
                <input type="number" id="waktu_penyajian" name="waktu_penyajian" min="1" required>
                
                <label for="porsi">Porsi:</label>
                <input type="number" id="porsi" name="porsi" min="1" required>
                
                <label for="video_youtube">Tautan Video YouTube:</label>
                <input type="text" id="video_youtube" name="video_youtube" required>
                
                <label for="bahan">Bahan-bahan:</label>
                <textarea id="bahan" name="bahan" rows="4" required></textarea>
  
                <label for="langkah_masak">Langkah-langkah Memasak:</label>
                <textarea id="langkah_masak" name="langkah_masak" rows="4" required></textarea>
                
              </form>
            </div>
          </div>
    </div>

    <!-- Konten Halaman 3 -->
    <div id="page3" class="page">
      
        
        
        
        
        
        <p class="" id="output-video-youtube"></p>
        
        
      
    <!-- Menu -->
    <div class="container">
      <ul class="menu1">
        <div class="preview-container">
          <img id="preview2">
      </div>
      </ul>

      <h5 class="judul">
        <p class="" id="output-nama-resep"></p>
      </h5>
      <hr />

      <div class="navbar-2">
          <p class="waktu">
            <p class="" id="output-waktu-penyajian"></p>
          </p>
          <img
              class="fork"
              src="{{asset ('asset/fork.png')}}"
              alt=""
          />
          <p class="porsi">
            <p class="" id="output-porsi"></p>
          </p>
      </div>

      <hr />

      <!-- <img
          class="youtube"
          src="img/youtube.png"
          alt=""
      /> -->
      <div class="youtube" id="video-preview-container"></div>
      <h5 class="tutorial">Watch Video Tutorial</h5>

      <hr />

      <div class="bahan">
        <h4>Deskripsi</h4>
        <div class="square"></div>
        <p class="" id="output-deskripsi-resep"></p>
    </div>

      <div class="bahan">
          <h4>Bahan - Bahan</h4>
          <div class="square"></div>
          <p class="" id="output-bahan"></p>
      </div>

      <div class="cara">
          <h4>Cara Membuat</h4>
          <div class="square"></div>
          <p class="" id="output-langkah-masak"></p>
      </div>
      <br />
      <br />
  </div>
    </div>


    <div id="page1">
        <!-- Tombol Sebelumnya -->
    <button class="button" onclick="showPreviousPage()">Sebelumnya</button>

    <!-- Tombol Selanjutnya -->
    <button id="nextButton" class="button" onclick="saveDataAndShowNextPage()">Selanjutnya</button>
    </div>   

    <script src="script.js"></script>
</body>
</html>
