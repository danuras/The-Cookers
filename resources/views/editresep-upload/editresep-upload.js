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
