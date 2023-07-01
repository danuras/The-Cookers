<!DOCTYPE html>
<html>
<head>
    <title>Upload Gambar</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-upload-resep.css') }}">
    
</head>
<body>
    <!-- Menu -->
    <div class="container">
      <ul class="menu1">
        <div class="preview-container">
            @if(session('image_url_r'))
                <img id="preview2" src="{{ asset(session('image_url_r')) }}">
            @else
                <img id='preview2' src="{{ asset('assets/upload-resep-img/upload.png') }}">
            @endif
        </div>
      </ul>

      <h5 class="judul">
        <p class="" id="output-nama-resep">{{session('r_name')}}</p>
      </h5>
      <hr />

      <div class="navbar-2">
          <p class="waktu">
            <p class="" id="output-waktu-penyajian">Waktu Penyajian {{session('r_cooking_time')}} menit</p>
          </p>
          <img
              class="fork"
              src="{{ asset('assets/upload-resep-img/fork.png') }}"
              alt=""
          />
          <p class="porsi">
            <p class="" id="output-porsi">{{session('r_portion')}} porsi</p>
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
        <p class="" id="output-deskripsi-resep">{{session('r_description')}}</p>
      </div>

      <div class="bahan">
          <h4>Bahan - Bahan</h4>
          <div class="square"></div>
          <p class="" id="output-bahan">
            @for ($i = 1; $i <= sizeof($ingredients); $i++)
                <p>{{$i}}. {{$ingredients[$i-1]}}</p>
            @endfor
          </p>
      </div>

      <div class="cara">
          <h4>Cara Membuat</h4>
          <div class="square"></div>
          <p class="" id="output-langkah-masak">
            @for ($i = 1; $i <= sizeof($steps); $i++)
                <p>{{$i}}. {{$steps[$i-1]}}</p>
            @endfor
          </p>
      </div>
      <br />
      <br />

      
    <center>
        <!-- Tombol Sebelumnya -->
        <a class="button" type="submit" href="{{route('recipes.edit-recipe-atribute')}}" style="text-decoration: none;">Sebelumnya</a>
        <!-- Tombol Selanjutnya -->

        <a class="button" type="submit" href="{{route('recipes.finish-edit-recipe')}}" style="text-decoration: none;">Kirim</a>
    </center>
  </div>
    <br>

    <!-- <script src="{{ asset('js/script-upload-resep.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
        function extractVideoId(url) {
            var regExp =
                /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|\?v=)([^#&?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length === 11) {
                return match[2];
            } else {
                return null;
            }
        }
        var videoLink = '{{session("r_video_url")}}';
        var videoId = extractVideoId(videoLink);

        var previewContainer = document.getElementById("video-preview-container");
        previewContainer.innerHTML = "";

        if (videoId) {
            var iframe = document.createElement("iframe");
            iframe.classList.add("video-preview");
            iframe.src = "https://www.youtube.com/embed/" + videoId;
            iframe.title = "YouTube Video";
            iframe.frameborder = "0";
            iframe.allow =
            "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
            iframe.allowfullscreen = true;
            previewContainer.appendChild(iframe);

        } else {
            previewContainer.innerHTML = "Link YouTube tidak valid.";
        }
    </script>
</body>
</html>