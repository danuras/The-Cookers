<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Daftar</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
        <script type="text/javascript">
            function tampilkanGambar(input) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("gambar-preview").setAttribute("src", e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </head>
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mb-2">
                        <h2>Daftar</h2>
                    </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="/">Kembali</a>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama:</strong>
                                <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="off">
                                    @error('name')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Username:</strong>
                                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off">
                                    @error('username')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="new-password">
                                    @error('email')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                                <input type="password" name="password" class="form-control" placeholder="password" autocomplete="new-password">
                                    @error('password')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Masukan kembali password:</strong>
                                <input type="password" name="masukan_kembali_password" class="form-control" placeholder="Masukan kembali password" autocomplete="new-password">
                                @error('masukan_kembali_password')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                        </div>
                    </div>
                    
                    @error('s_password')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Photo Profile:</strong>
                                <img id="gambar-preview" src="{{asset('assets/default/profile.png')}}" alt="Preview Gambar"  width="200" height="200">    
                                <input type="file" onchange="tampilkanGambar(this);"  name="photo_profile"  class="form-control" accept="image/*">
                                @error('photo_profile')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Gender:</strong>
                        <input type="radio" id="male" name="gender" value="L">
                        <label for="male">Laki-laki</label>

                        <input type="radio" id="female" name="gender" value="P">
                        <label for="female">Wanita</label>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Info:</strong>
                                <input type="text" name="info" class="form-control" placeholder="Info" autocomplete="off">
                                @error('info')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Bio:</strong>
                                <textarea type="text" name="bio" class="form-control" placeholder="Bio" autocomplete="off"></textarea>
                                @error('bio')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nomor Telephon:</strong>
                                <input type="number" name="no_phone" class="form-control" placeholder="Nomor Handphone" autocomplete="off">
                                @error('no_phone')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div>
                        <input type="checkbox" id="remember_me" name="remember_me">
                        <label for="agree">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
    </body>
</html>