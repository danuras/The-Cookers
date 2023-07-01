<!DOCTYPE html>
<html>
<head>
    <title>Upload Atribut Resep</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-upload-resep.css') }}">
    
</head>
<body>
        <div class="container">
            <h2>Unggah Resep</h2>
            <div class="form-container">
              <form  method="POST" enctype="multipart/form-data" action="{{route('save.recipes.upload-recipe-atribute')}}">
                @method("POST")
                @csrf
                @if(session('image_url_r'))
                <div class="preview-container">
                  <img id="preview1" src="{{asset(session('image_url_r'))}}">
                  
                @else    
                <div class="preview-container">
                  <img id="preview1" src="{{ asset('assets/upload-resep-img/upload.png') }}">
                @endif
                  
                </div>
                <label for="nama_resep">Nama Resep:</label>
                <input type="text" id="nama_resep" name="name" value = "{{session('r_name')}}" required>
                @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                
                <label for="deskripsi_resep">Deskripsi Resep:</label>
                <textarea id="deskripsi_resep" name="description"  rows="4" required>{{session('r_description')}}</textarea>
                
                @error('description')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                
                <label for="waktu_penyajian">Waktu Penyajian (menit):</label>
                <input type="number" id="waktu_penyajian" name="cooking_time" value = "{{session('r_cooking_time')}}" min="1" required>
                
                @error('cooking_time')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                
                <label for="porsi">Porsi:</label>
                <input type="number" id="porsi" name="portion" value = "{{session('r_portion')}}" min="1" required>
                
                @error('portion')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                
                <label for="video_youtube">Tautan Video YouTube:</label>
                <input type="text" id="video_youtube" name="video_url" value = "{{session('r_video_url')}}" required>
                
                
                <label for="bahan">Bahan-bahan:</label>
                @php
                    $ingredients = '';
                    if(session('r_ingredients')){
                        $list = session('r_ingredients');
                        $ingredients = implode("\n", $list);
                    }
                @endphp

                <textarea id="bahan" name="ingredients" rows="4" required>{{$ingredients}}</textarea>
                
                @error('ingredients')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
  
                <label for="langkah_masak">Langkah-langkah Memasak:</label>
                
                @php
                    $steps = '';
                    if(session('r_steps')){
                        $list = session('r_steps');
                        $steps = implode("\n", $list);
                    }
                @endphp
                <textarea id="langkah_masak" name="steps"  rows="4" required>{{$steps}}</textarea>
                
                @error('steps')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                
                <center>
                    <!-- Tombol Sebelumnya -->
                    <a class="button"  href="{{ route('recipes.upload-image') }}" style="text-decoration: none;">Sebelumnya</a>
                    <!-- Tombol Selanjutnya -->
                    <button id="nextButton" class="button" type = "submit">Selanjutnya</button>
                </center>
              </form>
            </div>
          </div>
    <br>

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