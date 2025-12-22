// Navbar Toogle Menu (Mobile)
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("navbarToggle");
    const menu = document.getElementById("navbarMenu");

    if (toggle) {
        toggle.addEventListener("click", function () {
            menu.classList.toggle("show");
        });
    }
});
