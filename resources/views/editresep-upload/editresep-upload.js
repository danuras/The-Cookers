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

document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();

    var fileInput = document.getElementById("photoInput");
    var files = fileInput.files;

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = document.createElement("img");
            img.src = e.target.result;

            var gallery = document.getElementById("photoGallery");
            gallery.appendChild(img);
        };

        reader.readAsDataURL(file);
    }

    fileInput.value = "";
});

function goToPage(pageId) {
    var pages = document.getElementsByClassName("page");
    for (var i = 0; i < pages.length; i++) {
        pages[i].classList.remove("active");
    }

    document.getElementById(pageId).classList.add("active");
}

function displayResult() {
    var name = document.getElementById("nameInput").value;
    var email = document.getElementById("emailInput").value;

    var resultContainer = document.getElementById("resultContainer");
    resultContainer.innerHTML =
        "<p>Nama: " + name + "</p><p>Email: " + email + "</p>";
}

function displayResult() {
    var number = document.getElementById("numberInput").value;
    var link = document.getElementById("linkInput").value;

    var resultContainer = document.getElementById("resultContainer");
    resultContainer.innerHTML =
        "<p>Angka: " +
        number +
        "</p><p>Tautan: <a href='" +
        link +
        "'>" +
        link +
        "</a></p>";
}

function displayResult() {
    var paragraph = document.getElementById("paragraphInput").value;

    var resultContainer = document.getElementById("resultContainer");
    resultContainer.innerHTML = "<p>" + paragraph + "</p>";
}
