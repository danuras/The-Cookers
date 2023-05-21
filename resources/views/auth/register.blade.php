<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@lang('register.signup')</title>
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
                        <h2>@lang('register.signup')</h2>
                    </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="/">@lang('register.back')</a>
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
                                <strong>@lang('register.name'):</strong>
                                <input type="text" name="name" value = '{{old("name")}}' class="form-control" placeholder=@lang('register.name') autocomplete="off">
                                    @error('name')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('register.username'):</strong>
                                <input type="text" name="username" value = '{{old("username")}}' class="form-control" placeholder="@lang('register.username')" autocomplete="off">
                                    @error('username')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>@lang('register.email'):</strong>
                                <input type="email" name="email" value = '{{old("email")}}' class="form-control" placeholder="@lang('register.email')" autocomplete="new-password">
                                    @error('email')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>@lang('register.password'):</strong>
                                <input type="password" name="password" value = '{{old("password")}}' class="form-control" placeholder="@lang('register.password')" autocomplete="new-password">
                                    @error('password')
                                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>@lang('register.re_enter_password'):</strong>
                                <input type="password" name="password_confirmation" value = '{{old("password_confirmation")}}' class="form-control" placeholder="@lang('register.re_enter_password')" autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>@lang('register.photo_profile'):</strong>
                            @if(session('photo_profile_c'))
                                <img id="gambar-preview"  onclick = 'document.getElementById("pp").click()' src="{{ asset(session('photo_profile_c')) }}" alt="Preview Gambar"  width="200" height="200">
                                
                                <input type="hidden" id = 'last_pp' name="last_pp" value = "{{session('photo_profile_c')}}"  class="form-control">
                            @else
                                <img id="gambar-preview" onclick = 'document.getElementById("pp").click()' src="{{asset('assets/default/profile.png')}}" alt="profile.png"  width="200" height="200">
                            @endif
                            <input type="file" onchange="tampilkanGambar(this);" id = 'pp' name="photo_profile"  class="form-control" accept="image/*" hidden>
                                @error('photo_profile')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>@lang('register.gender'):</strong>
                        <input type="radio" id="male" name="gender" value="L">
                        <label for="male">@lang('register.male')</label>

                        <input type="radio" id="female" name="gender" value="P">
                        <label for="female">@lang('register.female')</label>
                    </div>
                    @error('gender')
                        <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                    @enderror
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('register.info'):</strong>
                                <input type="text" name="info"  value = '{{old("info")}}' class="form-control" placeholder="@lang('register.info')" autocomplete="off">
                                @error('info')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('register.bio'):</strong>
                                <textarea type="text" name="bio" value = '{{old("bio")}}' class="form-control" placeholder="@lang('register.bio')" autocomplete="off"></textarea>
                                @error('bio')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('register.phone_number'):</strong>
                                <input type="text" name="no_phone" value = '{{old("no_phone")}}' class="form-control" placeholder="@lang('register.phone_number')" autocomplete="off">
                                @error('no_phone')
                                    <div class="alert alert-danger mt-1 mb-1">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div>
                        <input type="checkbox" id="remember_me" name="remember_me">
                        <label for="agree">@lang('register.remember_me')</label>
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">@lang('register.submit')</button>
                </div>
            </form>
    </body>
</html>