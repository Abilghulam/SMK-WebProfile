document.addEventListener("DOMContentLoaded", () => {
    initOtpUI();
    initResendOtpUI();
});

/**
 * OTP input UX + hidden sync + expiry countdown
 */
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

/**
 * Resend OTP cooldown countdown
 */
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

document.addEventListener("DOMContentLoaded", () => {
    const typeSelect = document.querySelector("[data-post-type]");
    if (!typeSelect) return;

    // Definisikan field aktif per type
    // Sesuaikan key type kamu: NEWS, AGENDA, ACHIEVEMENT, EVENT (atau Kegiatan)
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

    // Kalau di DB kamu pakai "Kegiatan" sebagai EVENT, samakan key-nya ya.
    // Misal type di DB = "AGENDA" untuk agenda, "ACHIEVEMENT" untuk prestasi.

    const allFieldWrappers = Array.from(
        document.querySelectorAll("[data-field]")
    );

    function setDisabled(wrapper, disabled, clearValue = false) {
        wrapper.classList.toggle("is-disabled", disabled);

        const inputs = wrapper.querySelectorAll("input, select, textarea");
        inputs.forEach((el) => {
            el.disabled = disabled;

            // Opsional: bersihkan value kalau dimatikan (biar tidak "nyangkut" saat save)
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

            // Field yang tidak kamu atur rules-nya → biarkan saja tampil & aktif
            // Tapi untuk ketat (recommended), kamu bisa masukkan semua field utama di TYPE_FIELDS
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
    applyTypeRules(); // init saat halaman load (create & edit)
});

document.addEventListener("DOMContentLoaded", () => {
    // Cari field judul & slug (aman tanpa ubah class)
    const titleInput =
        document.querySelector('input[name="title"]') ||
        document.querySelector('textarea[name="title"]');

    const slugInput = document.querySelector('input[name="slug"]');

    if (!titleInput || !slugInput) return;

    // Kalau slug sudah ada (edit mode), anggap user mungkin mau mempertahankan.
    // Auto-sync aktif hanya jika slug kosong atau slug belum pernah disentuh manual.
    let slugTouched = false;

    // Tandai kalau user mengedit slug manual
    slugInput.addEventListener("input", () => {
        // Jika user mulai mengetik sesuatu, dianggap "touched"
        // tapi kalau user mengosongkan slug, auto-sync akan aktif lagi
        slugTouched = slugInput.value.trim().length > 0;
    });

    // Fungsi slugify yang rapi untuk bahasa Indonesia juga
    function slugify(text) {
        return (
            text
                .toString()
                .normalize("NFD") // pisah accent
                .replace(/[\u0300-\u036f]/g, "") // hapus accent
                .toLowerCase()
                .trim()
                // ganti & jadi "dan" (opsional, tapi terasa institusional)
                .replace(/&/g, " dan ")
                // hapus karakter aneh
                .replace(/[^a-z0-9\s-]/g, "")
                // spasi jadi dash
                .replace(/\s+/g, "-")
                // rapikan multiple dash
                .replace(/-+/g, "-")
                // hapus dash di awal/akhir
                .replace(/^-|-$/g, "")
        );
    }

    // Sync slug saat judul berubah (hanya jika slug belum disentuh / slug kosong)
    function syncSlugFromTitle() {
        const title = titleInput.value || "";
        const slug = slugify(title);

        // Auto-update hanya jika:
        // - slug belum disentuh user, atau
        // - slug input kosong (user sengaja kosongkan untuk auto)
        if (!slugTouched || slugInput.value.trim() === "") {
            slugInput.value = slug;
        }
    }

    // Event yang enak: input (real-time) + change
    titleInput.addEventListener("input", syncSlugFromTitle);
    titleInput.addEventListener("change", syncSlugFromTitle);

    // Jika form edit dan slug memang kosong, langsung sync dari title saat load
    if (slugInput.value.trim() === "") {
        syncSlugFromTitle();
    }
});

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

            // wait transition then remove
            const removeDelay = 220;
            window.setTimeout(() => {
                if (flash && flash.parentNode)
                    flash.parentNode.removeChild(flash);
            }, removeDelay);
        }

        // manual close
        if (closeBtn) {
            closeBtn.addEventListener("click", (e) => {
                e.preventDefault();
                closeFlash();
            });
        }

        // auto close (0 = disabled)
        if (ms > 0) {
            timer = window.setTimeout(closeFlash, ms);

            // UX: pause timer on hover
            flash.addEventListener("mouseenter", () => {
                if (timer) clearTimeout(timer);
            });

            flash.addEventListener("mouseleave", () => {
                timer = window.setTimeout(closeFlash, 1200);
            });
        }
    });
});
