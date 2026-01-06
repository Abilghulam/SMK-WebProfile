document.addEventListener("DOMContentLoaded", () => {
    const toasts = document.querySelectorAll("[data-toast]");
    if (!toasts.length) return;

    const closeToast = (toast) => {
        if (!toast || toast.dataset.closing === "1") return;
        toast.dataset.closing = "1";

        toast.classList.remove("is-in");
        toast.classList.add("is-out");

        const remove = () => toast.remove();
        toast.addEventListener("transitionend", remove, { once: true });

        // fallback kalau transitionend tidak terpanggil
        setTimeout(remove, 250);
    };

    toasts.forEach((toast) => {
        // animate in
        requestAnimationFrame(() => toast.classList.add("is-in"));

        const btn = toast.querySelector("[data-toast-close]");
        btn?.addEventListener("click", () => closeToast(toast));

        // auto-dismiss
        const timeout = parseInt(
            toast.getAttribute("data-timeout") || "4500",
            10
        );
        let timer = setTimeout(() => closeToast(toast), timeout);

        // pause saat hover (UX enak)
        toast.addEventListener("mouseenter", () => clearTimeout(timer));
        toast.addEventListener("mouseleave", () => {
            timer = setTimeout(() => closeToast(toast), 1200);
        });
    });

    // kalau kamu pakai lucide via <i data-lucide="...">
    if (window.lucide && typeof window.lucide.createIcons === "function") {
        window.lucide.createIcons();
    }
});
