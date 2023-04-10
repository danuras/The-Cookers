<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    </head>
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mb-2">
                        <h2>Login</h2>
                    </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="/"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                                @error('email')
                                    <div class="alert alert-danger mt-1 mb-1">Email harus diisi</div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                                <input type="password" name="password" class="form-control" placeholder="password">
                                    @error('password')
                                        <div class="alert alert-danger mt-1 mb-1">Password harus diisi</div>
                                    @enderror
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" id="remember_me" name="remember_me">
                        <label for="remember_me">Remember Me</label>
                    </div>
                    @error('logine')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
            
    </body>
</html>