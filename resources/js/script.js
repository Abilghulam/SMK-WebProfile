// Navbar Toogle Menu (Mobile)
document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".navbar");
    const toggle = document.getElementById("navbarToggle");
    const menu = document.getElementById("navbarMenu");

    // ===== Mobile menu toggle =====
    if (toggle && menu) {
        toggle.addEventListener("click", () => {
            const open = menu.classList.toggle("is-open");
            toggle.setAttribute("aria-expanded", open ? "true" : "false");
        });
    }

    // ===== Dropdown click-only (desktop + mobile) =====
    const triggers = document.querySelectorAll(".nav-dropdown .nav-trigger");

    function closeAllDropdowns(exceptEl = null) {
        document.querySelectorAll(".nav-dropdown").forEach((item) => {
            if (exceptEl && item === exceptEl) return;
            item.classList.remove("is-open");
            const btn = item.querySelector(".nav-trigger");
            if (btn) btn.setAttribute("aria-expanded", "false");
        });
    }

    triggers.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            const parent = btn.closest(".nav-dropdown");
            const isOpen = parent.classList.contains("is-open");

            closeAllDropdowns(parent); // tutup dropdown lain
            parent.classList.toggle("is-open", !isOpen);
            btn.setAttribute("aria-expanded", !isOpen ? "true" : "false");
        });
    });

    // Klik di luar -> tutup dropdown
    document.addEventListener("click", () => closeAllDropdowns());

    // Klik item dropdown -> tutup dropdown + (optional) tutup menu mobile
    document.querySelectorAll(".dropdown-link").forEach((link) => {
        link.addEventListener("click", () => {
            closeAllDropdowns();
            if (menu) menu.classList.remove("is-open");
            if (toggle) toggle.setAttribute("aria-expanded", "false");
        });
    });

    // Esc -> tutup dropdown
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeAllDropdowns();
    });

    // ===== Hide navbar on scroll down, show on scroll up =====
    let lastScrollY = window.scrollY;
    const threshold = 10; // biar tidak kedip-kedip

    window.addEventListener(
        "scroll",
        () => {
            if (!navbar) return;

            const currentY = window.scrollY;
            const delta = currentY - lastScrollY;

            // kalau scroll sedikit banget, abaikan
            if (Math.abs(delta) < threshold) return;

            if (currentY > lastScrollY && currentY > 80) {
                // scroll down
                navbar.classList.add("navbar-hidden");
                // tutup dropdown kalau ada
                closeAllDropdowns();
                if (menu) menu.classList.remove("is-open");
                if (toggle) toggle.setAttribute("aria-expanded", "false");
            } else {
                // scroll up
                navbar.classList.remove("navbar-hidden");
            }

            lastScrollY = currentY;
        },
        { passive: true }
    );
});

// Animasi Count Up (Statistics Section)
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".stat-number");

    counters.forEach((counter) => {
        const target = +counter.getAttribute("data-count");
        let count = 0;
        const speed = 30;

        const updateCount = () => {
            const increment = Math.ceil(target / speed);
            if (count < target) {
                count += increment;
                counter.innerText = count;
                setTimeout(updateCount, 40);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    });
});
