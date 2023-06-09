<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Masukan Email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h2>Masukan Email</h2>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('reset-password') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="Email">

                        @error('email')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @error('ecode')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="ml-3" id="btn-submit">Submit</button>
            </div>
        </form>
</body>

</html>
