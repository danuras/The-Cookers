<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Profil</title>
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport"
        />
        <link rel="icon" type="image/png" href="{{asset('assets/cookers.png')}}">
        <link
            rel="stylesheet"
            type="text/css"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        />
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body class="bg">
        <section class="py-5 my-5">
            <div class="container">
                <h1 class="mb-5">Profil</h1>
                <div
                    class="bg-white shadow rounded-lg d-block d-sm-flex"
                    id="section-tengah"
                >
                    <div class="profile-tab-nav border-right" id="section-kiri">
                        <div class="p-4">
                            <div class="img-circle text-center mb-3">
                                <img
                                    src="img/user2.jpg"
                                    alt="Image"
                                    class="shadow"
                                    id="profile-pic"
                                />
                            </div>

                            <h4 class="text-center"><span></span></h4>
                        </div>
                        <div class="upload-foto">
                            <label for="input-file" class="foto"
                                >Upload foto</label
                            >
                            <input
                                type="file"
                                accept="image/jpeg, image/png, image/jpg"
                                id="input-file"
                            />
                        </div>

                        <div
                            class="nav flex-column nav-pills"
                            id="v-pills-tab"
                            role="tablist"
                            aria-orientation="vertical"
                        >
                            <a
                                class="nav-link active"
                                id="account-tab"
                                data-toggle="pill"
                                href="#account"
                                role="tab"
                                aria-controls="account"
                                aria-selected="true"
                            >
                                <i
                                    class="fa fa-home text-center mr-1"
                                    id="account"
                                ></i>
                                Account
                            </a>
                            <a
                                class="nav-link"
                                id="password-tab"
                                data-toggle="pill"
                                href="#password"
                                role="tab"
                                aria-controls="password"
                                aria-selected="false"
                            >
                                <i
                                    class="fa fa-key text-center mr-1"
                                    id="password"
                                ></i>
                                Password
                            </a>
                            <a
                                class="nav-link"
                                id="security-tab"
                                data-toggle="pill"
                                href="#security"
                                role="tab"
                                aria-controls="security"
                                aria-selected="false"
                            >
                                <i
                                    class="fa fa-user text-center mr-1"
                                    id="security"
                                ></i>
                                Security
                            </a>
                        </div>
                    </div>
                    <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                        <div
                            class="tab-pane fade show active"
                            id="account"
                            role="tabpanel"
                            aria-labelledby="account-tab"
                        >
                            <h3 class="mb-4">Edit Profil</h3>
                            <form class="row" action="{{ route('profiles.update',$profile->id) }}" method="POST" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input
                                            type="text"
                                            id="name"
                                            class="form-control"
                                            value="{{$profiles->name}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{$profiles->username}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{$profiles->email}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{$profiles->no_phone}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control">
                                            @if($profiles->gender == "L")
                                                <option 
                                                    value="L"
                                                    selected>
                                                        Laki-Laki
                                                </option>
                                                <option 
                                                    value="P">
                                                        Perempuan
                                                </option>
                                            @else
                                                <option 
                                                    value="L">
                                                        Laki-Laki
                                                </option>
                                                <option 
                                                    value="P"
                                                    selected>
                                                        Perempuan
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Info</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{$profiles->info}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea
                                            class="form-control"
                                            rows="4">
                                                {{$profiles->bio}}
                                    </textarea>
                                    </div>
                                </div>
                                <div>
                                    <button
                                        class="btn btn-primary"
                                        id="account-update"
                                        type="submit"
                                    >
                                        Update
                                    </button>
                                    <button
                                        class="btn btn-light"
                                        id="account-cancel"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="password"
                            role="tabpanel"
                            aria-labelledby="password-tab"
                        >
                            <h3 class="mb-4">Password Settings</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm new password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button
                                    class="btn btn-primary"
                                    id="password-update"
                                >
                                    Update
                                </button>
                                <button
                                    class="btn btn-light"
                                    id="password-cancel"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="security"
                            role="tabpanel"
                            aria-labelledby="security-tab"
                        >
                            <h3 class="mb-4">Security Settings</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Login</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Two-factor auth</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="recovery"
                                            />
                                            <label
                                                class="form-check-label"
                                                for="recovery"
                                            >
                                                Recovery
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button
                                    class="btn btn-primary"
                                    id="security-update"
                                >
                                    Update
                                </button>
                                <button
                                    class="btn btn-light"
                                    id="security-cancel"
                                >
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
            $(document).ready(function () {
                $("button").click(function () {
                    var name = $("#name").val();
                    $("span").html(name);
                });
            });
            let profilePic = document.getElementById("profile-pic");
            let inputFile = document.getElementById("input-file");

            inputFile.onchange = function () {
                profilePic.src = URL.createObjectURL(inputFile.files[0]);
            };
        </script>
    </body>
</html>
