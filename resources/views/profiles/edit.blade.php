<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Profile</title>
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
                    <div class="pull-left">
                        <h2>Edit Profile</h2>
                    </div>
                    
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('profiles.index') }}" enctype="multipart/form-data"> Back</a>
                    </div>
                </div>
            </div>
            @if(session('status'))
                <div class="alert alert-success mb-1 mt-1">
                     {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('profiles.update',$profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama:</strong>
                                <input type="text" name="name" class="form-control" value="{{$profile->name}}">
                                    @error('name')
                                        <div class="alert alert-danger mt-1 mb-1">Nama Harus Diisi</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Username:</strong>
                                <input type="text" name="username" class="form-control" value="{{$profile->username}}">
                                    @error('username')
                                        <div class="alert alert-danger mt-1 mb-1">Username Harus Diisi</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                                <input type="email" name="email" class="form-control" value="{{$profile->email}}">
                                    @error('email')
                                        <div class="alert alert-danger mt-1 mb-1">Email Harus Diisi</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Photo Profile:</strong>
                                @if(session('photo_profile_c'))
                                    <img id="gambar-preview"  onclick = 'document.getElementById("pp").click()' src="data:image/png;base64,{{ session('photo_profile_c') }}" alt="Preview Gambar"  width="200" height="200">
                                    
                                    <input type="hidden" id = 'last_pp' name="last_pp" value = "{{session('photo_profile_c')}}"  class="form-control">
                                @elseif ($profile->photo_profile)
                                    <img id="gambar-preview" onclick = 'document.getElementById("pp").click()' src="data:image/png;base64,{{ base64_encode($profile->photo_profile) }}" alt="Preview Gambar"  width="200" height="200">
                                @else
                                    <img id="gambar-preview" onclick = 'document.getElementById("pp").click()' src="{{asset('assets/default/profile.png')}}" alt="Preview Gambar"  width="200" height="200">

                                @endif
                            <input type="file" onchange="tampilkanGambar(this);" id = 'pp' name="photo_profile"  class="form-control" accept="image/*" hidden>
                                @error('photo_profile')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Gender:</strong>
                        <input type="radio" id="male" name="gender" value="L" checked = "{{$profile->gender=='L'}}">
                        <label for="male">Laki-laki</label>

                        <input type="radio" id="female" name="gender" value="P" checked = "{{$profile->gender=='P'}}">
                        <label for="female">Wanita</label>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Info:</strong>
                                <input type="text" name="info" class="form-control"  value="{{$profile->info}}">
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Bio:</strong>
                                <textarea type="text" name="bio" class="form-control"  >{{$profile->bio}}</textarea>
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nomor Telephon:</strong>
                                <input type="number" name="no_phone" class="form-control" value="{{$profile->no_phone}}">
                            </div>
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>