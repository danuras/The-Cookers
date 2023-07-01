<!DOCTYPE html>
<html>
<head>
    <title>Upload Gambar</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-upload-resep.css') }}">
    
</head>
<body>
    <div id="page1" class="page active">
        <h1>Upload Resep</h1>
        <!-- <input id="upload-input" type="file" accept="image/*"  /> -->
        <br>
        @if (session('image_url_r'))
            <img class="shadow" id="preview"
                src="{{ asset(session('image_url_r')) }}" alt="Profile"
            >
        @else
            <img class="shadow" id="preview" src="{{ asset('assets/upload-resep-img/upload.png') }}" alt="Profile">
        @endif
        <!-- <img id="preview" src="{{ asset('assets/upload-resep-img/upload.png') }}"/> -->
        <p id="file-info"></p>
        
        @error('image_url')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
        <label for="upload-input" id="upload-label">Upload Gambar</label>

    </div>
    <br>
    <center>
        <!-- Tombol Sebelumnya -->
        <a class="button" type="submit" href="/" style="text-decoration: none;">Sebelumnya</a>
        <!-- Tombol Selanjutnya -->
        <form  action = "{{route('save.recipes.upload-image')}}" method = "POST" style = "display: inline-block; vertical-align: middle;" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <input type="file" accept="image/jpeg, image/png, image/jpg" id="upload-input" name='image_url' class="form-control" onchange="previewImage(event)" hidden />
            <button id="nextButton" class="button" type = "submit">Selanjutnya</button>
        </form>
    </center>

    <!-- <script src="{{ asset('js/script-upload-resep.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $("button").click(function() {
                var name = $("#name").val();
                $("span").html(name);
            });
        });
        let profilePic = document.getElementById("preview");
        let inputFile = document.getElementById("upload-input");

        inputFile.onchange = function() {
            profilePic.src = URL.createObjectURL(inputFile.files[0]);
        };
    </script>
</body>
</html>