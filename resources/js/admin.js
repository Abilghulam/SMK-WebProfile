document.addEventListener("DOMContentLoaded", () => {
    initOtpUI();
    initResendOtpUI();
});

// OTP Input
function initOtpUI() {
    const otpForm = document.querySelector("[data-otp-form]");
    if (!otpForm) return;

    const otpWrap = otpForm.querySelector("[data-otp]");
    const hidden = otpForm.querySelector("[data-otp-hidden]");
    if (!otpWrap || !hidden) return;

    const boxes = Array.from(otpWrap.querySelectorAll(".a-otp-box"));
    if (!boxes.length) return;

    const digitsOnly = (v) => String(v || "").replace(/\D/g, "");
    const pad2 = (n) => String(n).padStart(2, "0");

    const syncHidden = () => {
        hidden.value = boxes
            .map((b) => digitsOnly(b.value).slice(0, 1))
            .join("");
    };

    const focusFirstEmpty = () => {
        const i = boxes.findIndex((b) => !digitsOnly(b.value));
        const idx = i === -1 ? boxes.length - 1 : i;
        boxes[idx]?.focus();
    };

    const fillFrom = (str, startIndex = 0) => {
        const digits = digitsOnly(str);
        if (!digits) return;

        let k = 0;
        for (
            let i = startIndex;
            i < boxes.length && k < digits.length;
            i++, k++
        ) {
            boxes[i].value = digits[k];
        }

        syncHidden();
        focusFirstEmpty();
    };

    // Wire events
    boxes.forEach((box, idx) => {
        box.addEventListener("input", () => {
            const raw = digitsOnly(box.value);

            // Mobile autofill/paste: bisa masuk lebih dari 1 digit ke 1 box
            if (raw.length > 1) {
                fillFrom(raw, idx);
                return;
            }

            box.value = raw.slice(0, 1);
            syncHidden();

            if (box.value && idx < boxes.length - 1) boxes[idx + 1].focus();
        });

        box.addEventListener("keydown", (e) => {
            if (e.key !== "Backspace") return;

            if (digitsOnly(box.value)) {
                box.value = "";
                syncHidden();
                return;
            }

            if (idx > 0) {
                boxes[idx - 1].focus();
                boxes[idx - 1].value = "";
                syncHidden();
            }
        });

        box.addEventListener("paste", (e) => {
            const text =
                (e.clipboardData || window.clipboardData).getData("text") || "";
            const digits = digitsOnly(text);
            if (!digits) return;

            e.preventDefault();
            fillFrom(digits, idx);
        });
    });

    otpForm.addEventListener("submit", () => syncHidden());

    // Autofocus
    boxes[0]?.focus();

    // Expiry countdown
    initOtpExpiryCountdown(otpForm);
}

function initOtpExpiryCountdown(otpForm) {
    const expIso = otpForm.getAttribute("data-expires-at") || "";
    const expText = document.querySelector("[data-otp-exp-text]");
    const cdText = document.querySelector("[data-otp-countdown]");
    if (!expIso || !expText || !cdText) return;

    const expDate = new Date(expIso);
    if (Number.isNaN(expDate.getTime())) return;

    const pad2 = (n) => String(n).padStart(2, "0");
    const fmtTime = (d) =>
        `${pad2(d.getHours())}:${pad2(d.getMinutes())}:${pad2(d.getSeconds())}`;

    expText.textContent = fmtTime(expDate);

    const tick = () => {
        const now = new Date();
        const diffMs = expDate.getTime() - now.getTime();

        if (diffMs <= 0) {
            cdText.textContent = "00:00";
            return;
        }

        const totalSec = Math.floor(diffMs / 1000);
        const mm = Math.floor(totalSec / 60);
        const ss = totalSec % 60;

        cdText.textContent = `${pad2(mm)}:${pad2(ss)}`;
        setTimeout(tick, 1000);
    };

    tick();
}

// Resend OTP Cooldown Countdown
function initResendOtpUI() {
    const resendForm = document.querySelector("[data-otp-resend-form]");
    if (!resendForm) return;

    const resendBtn = resendForm.querySelector("[data-resend-btn]");
    const resendCount = resendForm.querySelector("[data-resend-count]");
    if (!resendBtn || !resendCount) return;

    let seconds = parseInt(resendForm.dataset.resendSeconds || "0", 10);
    if (Number.isNaN(seconds)) seconds = 0;

    const render = () => {
        const s = Math.max(seconds, 0);
        resendCount.textContent = String(s);

        const disabled = s > 0;
        resendBtn.disabled = disabled;

        if (disabled) resendBtn.setAttribute("aria-disabled", "true");
        else resendBtn.setAttribute("aria-disabled", "false");
    };

    const tick = () => {
        render();
        if (seconds <= 0) return;
        seconds -= 1;
        setTimeout(tick, 1000);
    };

    tick();
}

// Type Definition
document.addEventListener("DOMContentLoaded", () => {
    const typeSelect = document.querySelector("[data-post-type]");
    if (!typeSelect) return;

    const TYPE_FIELDS = {
        news: [
            "title",
            "slug",
            "excerpt",
            "content",
            "thumbnail",
            "is_published",
            "published_at",
            "is_featured",
        ],
        agenda: [
            "title",
            "slug",
            "excerpt",
            "content",
            "thumbnail",
            "is_published",
            "published_at",
            "is_featured",
            "event_start_at",
            "event_end_at",
            "location",
        ],
        achievement: [
            "title",
            "slug",
            "excerpt",
            "content",
            "thumbnail",
            "is_published",
            "published_at",
            "is_featured",
            "awarded_at",
            "level",
        ],
        event: [
            "title",
            "slug",
            "excerpt",
            "content",
            "thumbnail",
            "is_published",
            "published_at",
            "is_featured",
            "event_start_at",
            "event_end_at",
            "location",
        ],
    };

    const allFieldWrappers = Array.from(
        document.querySelectorAll("[data-field]")
    );

    function setDisabled(wrapper, disabled, clearValue = false) {
        wrapper.classList.toggle("is-disabled", disabled);

        const inputs = wrapper.querySelectorAll("input, select, textarea");
        inputs.forEach((el) => {
            el.disabled = disabled;

            if (disabled && clearValue) {
                if (el.type === "checkbox" || el.type === "radio") {
                    el.checked = false;
                } else {
                    el.value = "";
                }
            }
        });
    }

    function applyTypeRules() {
        const type = typeSelect.value;
        const allowed = new Set(TYPE_FIELDS[type] || []);

        allFieldWrappers.forEach((wrapper) => {
            const fieldName = wrapper.dataset.field;

            const isManaged = Object.values(TYPE_FIELDS).some((arr) =>
                arr.includes(fieldName)
            );
            if (!isManaged) return;

            const isAllowed = allowed.has(fieldName);

            // Hide + disable kalau tidak relevan
            wrapper.classList.toggle("is-hidden", !isAllowed);
            setDisabled(wrapper, !isAllowed, true);
        });
    }

    typeSelect.addEventListener("change", applyTypeRules);
    applyTypeRules();
});

// Auto Slug
document.addEventListener("DOMContentLoaded", () => {
    const titleInput =
        document.querySelector('input[name="title"]') ||
        document.querySelector('textarea[name="title"]');

    const slugInput = document.querySelector('input[name="slug"]');

    if (!titleInput || !slugInput) return;

    let slugTouched = false;

    slugInput.addEventListener("input", () => {
        slugTouched = slugInput.value.trim().length > 0;
    });

    function slugify(text) {
        return text
            .toString()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim()

            .replace(/&/g, " dan ")

            .replace(/[^a-z0-9\s-]/g, "")

            .replace(/\s+/g, "-")

            .replace(/-+/g, "-")

            .replace(/^-|-$/g, "");
    }

    function syncSlugFromTitle() {
        const title = titleInput.value || "";
        const slug = slugify(title);

        if (!slugTouched || slugInput.value.trim() === "") {
            slugInput.value = slug;
        }
    }

    titleInput.addEventListener("input", syncSlugFromTitle);
    titleInput.addEventListener("change", syncSlugFromTitle);

    if (slugInput.value.trim() === "") {
        syncSlugFromTitle();
    }
});

// isPublished
document.addEventListener("DOMContentLoaded", () => {
    const row = document.querySelector("[data-publish-row]");
    if (!row) return;

    const pubAtWrap = row.querySelector("[data-publish-at]");
    const pubAtInput = pubAtWrap?.querySelector('input[name="published_at"]');
    const radios = row.querySelectorAll(
        'input[name="is_published"][type="radio"]'
    );

    function sync() {
        const val = row.querySelector(
            'input[name="is_published"]:checked'
        )?.value;
        const isDraft = val === "0";

        if (!pubAtInput) return;

        pubAtInput.disabled = isDraft;
        pubAtWrap.style.opacity = isDraft ? "0.6" : "1";

        if (isDraft) pubAtInput.value = "";
    }

    radios.forEach((r) => r.addEventListener("change", sync));
    sync();
});

// Flash Otomatis
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-flash]").forEach((flash) => {
        // animate in
        flash.classList.add("is-in");

        const closeBtn = flash.querySelector("[data-flash-close]");
        const ms = parseInt(
            flash.getAttribute("data-flash-autoclose") || "0",
            10
        );

        let timer = null;

        function closeFlash() {
            if (timer) clearTimeout(timer);
            flash.classList.remove("is-in");
            flash.classList.add("is-out");

            const removeDelay = 220;
            window.setTimeout(() => {
                if (flash && flash.parentNode)
                    flash.parentNode.removeChild(flash);
            }, removeDelay);
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", (e) => {
                e.preventDefault();
                closeFlash();
            });
        }

        if (ms > 0) {
            timer = window.setTimeout(closeFlash, ms);

            flash.addEventListener("mouseenter", () => {
                if (timer) clearTimeout(timer);
            });

            flash.addEventListener("mouseleave", () => {
                timer = window.setTimeout(closeFlash, 1200);
            });
        }
    });
});

// Auto Rotation Ikon Publish dan Draft
document.addEventListener("DOMContentLoaded", () => {
    const ICONS = {
        // Published -> tombol menampilkan aksi "Jadikan Draft" (paper + pencil)
        draftAction: `
      <path d="M8 3h8l3 3v13a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M13.4 12.6l4-4a1.7 1.7 0 0 1 2.4 2.4l-4 4-3.2.8.8-3.2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M12.7 13.3l2 2"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    `,

        // Draft -> tombol menampilkan aksi "Publish" (paper + arrow up)
        publishAction: `
      <path d="M8 3h8l3 3v13a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M12 16V9"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
      <path d="M9.5 11.5 12 9l2.5 2.5"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M9 18h6"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    `,
    };

    function setToggleIcon(form) {
        const svg = form.querySelector("[data-toggle-ic]");
        if (!svg) return;

        const published = form.dataset.published === "1";
        // kalau sekarang published, tombol harus menampilkan aksi "Draft"
        svg.innerHTML = published ? ICONS.draftAction : ICONS.publishAction;
    }

    function updateBadge(card, isPublished) {
        const badge = card.querySelector("[data-legal-status-badge]");
        if (!badge) return;

        badge.classList.remove("adm-badge--success", "adm-badge--muted");
        badge.classList.add(
            isPublished ? "adm-badge--success" : "adm-badge--muted"
        );

        badge.textContent = isPublished ? "Published" : "Draft";
        badge.dataset.status = isPublished ? "published" : "draft";

        badge.classList.remove("is-updating");
        // retrigger animation
        void badge.offsetWidth;
        badge.classList.add("is-updating");
    }

    async function patchToggle(form) {
        const btn = form.querySelector("[data-toggle-btn]");
        const url = form.getAttribute("action");
        const token = form.querySelector('input[name="_token"]')?.value;

        // Cari card terdekat (supaya update badge untuk card itu saja)
        const card = form.closest(".adm-legal-card") || document;

        btn?.classList.add("is-loading");

        try {
            const res = await fetch(url, {
                method: "POST", // Laravel spoof PATCH via _method
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token || "",
                    "Content-Type":
                        "application/x-www-form-urlencoded;charset=UTF-8",
                },
                body: new URLSearchParams({ _method: "PATCH" }).toString(),
            });

            if (!res.ok) {
                // fallback: submit biasa
                form.submit();
                return;
            }

            const data = await res.json();
            // data.is_published boolean
            const isPublished = !!data.is_published;

            form.dataset.published = isPublished ? "1" : "0";

            // Update title/aria tombol sesuai aksi berikutnya
            const nextTitle = isPublished ? "Jadikan Draft" : "Publish";
            btn?.setAttribute("title", nextTitle);
            btn?.setAttribute("aria-label", nextTitle);

            setToggleIcon(form);
            updateBadge(card, isPublished);
            updatePublishedAt(card, data.published_at || null, isPublished);
        } catch (e) {
            // fallback
            form.submit();
        } finally {
            btn?.classList.remove("is-loading");
        }
    }

    // init + bind
    document.querySelectorAll(".adm-toggle-publish-form").forEach((form) => {
        setToggleIcon(form);

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            patchToggle(form);
        });
    });

    function formatPublishedAt(isoString) {
        if (!isoString) return "—";

        const d = new Date(isoString);
        if (Number.isNaN(d.getTime())) return "—";

        // Format: "03 Jan 2026 10:15"
        const day = String(d.getDate()).padStart(2, "0");
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const mon = months[d.getMonth()];
        const year = d.getFullYear();

        const hh = String(d.getHours()).padStart(2, "0");
        const mm = String(d.getMinutes()).padStart(2, "0");

        return `${day} ${mon} ${year} ${hh}:${mm}`;
    }

    function updatePublishedAt(card, publishedAtIso, isPublished) {
        const el = card.querySelector("[data-legal-published-at]");
        if (!el) return;
        if (!isPublished) {
            el.textContent = "—";
            return;
        }

        el.textContent = formatPublishedAt(publishedAtIso);

        el.classList.remove("is-updating");
        void el.offsetWidth;
        el.classList.add("is-updating");
    }
});

// Toggle Publish (isPublished)
document.addEventListener("DOMContentLoaded", () => {
    const ICONS = {
        // jika sekarang PUBLISHED => tombol menampilkan aksi "Jadikan Draft" (paper + pencil)
        draftAction: `
      <path d="M8 3h8l3 3v13a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M13.4 12.6l4-4a1.7 1.7 0 0 1 2.4 2.4l-4 4-3.2.8.8-3.2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M12.7 13.3l2 2"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    `,

        // jika sekarang DRAFT => tombol menampilkan aksi "Publish" (paper + arrow up)
        publishAction: `
      <path d="M8 3h8l3 3v13a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
      <path d="M12 16V9"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
      <path d="M9.5 11.5 12 9l2.5 2.5"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M9 18h6"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    `,
    };

    function setToggleIcon(form) {
        const svg = form.querySelector("[data-toggle-ic]");
        if (!svg) return;

        const published = form.dataset.published === "1";
        svg.innerHTML = published ? ICONS.draftAction : ICONS.publishAction;
    }

    function updateBadge(card, isPublished) {
        const badge = card.querySelector("[data-doc-status-badge]");
        if (!badge) return;

        badge.classList.remove("adm-badge--success", "adm-badge--muted");
        badge.classList.add(
            isPublished ? "adm-badge--success" : "adm-badge--muted"
        );
        badge.textContent = isPublished ? "Published" : "Draft";

        badge.classList.remove("is-updating");
        void badge.offsetWidth; // retrigger
        badge.classList.add("is-updating");
    }

    function formatDateTime(isoString) {
        if (!isoString) return "—";
        const d = new Date(isoString);
        if (Number.isNaN(d.getTime())) return "—";

        const day = String(d.getDate()).padStart(2, "0");
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const mon = months[d.getMonth()];
        const year = d.getFullYear();
        const hh = String(d.getHours()).padStart(2, "0");
        const mm = String(d.getMinutes()).padStart(2, "0");
        return `${day} ${mon} ${year} ${hh}:${mm}`;
    }

    function updateUpdatedAt(card, updatedAtIso) {
        const el = card.querySelector("[data-doc-updated-at]");
        if (!el) return;

        el.textContent = formatDateTime(updatedAtIso);

        el.classList.remove("is-updating");
        void el.offsetWidth;
        el.classList.add("is-updating");
    }

    async function patchToggle(form) {
        const btn = form.querySelector("[data-toggle-btn]");
        const url = form.getAttribute("action");
        const token = form.querySelector('input[name="_token"]')?.value;

        // sesuaikan selector card ini dengan wrapper card dokumentasi kamu
        const card = form.closest(".adm-doc-card") || document;

        btn?.classList.add("is-loading");

        try {
            const res = await fetch(url, {
                method: "POST", // spoof PATCH via _method
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token || "",
                    "Content-Type":
                        "application/x-www-form-urlencoded;charset=UTF-8",
                },
                body: new URLSearchParams({ _method: "PATCH" }).toString(),
            });

            if (!res.ok) {
                form.submit();
                return;
            }

            const data = await res.json();
            const isPublished = !!data.is_published;

            form.dataset.published = isPublished ? "1" : "0";

            const nextTitle = isPublished ? "Jadikan Draft" : "Publish";
            btn?.setAttribute("title", nextTitle);
            btn?.setAttribute("aria-label", nextTitle);

            setToggleIcon(form);
            updateBadge(card, isPublished);
            updateUpdatedAt(card, data.updated_at || null);
        } catch (e) {
            form.submit();
        } finally {
            btn?.classList.remove("is-loading");
        }
    }

    // init + bind
    document
        .querySelectorAll(".adm-doc-toggle-publish-form")
        .forEach((form) => {
            setToggleIcon(form);

            form.addEventListener("submit", (e) => {
                e.preventDefault();
                patchToggle(form);
            });
        });
});

// Modal Edit Gallery Items
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector("[data-item-modal]");
    if (!modal) return;

    const form = modal.querySelector("[data-item-form]");
    const captionInput = modal.querySelector("[data-caption-input]");
    const fileInput = modal.querySelector("[data-file-input]");
    const fileText = modal.querySelector("[data-file-text]");
    const previewImg = modal.querySelector("[data-preview-img]");
    const previewFallback = modal.querySelector("[data-preview-fallback]");
    const saveBtn = modal.querySelector("[data-save-btn]");

    let activeItemId = null; // item yang sedang diedit

    // =========================
    // Scroll lock helpers
    // =========================
    function lockScroll() {
        document.documentElement.classList.add("adm-scroll-lock");
        document.body.classList.add("adm-scroll-lock");
    }
    function unlockScroll() {
        document.documentElement.classList.remove("adm-scroll-lock");
        document.body.classList.remove("adm-scroll-lock");
    }

    // =========================
    // Modal helpers
    // =========================
    function setPreviewImage(src) {
        if (src) {
            previewImg.src = src;
            previewImg.hidden = false;
            previewFallback.hidden = true;
        } else {
            previewImg.removeAttribute("src");
            previewImg.hidden = true;
            previewFallback.hidden = false;
        }
    }

    function openModal({ action, caption, src, type, itemId }) {
        activeItemId = itemId || null;

        form.setAttribute("action", action);
        captionInput.value = caption || "";

        // reset file UI
        fileInput.value = "";
        if (fileText) fileText.textContent = "Pilih file";

        // preview
        if (type === "image" && src) setPreviewImage(src);
        else setPreviewImage("");

        modal.hidden = false;
        lockScroll();

        // fokus enak
        setTimeout(() => captionInput.focus(), 0);
    }

    function closeModal() {
        modal.hidden = true;
        activeItemId = null;
        unlockScroll();
    }

    // =========================
    // Bind open buttons
    // =========================
    document.querySelectorAll("[data-item-edit]").forEach((btn) => {
        btn.addEventListener("click", () => {
            openModal({
                action: btn.dataset.action,
                caption: btn.dataset.caption || "",
                src: btn.dataset.src || "",
                type: btn.dataset.type || "image",
                itemId: btn.dataset.itemId || null,
            });
        });
    });

    // close handlers
    modal.querySelectorAll("[data-modal-close]").forEach((el) => {
        el.addEventListener("click", closeModal);
    });

    // close with esc
    document.addEventListener("keydown", (e) => {
        if (!modal.hidden && e.key === "Escape") closeModal();
    });

    // =========================
    // File preview + label
    // =========================
    fileInput.addEventListener("change", () => {
        const file = fileInput.files?.[0];
        if (!file) return;

        if (fileText) fileText.textContent = file.name;

        // preview if image
        if (file.type && file.type.startsWith("image/")) {
            const url = URL.createObjectURL(file);
            setPreviewImage(url);
        }
    });

    // =========================
    // Update UI target in page
    // =========================
    function findActiveItemEl() {
        if (!activeItemId) return null;
        return document.querySelector(
            `[data-doc-item][data-item-id="${activeItemId}"]`
        );
    }

    function updateItemUI(payload) {
        const itemEl = findActiveItemEl();
        if (!itemEl) return;

        // caption text
        const capEl = itemEl.querySelector("[data-item-caption]");
        if (capEl) capEl.textContent = payload.caption || "—";

        // image thumb if available
        if (payload.type === "image" && payload.url) {
            const imgEl = itemEl.querySelector("[data-item-thumb]");
            if (imgEl) {
                imgEl.src = payload.url;

                // alt ikut update biar rapi
                imgEl.alt = payload.caption || imgEl.alt || "";
            }
        }

        // Update dataset tombol edit biar kalau dibuka lagi nilainya sudah baru
        const editBtn = itemEl.querySelector("[data-item-edit]");
        if (editBtn) {
            editBtn.dataset.caption = payload.caption || "";
            if (payload.type === "image" && payload.url) {
                editBtn.dataset.src = payload.url;
                editBtn.dataset.type = "image";
            }
        }
    }

    // =========================
    // Submit via fetch (multipart)
    // =========================
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const url = form.getAttribute("action");
        const token = form.querySelector('input[name="_token"]')?.value;

        const fd = new FormData(form);
        fd.set("_method", "PATCH");

        // UI lock
        saveBtn?.setAttribute("disabled", "disabled");

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token || "",
                },
                body: fd,
            });

            if (!res.ok) {
                // fallback submit biasa kalau server tidak return JSON/validation
                form.submit();
                return;
            }

            const data = await res.json();
            if (!data || !data.ok) {
                form.submit();
                return;
            }

            // Update UI
            updateItemUI(data);

            // Close modal
            closeModal();
        } catch (err) {
            alert("Gagal menyimpan perubahan.");
        } finally {
            saveBtn?.removeAttribute("disabled");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const ICONS = {
        // Active -> action is "Nonaktifkan" (eye-off)
        deactivate: `
                    <path d="M3 12s3.5-7 9-7 9 7 9 7-3.5 7-9 7-9-7-9-7Z"
                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    <path d="M10 10a3 3 0 0 1 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M3 3l18 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                `,
        // Inactive -> action is "Aktifkan" (eye)
        activate: `
                    <path d="M3 12s3.5-7 9-7 9 7 9 7-3.5 7-9 7-9-7-9-7Z"
                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                        stroke="currentColor" stroke-width="1.8" />
                `,
    };

    function setToggleIcon(form) {
        const svg = form.querySelector("[data-toggle-ic]");
        if (!svg) return;

        const active = form.dataset.active === "1";
        // if active, button shows "deactivate"
        svg.innerHTML = active ? ICONS.deactivate : ICONS.activate;
    }

    function updateBadge(card, isActive) {
        const badge = card.querySelector("[data-dep-status-badge]");
        if (!badge) return;

        badge.classList.remove("adm-badge--success", "adm-badge--muted");
        badge.classList.add(
            isActive ? "adm-badge--success" : "adm-badge--muted"
        );
        badge.textContent = isActive ? "Aktif" : "Nonaktif";

        badge.classList.remove("is-updating");
        void badge.offsetWidth;
        badge.classList.add("is-updating");
    }

    function formatUpdatedAt(isoString) {
        if (!isoString) return "—";
        const d = new Date(isoString);
        if (Number.isNaN(d.getTime())) return "—";

        const day = String(d.getDate()).padStart(2, "0");
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const mon = months[d.getMonth()];
        const year = d.getFullYear();
        const hh = String(d.getHours()).padStart(2, "0");
        const mm = String(d.getMinutes()).padStart(2, "0");
        return `${day} ${mon} ${year} ${hh}:${mm}`;
    }

    function updateUpdatedAt(card, isoString) {
        const el = card.querySelector("[data-dep-updated-at]");
        if (!el) return;
        el.textContent = formatUpdatedAt(isoString);

        el.classList.remove("is-updating");
        void el.offsetWidth;
        el.classList.add("is-updating");
    }

    async function patchToggle(form) {
        const btn = form.querySelector("[data-toggle-btn]");
        const url = form.getAttribute("action");
        const token = form.querySelector('input[name="_token"]')?.value;
        const card = form.closest(".adm-dep-card") || document;

        btn?.classList.add("is-loading");

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token || "",
                    "Content-Type":
                        "application/x-www-form-urlencoded;charset=UTF-8",
                },
                body: new URLSearchParams({
                    _method: "PATCH",
                }).toString(),
            });

            if (!res.ok) {
                form.submit();
                return;
            }

            const data = await res.json();
            const isActive = !!data.is_active;

            form.dataset.active = isActive ? "1" : "0";

            const nextTitle = isActive ? "Nonaktifkan" : "Aktifkan";
            btn?.setAttribute("title", nextTitle);
            btn?.setAttribute("aria-label", nextTitle);

            setToggleIcon(form);
            updateBadge(card, isActive);
            updateUpdatedAt(card, data.updated_at || null);
        } catch (e) {
            form.submit();
        } finally {
            btn?.classList.remove("is-loading");
        }
    }

    document.querySelectorAll(".adm-dep-toggle-active-form").forEach((form) => {
        setToggleIcon(form);
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            patchToggle(form);
        });
    });
});

// Facility Ikon
document.addEventListener("DOMContentLoaded", () => {
    const ICONS = {
        // Active -> tombol menampilkan aksi "Nonaktifkan" (eye-off)
        deactivateAction: `
                    <path d="M3 12s3.5-7 9-7 9 7 9 7-3.5 7-9 7-9-7-9-7Z"
                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M9.5 9.5a3.5 3.5 0 0 1 5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M3 3l18 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                `,
        // Inactive -> tombol menampilkan aksi "Aktifkan" (eye)
        activateAction: `
                    <path d="M3 12s3.5-7 9-7 9 7 9 7-3.5 7-9 7-9-7-9-7Z"
                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M12 15a3 3 0 1 0 0-6a3 3 0 0 0 0 6Z"
                        stroke="currentColor" stroke-width="1.8" />
                `,
    };

    function setToggleIcon(form) {
        const svg = form.querySelector("[data-toggle-ic]");
        if (!svg) return;

        const active = form.dataset.active === "1";
        svg.innerHTML = active ? ICONS.deactivateAction : ICONS.activateAction;
    }

    function updateBadge(card, isActive) {
        const badge = card.querySelector("[data-fac-status-badge]");
        if (!badge) return;

        badge.classList.remove("adm-badge--success", "adm-badge--muted");
        badge.classList.add(
            isActive ? "adm-badge--success" : "adm-badge--muted"
        );
        badge.textContent = isActive ? "Aktif" : "Nonaktif";

        badge.classList.remove("is-updating");
        void badge.offsetWidth;
        badge.classList.add("is-updating");
    }

    function formatDate(isoString) {
        if (!isoString) return "—";
        const d = new Date(isoString);
        if (Number.isNaN(d.getTime())) return "—";

        const day = String(d.getDate()).padStart(2, "0");
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const mon = months[d.getMonth()];
        const year = d.getFullYear();
        const hh = String(d.getHours()).padStart(2, "0");
        const mm = String(d.getMinutes()).padStart(2, "0");
        return `${day} ${mon} ${year} ${hh}:${mm}`;
    }

    function updateUpdatedAt(card, iso) {
        const el = card.querySelector("[data-fac-updated-at]");
        if (!el) return;

        el.textContent = formatDate(iso);

        el.classList.remove("is-updating");
        void el.offsetWidth;
        el.classList.add("is-updating");
    }

    async function patchToggle(form) {
        const btn = form.querySelector("[data-toggle-btn]");
        const url = form.getAttribute("action");
        const token = form.querySelector('input[name="_token"]')?.value;

        const card = form.closest(".adm-fac-card") || document;

        btn?.classList.add("is-loading");

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token || "",
                    "Content-Type":
                        "application/x-www-form-urlencoded;charset=UTF-8",
                },
                body: new URLSearchParams({
                    _method: "PATCH",
                }).toString(),
            });

            if (!res.ok) {
                form.submit();
                return;
            }

            const data = await res.json();
            const isActive = !!data.is_active;

            form.dataset.active = isActive ? "1" : "0";

            const nextTitle = isActive ? "Nonaktifkan" : "Aktifkan";
            btn?.setAttribute("title", nextTitle);
            btn?.setAttribute("aria-label", nextTitle);

            setToggleIcon(form);
            updateBadge(card, isActive);
            updateUpdatedAt(card, data.updated_at || null);
        } catch (e) {
            form.submit();
        } finally {
            btn?.classList.remove("is-loading");
        }
    }

    document.querySelectorAll(".adm-fac-toggle-active-form").forEach((form) => {
        setToggleIcon(form);
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            patchToggle(form);
        });
    });
});
