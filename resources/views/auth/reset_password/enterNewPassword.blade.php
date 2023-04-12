<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Masukan Password Baru</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    </head>
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mb-2">
                        <h2>Masukan Password Baru</h2>
                    </div>
            </div>
        </div>
            <form action="{{ route('save-new-password') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <input type="text" name="email" class="form-control" placeholder="Kode Verifikasi" value="{{ Session::get('erp') }}" hidden>
                
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                                <input type="password" name="password" class="form-control" placeholder="password" autocomplete="new-password">
                                    @error('password')
                                        <div class="alert alert-danger mt-1 mb-1">Password Harus minimal 8 karakter, 1 huruf kecil dan besar, memiliki 1 digit huruf, dan memiliki karakter spesial</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Masukan kembali password:</strong>
                                <input type="password" name="c_password" class="form-control" placeholder="Masukan kembali password" autocomplete="new-password">
                                @error('c_password')
                                    <div class="alert alert-danger mt-1 mb-1">Masukan kembali password Harus Diisi</div>
                                @enderror
                        </div>
                    </div>
                    
                    @error('s_password')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @error('ecode')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>  
            </form>
    </body>
</html>