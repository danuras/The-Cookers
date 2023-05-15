// Toggle class active

const navbarNav = document.querySelector(".navbar-nav");
// ketika humbeger menu di klik
document.querySelector("#hamburger-menu").onclick = () => {
    navbarNav.classList.toggle("active");
};

// Klik di luar sidebar untuk menghilangkan nav
const hamburger = document.querySelector("#hamburger-menu");

document.addEventListener("click", function (e) {
    if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
});

// ketika humbeger menu di klik
document.querySelector(".logout").onclick = () => {
    navbarNav.classList.toggle("active"),
        confirm("are you sure want to logout?");
};

// Klik di luar sidebar untuk menghilangkan nav
const logout = document.querySelector(".logout");

document.addEventListener("click", function (e) {
    if (!logout.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
});
