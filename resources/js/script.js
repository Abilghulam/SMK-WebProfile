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

// Lightbox Modal Gallery (Image + Video)
(function () {
    const lb = document.getElementById("lb");
    if (!lb) return;

    const items = window.__GALLERY_ITEMS__ || [];
    if (!Array.isArray(items) || items.length === 0) return;

    const imgEl = document.getElementById("lbImg");
    const capEl = document.getElementById("lbCap");

    const videoWrap = document.getElementById("lbVideo");
    const iframeEl = document.getElementById("lbIframe");

    const btnPrev = lb.querySelector("[data-lb-prev]");
    const btnNext = lb.querySelector("[data-lb-next]");

    let current = 0;

    function lockBody(lock) {
        document.documentElement.classList.toggle("lb-lock", lock);
        document.body.classList.toggle("lb-lock", lock);
    }

    function stopVideo() {
        if (iframeEl) iframeEl.src = "";
        if (videoWrap) videoWrap.hidden = true;
    }

    function showImage(item) {
        stopVideo();
        if (imgEl) {
            imgEl.src = item.src || "";
            imgEl.alt = item.alt || "";
            imgEl.style.display = "";
        }
    }

    function showVideo(item) {
        if (imgEl) {
            imgEl.src = "";
            imgEl.alt = "";
            imgEl.style.display = "none";
        }

        if (videoWrap) videoWrap.hidden = false;

        // autoplay nanti saja: jangan tambahkan autoplay param dulu
        const url = item.video || "";
        if (iframeEl) iframeEl.src = url;
    }

    function setItem(index) {
        current = (index + items.length) % items.length;
        const item = items[current];

        capEl.textContent = item.caption || "";

        if (item.type === "video") showVideo(item);
        else showImage(item);
    }

    function openLightbox(index) {
        setItem(index);
        lb.classList.add("is-open");
        lb.setAttribute("aria-hidden", "false");
        lockBody(true);
    }

    function closeLightbox() {
        lb.classList.remove("is-open");
        lb.setAttribute("aria-hidden", "true");
        lockBody(false);

        // reset media
        if (imgEl) imgEl.src = "";
        stopVideo();
    }

    // Delegation: klik item (foto/video) cukup via data-lb-index
    document.addEventListener("click", function (e) {
        const btn = e.target.closest("[data-lb-index]");
        if (!btn) return;

        // hanya tangkap tombol gallery kamu
        if (
            !btn.classList.contains("doc-photo-btn") &&
            !btn.classList.contains("doc-video-btn")
        )
            return;

        const idx = parseInt(btn.getAttribute("data-lb-index") || "0", 10);
        openLightbox(Number.isFinite(idx) ? idx : 0);
    });

    // Close on backdrop / close button
    lb.addEventListener("click", function (e) {
        if (e.target.hasAttribute("data-lb-close")) {
            closeLightbox();
        }
    });

    // Prev/Next
    btnPrev?.addEventListener("click", function () {
        setItem(current - 1);
    });

    btnNext?.addEventListener("click", function () {
        setItem(current + 1);
    });

    // Keyboard
    document.addEventListener("keydown", function (e) {
        if (!lb.classList.contains("is-open")) return;

        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowLeft") setItem(current - 1);
        if (e.key === "ArrowRight") setItem(current + 1);
    });
})();
