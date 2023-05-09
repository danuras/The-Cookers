<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    </head>
    <body>
        @if ($message = Session::get('success'))
            <script>
                $(function() {
                    Swal.fire({
                        title: 'Success',
                        text: "{{ $message }}",
                        icon: 'success'
                    });
                });
            </script>
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">

            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Dashboard</h2>
                </div>
                @if (!auth()->check())
                    <div class="pull-right mb-2">
                        <a class="btn btn-success" href="{{route('register')}}">@lang('dashboard.signup')</a>
                    </div>
                    <div class="pull-right mb-2">
                        <a class="btn btn-success" href="{{route('login')}}">@lang('dashboard.signin')</a>
                    </div>
                @else
                    <form action="{{ route('logout') }}" method="Post">
                        @csrf
                        <button type="submit" class="btn btn-danger">@lang('dashboard.logout')</button>
                    </form>
                @endif
                <form action="{{ route('profiles.index') }}" method="GET" enctype="multipart/form-data">
                    <div class="row">
                        <button type="submit" class="btn btn-primary ml-3">Profile</button>
                    </div>  
                </form><form method="POST" action="{{ route('change-locale') }}">
                    @csrf
                    <select name="locale" onchange="this.form.submit()">
                        @if(session('locale') == 'id')
                            <option value="en" >en</option>
                            <option value="id" selected>id</option>
                        @else
                            <option value="en" selected>en</option>
                            <option value="id">id</option>
                        @endif
                    </select>
                </form>
            </div>
        </div>

    </body>
</html>