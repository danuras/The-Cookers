// // hamburger menu
// const hamburger = document.querySelector(".hamburger");

// hamburger.onclick = function () {
//     const navBar = document.querySelector("nav");

//     navBar.classList.toggle("active");
// };

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

// pop up logout
function logoutConfirmation() {
    Swal.fire({
        title: "keluar?",
        text: "Apakah Anda yakin?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: "#3085d6",
        cancelButtonText: "Batal",
        confirmButtonColor: "#d33",
        confirmButtonText: "Keluar",
        focusCancel: true,
        background: "#ffcf9c",
    }).then((result) => {
        if (result.isConfirmed) {
            var baseUrl = window.location.origin;
            var routeUrl = baseUrl + "/logout";
            document.location.href = routeUrl;
        }
    });
}
