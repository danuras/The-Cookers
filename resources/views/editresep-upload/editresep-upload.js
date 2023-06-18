function changePage(pageName) {
    // Mengambil semua halaman
    var pages = document.getElementsByClassName("home");
    for (var i = 0; i < pages.length; i++) {
        // Menyembunyikan semua halaman
        pages[i].style.display = "none";
    }

    // Menampilkan halaman yang dipilih
    var selectedPage = document.getElementById(pageName);
    selectedPage.style.display = "block";
}

// document.getElementById("uploadForm").addEventListener("submit", function (e) {
//     e.preventDefault();

//     var fileInput = document.getElementById("photoInput");
//     var files = fileInput.files;

//     for (var i = 0; i < files.length; i++) {
//         var file = files[i];
//         var reader = new FileReader();

//         reader.onload = function (e) {
//             var img = document.createElement("img");
//             img.src = e.target.result;

//             var gallery = document.getElementById("photoGallery");
//             gallery.appendChild(img);
//         };

//         reader.readAsDataURL(file);
//     }

//     fileInput.value = "";
// });

var uploadForm = document.getElementById("uploadForm");
var photoInput = document.getElementById("photoInput");
var imageContainer1 = document.getElementById("imageContainer1");
var imageContainer2 = document.getElementById("imageContainer2");

uploadForm.addEventListener("submit", function (event) {
    event.preventDefault();

    var file = photoInput.files[0];
    var fileReader = new FileReader();

    fileReader.onload = function (event) {
        var image1 = document.createElement("img");
        image1.src = event.target.result;
        imageContainer1.appendChild(image1);

        var image2 = document.createElement("img");
        image2.src = event.target.result;
        imageContainer2.appendChild(image2);
    };

    fileReader.readAsDataURL(file);
});

function goToPage(pageId) {
    var pages = document.getElementsByClassName("page");
    for (var i = 0; i < pages.length; i++) {
        pages[i].classList.remove("active");
    }

    document.getElementById(pageId).classList.add("active");
}

function displayResult() {
    var nameInput = document.getElementById("nameInput").value;
    var descriptionInput = document.getElementById("paragraphInput").value;
    var cookingTimeInput = document.getElementById("numberInput").value;
    var servingsInput = document.getElementById("servingInput").value;

    var resultContainer = document.getElementById("resultContainer");
    resultContainer.innerHTML = `
            <p><strong>Nama Resep:</strong> ${nameInput}</p>
            <p><strong>Deskripsi Resep:</strong> ${descriptionInput}</p>
            <p><strong>Waktu Memasak:</strong> ${cookingTimeInput} menit</p>
            <p><strong>Jumlah Porsi:</strong> ${servingsInput}</p>
        `;
}

function tampilkanBahan() {
    var ingredientsInput = document.getElementById("ingredientsInput").value;
    var bahanList = document.getElementById("bahanList");

    // Menghapus bahan-bahan sebelumnya
    while (bahanList.firstChild) {
        bahanList.removeChild(bahanList.firstChild);
    }

    // Memisahkan bahan-bahan menjadi array
    var bahanArray = ingredientsInput.split("\n");

    // Menambahkan bahan-bahan ke dalam daftar
    bahanArray.forEach(function (bahan) {
        var bahanItem = document.createElement("li");
        bahanItem.textContent = bahan;
        bahanList.appendChild(bahanItem);
    });
}

function tampilkanLangkah() {
    var stepsInput = document.getElementById("stepsInput").value;
    var langkahList = document.getElementById("langkahList");

    // Menghapus langkah-langkah sebelumnya
    while (langkahList.firstChild) {
        langkahList.removeChild(langkahList.firstChild);
    }

    // Memisahkan langkah-langkah menjadi array
    var langkahArray = stepsInput.split("\n");

    // Menambahkan langkah-langkah ke dalam daftar
    langkahArray.forEach(function (langkah) {
        var langkahItem = document.createElement("li");
        langkahItem.textContent = langkah;
        langkahList.appendChild(langkahItem);
    });
}

function tampilkanVideo() {
    var linkInput = document.getElementById("linkInput").value;
    var videoContainer = document.getElementById("videoContainer");
    var videoId = getYoutubeVideoId(linkInput);

    if (videoId) {
        videoContainer.innerHTML =
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/' +
            videoId +
            '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
            '<img src="https://img.youtube.com/vi/' +
            videoId +
            '/maxresdefault.jpg" alt="Video Preview" width="560" height="315" />';
    } else {
        videoContainer.innerHTML = "Link Video YouTube tidak valid";
    }
}

function getYoutubeVideoId(url) {
    var regExp =
        /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|\?v=)([^#&?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length === 11) {
        return match[2];
    } else {
        return null;
    }
}
