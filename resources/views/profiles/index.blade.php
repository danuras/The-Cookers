<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profil</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    </head>
    <body>
        <div class="container mt-2">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Profil</h2>
                    </div>
                    
                <div class="pull-right">
                    <a class="btn btn-primary" href="/">Kembali</a>
                </div>
                </div>
            </div>
            
            <div class="col-lg-12 margin-tb">
                @if ($profiles->photo_profile)
                
                    <img src="data:image/png;base64,{{ base64_encode($profiles->photo_profile) }}" alt="profile.png" width="200" height="200">
                @else
                    <img src="{{ asset('assets/default/profile.png') }}" alt="Foto Profil Default"  width="200" height="200">
                @endif
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama:</strong>
                                <p>{{$profiles->name}}</p>
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Username:</strong>
                                <p>{{$profiles->username}}</p>
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>    
                            <p>{{$profiles->email}}</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Gender:</strong>
                        @if($profiles->gender == 'L')
                            <p>Laki-laki</p>
                        @else
                            <p>Perempuan</p>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Info:</strong>
                                <p>{{$profiles->info}}</p>
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Bio:</strong>
                                <p>{{$profiles->bio}}</p>
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>No_telp:</strong>
                                <p>{{$profiles->no_phone}}</p>
                            </div>
                    </div>
                    <a class="btn btn-primary" href="{{ route('profiles.edit',$profiles->id) }}">Edit</a>
        </div>
    </body>
</html>