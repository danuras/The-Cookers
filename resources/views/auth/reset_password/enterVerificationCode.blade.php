<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verifikasi Kode</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
        <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}">
        
    </head>
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mb-2">
                        <h2>Verifikasi Kode</h2>
                    </div>
            </div>
        </div>
        @if(session('status'))

            <div class="alert alert-danger mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
            <form action="{{ route('verify-code') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Kode Verifikasi:</strong>
                            <input type="text" name="verification_code" value="{{old('verification_code')}}" class="form-control" placeholder="Kode Verifikasi">
                                
                            @error('verification_code')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                            <input type="text" name="email" class="form-control" placeholder="Kode Verifikasi" value = "{{Session::get('erp')}}" hidden>
                        

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @error('ecode')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="ml-3" id="btn-submit">Submit</button>
                </div>  
                
            </form>
            <form action="{{ route('send-verification-code-reset-password') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="email" class="form-control" placeholder="Kode Verifikasi" value = "{{Session::get('erp')}}" hidden>
                
                <div class="row pt-2">
                    <button type="submit" class="btn btn-primary ml-3">Kirim Kode lagi</button>
                </div>  
            </form>
    </body>
</html>