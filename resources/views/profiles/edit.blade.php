<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Pengaturan Akun</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />

    <link rel="icon" type="image/png" href="{{ asset('assets/cookers.png') }}">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-profil-edit.css') }}" />
    {{-- bootstrap untuk alert validasi input --}}
    {{-- tapi ditambahi bootstrap malah ngubah css --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" > --}}
</head>

<body class="bg">
    <section class="py-5 my-5">
        <div class="container">
            <h1 class="mb-5">Pengaturan Akun</h1>
            <div class="bg-white shadow rounded-lg d-block d-sm-flex" id="section-tengah">
                <div class="profile-tab-nav border-right" id="section-kiri">
                    <div class="p-4">
                        <div class="img-circle text-center mb-3">
                            @if ($profile->photo_profile)
                                <img class="shadow" id="profile-pic"
                                    src="{{ asset($profile->photo_profile) }}"
                                    alt="Profile" width="200" height="200">
                            @elseif (session('photo_profile_c'))
                                <img class="shadow" id="profile-pic"
                                    src="data:image/png;base64,{{ session('photo_profile_c') }}" alt="Profile"
                                    width="200" height="200">
                                <input type="hidden" id='last_pp' name="last_pp"
                                    value="{{ session('photo_profile_c') }}" class="form-control">
                            @else
                                <img class="shadow" id="profile-pic" src="{{ asset('assets/default/profile.png') }}"
                                    alt="Profile" width="200" height="200">
                            @endif
                        </div>

                        <h4 class="text-center"><span></span></h4>
                    </div>

                    <div class="form-group">
                        <label for="input-file" class="foto">Upload foto</label>
                        @error('photo_profile')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab"
                            aria-controls="account" aria-selected="true">
                            <i class="fa fa-home text-center mr-1" id=""></i>
                            Akun
                        </a>
                        <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab"
                            aria-controls="password" aria-selected="false">
                            <i class="fa fa-key text-center mr-1" id=""></i>
                            Password
                        </a>
                        <a class="nav-link" id="security-tab" data-toggle="pill" href="#security" role="tab"
                            aria-controls="security" aria-selected="false">
                            <i class="fa fa-user text-center mr-1" id=""></i>
                            Keamanan
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md pt-5 d-flex justify-content-center">
                            <button id="btn-hapus-akun">
                                <a href="">Hapus Akun</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    @if (session('status'))
                        <div class="alert alert-success mb-1 mt-1">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                        <h3 class="mb-4">Edit profil</h3>
                        <form action="{{ route('profiles.update', $profile->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <input type="file" accept="image/jpeg, image/png, image/jpg" id="input-file"
                                    name='photo_profile' class="form-control" hidden />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" id="name" class="form-control"
                                            value="{{ $profile->name }}" name='name' />
                                        @error('name')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="{{ $profile->username }}"
                                            name='username' />
                                        @error('username')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="{{ $profile->email }}"
                                            name='email' />
                                        @error('email')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input type="text" {{-- harusnya bukan text --}} class="form-control"
                                            value="{{ $profile->no_phone }}" name='no_phone' />
                                        @error('')
                                            {{-- validasi no phone belum ada --}}
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name='gender'>
                                            @if ($profile->gender == '1')
                                                <option value="1" selected>Laki-laki</option>
                                                <option value="2">Perempuan</option>
                                                <option value="3">Tidak ingin memberitahu</option>
                                            @elseif($profile->gender == '2')
                                                <option value="1">Laki-laki</option>
                                                <option value="2" selected>Perempuan</option>
                                                <option value="3">Tidak ingin memberitahu</option>
                                            @elseif($profile->gender == '3')
                                                <option value="1">Laki-laki</option>
                                                <option value="2">Perempuan</option>
                                                <option value="3" selected>Tidak ingin memberitahu</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Info</label> {{-- harusnya ada max character --}}
                                        <input type="text" class="form-control" value="{{ $profile->info }}"
                                            name='info' />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bio</label> {{-- harusnya ada max character --}}
                                        <textarea class="form-control" name='bio' rows="4">
                                                {{ $profile->bio }}
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" id="account-update" type="submit">
                                    Simpan
                                </button>
                                <button class="btn btn-light" id="account-cancel">
                                    <a href="{{ route('profiles.index') }}">
                                        Kembali
                                    </a>
                                </button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <form action="{{ route('profiles.update', $profile->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <h3 class="mb-4">Password Settings</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old password</label>
                                        <input type="password" class="form-control" name='password' />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input type="password" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm new password</label>
                                        <input type="password" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" id="password-update">
                                    Simpan
                                </button>
                                <button class="btn btn-light" id="password-cancel">
                                    <a href="">
                                        Kembali
                                    </a>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <h3 class="mb-4">Security Settings</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Login</label>
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Two-factor auth</label>
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="recovery" />
                                        <label class="form-check-label" for="recovery">
                                            Recovery
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" id="security-update">
                                Update
                            </button>
                            <button class="btn btn-light" id="security-cancel">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("button").click(function() {
                var name = $("#name").val();
                $("span").html(name);
            });
        });
        let profilePic = document.getElementById("profile-pic");
        let inputFile = document.getElementById("input-file");

        inputFile.onchange = function() {
            profilePic.src = URL.createObjectURL(inputFile.files[0]);
        };
    </script>
</body>

</html>
