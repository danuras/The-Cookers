<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Edit Resep</title>
        <link rel="stylesheet" href="{{ asset ('css/style-editresep.css')}}" />
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <img
                        class="logo-img"
                        src="{{ asset ('assets/logo.png') }}"
                        alt=""
                    />
                </div>
                <nav>
                    <input type="checkbox" id="menu-toggle" />
                    <label for="menu-toggle" class="menu-icon">&#9776;</label>
                    <ul class="menu">
                        <li><a href="#">HOME</a></li>
                        <li><a href="#">RECEIPT</a></li>
                        <li>
                            <button class="btn">UPLOAD RECEIPT</button>
                        </li>
                        <li>
                            <button class="btn">PROFILE</button>
                        </li>
                    </ul>
                </nav>
            </div>

            <br />

            <div class="container2">
                <div class="foto-user">
                    <img
                        class="user-foto"
                        src="{{ asset ('assets/user.jpg')}}"
                        alt=""
                    />
                </div>
                <nav>
                    <input type="checkbox" id="nav2-toggle" />
                    <label for="nav2-toggle" class="nav2-icon">&#9776;</label>
                    <ul class="nav2">
                        <li>
                            <button href="#myreceipt" class="btn2">
                                MY RECEIPT
                            </button>
                        </li>
                        <li>
                            <button href="#favourite" class="btn2">
                                FAVOURITE
                            </button>
                        </li>
                        <li>
                            <button href="#notifikasi" class="btn2">
                                NOTIFIKASI
                            </button>
                        </li>
                        <li>
                            <button href="#setting" class="btn2">
                                SETTING
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div id="myreceipt" class="page">
            <div class="content">
                <p>Edit Resep</p>
                <br />
                <hr />
                <br />
                <div class="edit">
                    <a href="" class="name">Sushi</a>

                    <a href="" class="edit">Edit</a>

                    <a href="" class="del">Delete</a>
                </div>
                <br />

                <hr />
            </div>

            <div class="content">
                <br />
                <div class="edit">
                    <a href="" class="name2">Sashimi</a>

                    <a href="" class="edit2">Edit</a>

                    <a href="" class="del">Delete</a>
                </div>
                <br />

                <hr />
            </div>

            <div class="content">
                <br />
                <div class="edit">
                    <a href="" class="name3">Mendoan</a>

                    <a href="" class="edit3">Edit</a>

                    <a href="" class="del">Delete</a>
                </div>
                <br />
                <hr />
            </div>

            <div class="content">
                <br />
                <div class="edit">
                    <a href="" class="name4">Udon</a>

                    <a href="" class="edit4">Edit</a>

                    <a href="" class="del">Delete</a>
                </div>
                <br />
                <hr />
            </div>
        </div>

        <div id="notifikasi" class="page">
            <p>Notifikasi</p>
            <br />
            <hr />
            <br />
            <div class="notif-content">
                <p href="" class="notif-komen"></p>
                    Dame menambahkan komentar pada resep ikan bakar anda
                </p>

                <p href="" class="notif-time">2 jam yang lalu</p>
            </div>
            <br />

            <hr />

            <div class="notif-content">
                <p href="" class="notif-komen">
                    Lia menambahkan komentar pada resep ayam goreng anda
                </p>

                <p href="" class="notif-time">2 jam yang lalu</p>
            </div>
            <br />

            <hr />
        </div>
        <script src="edit-resep.js"></script>
    </body>
</html>
