<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Edit Resep Upload</title>
        <link rel="stylesheet" href="{{asset('css/style-editresep-upload.css')}}" />
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <img
                        class="logo-img"
                        src="{{asset('assets/logo.png')}}"
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
        </header>

        <br />

        <div class="page active" id="page1">
            <div class="content">
                <h3>EDIT RESEP KAMU</h3>
                <div class="box">
                    <div class="img-upload">
                        <img
                            class="image"
                            src="{{asset('assets/upload.png')}}"
                            alt=""
                        />
                    </div>

                    <br />

                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="file" id="photoInput" accept="image/*" />
                        <button class="upload" type="submit">
                            Upload Image
                        </button>
                    </form>
                </div>

                <br />
                <div class="button-prevnext">
                    <div class="button-container">
                        <button onclick="goToPage('page0')">Previous</button>
                    </div>

                    <div class="button-container">
                        <button onclick="goToPage('page2')">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="page" id="page2">
            <div class="content">
                <h3>EDIT RESEP KAMU</h3>
                <div class="box">
                    <!-- <div class="gallery" id="photoGallery"></div> -->
                    <div id="imageContainer1"></div>

                    <br />

                    <form
                        id="inputForm"
                        onsubmit="event.preventDefault(); displayResult();"
                    >
                        <div class="input-container">
                            <label for="nameInput">Nama Resep</label>
                            <input
                                type="text"
                                id="nameInput"
                                placeholder="Masukkan Nama Resep"
                            />
                        </div>

                        <div class="input-container">
                            <label for="paragraphInput">Deskripsi Resep</label>
                            <textarea
                                id="paragraphInput"
                                placeholder="Masukkan Deskripsi Resep"
                            ></textarea>
                        </div>

                        <div class="input-container">
                            <label for="numberInput">Waktu Memasak</label>
                            <input
                                type="number"
                                id="numberInput"
                                placeholder="Masukkan Waktu Memasak"
                            />
                            <label for="">(Menit)</label>
                        </div>

                        <div class="input-container">
                            <label for="servingInput">Jumlah Porsi</label>
                            <input
                                type="number"
                                id="servingInput"
                                placeholder="Masukkan Jumlah Porsi"
                            />
                        </div>

                        <div class="input-container">
                            <label for="linkInput">Link Video Youtube</label>
                            <input
                                type="url"
                                id="linkInput"
                                placeholder="Masukkan Link Youtube"
                            />
                        </div>

                        <div class="input-container">
                            <label for="ingredientsInput"
                                >Bahan-Bahan Masakan</label
                            >
                            <textarea
                                id="ingredientsInput"
                                placeholder="Masukkan Bahan-Bahan Masakan"
                            ></textarea>
                        </div>

                        <div class="input-container">
                            <label for="stepsInput"
                                >Langkah-Langkah Memasak</label
                            >
                            <textarea
                                id="stepsInput"
                                placeholder="Langkah-Langkah Memasak"
                            ></textarea>
                        </div>

                        <div class="button-container">
                            <button
                                onclick="tampilkanBahan(), tampilkanLangkah(), tampilkanVideo()"
                                class="upload"
                                type="submit"
                            >
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>

                <div class="button-prevnext">
                    <div class="button-container">
                        <button onclick="goToPage('page1')">Previous</button>
                    </div>

                    <div class="button-container">
                        <button onclick="goToPage('page3')">Next</button>
                    </div>
                </div>

                <br />
            </div>
        </div>

        <div class="page" id="page3">
            <div class="content">
                <h3>EDIT RESEP KAMU</h3>
                <div class="box">
                    <div id="imageContainer2"></div>
                    <br />

                    <div id="resultContainer"></div>
                    <h4>Bahan-Bahan Masakan:</h4>
                    <ol id="bahanList"></ol>
                    <h4>Langkah-Langkah Memasak:</h4>
                    <ol id="langkahList"></ol>
                    <h4>Link Video Youtube:</h4>
                    <div id="videoContainer"></div>
                </div>

                <div class="button-prevnext">
                    <div class="button-container">
                        <button onclick="goToPage('page2')">Previous</button>
                    </div>

                    <div class="button-container">
                        <button onclick="goToPage('page4')">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="page" id="page4">
            <div class="content">
                <div class="box">
                    <p>Terimakasih resep anda berhasil di edit</p>
                    <button class="oke">Oke</button>
                </div>
            </div>
        </div>
        <script src="editresep-upload.js"></script>
    </body>
</html>
