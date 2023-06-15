// script.js

document.addEventListener("DOMContentLoaded", function () {
    const pages = document.querySelectorAll(".page");
    const navLinks = document.querySelectorAll(".container2 nav ul li button");

    navLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            const target = this.getAttribute("href").substring(1);

            pages.forEach(function (page) {
                if (page.getAttribute("id") === target) {
                    page.style.display = "block";
                } else {
                    page.style.display = "none";
                }
            });
        });
    });
});
