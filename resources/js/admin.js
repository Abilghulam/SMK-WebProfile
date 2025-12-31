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

/* =========================
   ADMIN POSTS UI (interactive)
   - auto slug from title
   - type-based fields enable/disable
   - draft/published sync
   - featured locks published
   ========================= */

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("[data-posts-form]");
    if (!form) return;

    const typeSelect = form.querySelector("[data-posts-type]");
    const titleInput = form.querySelector("[data-posts-title]");
    const slugView = form.querySelector("[data-posts-slug]");
    const slugHidden = form.querySelector("[data-posts-slug-hidden]");
    const slugToggle = form.querySelector("[data-posts-slug-toggle]");

    const publishedCb = form.querySelector("[data-posts-published]");
    const featuredCb = form.querySelector("[data-posts-featured]");
    const draftCb = form.querySelector("[data-posts-draft]");

    const onlyAgenda = [...form.querySelectorAll('[data-posts-only="agenda"]')];
    const onlyAchievement = [
        ...form.querySelectorAll('[data-posts-only="achievement"]'),
    ];

    // --- utils
    const slugify = (str) => {
        return String(str || "")
            .toLowerCase()
            .trim()
            .replace(/['"]/g, "")
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-")
            .replace(/^-|-$/g, "");
    };

    const setMuted = (el, muted) => {
        if (!el) return;
        el.classList.toggle("is-muted", !!muted);
        const inputs = el.querySelectorAll("input, select, textarea, button");
        inputs.forEach((i) => {
            if (i.hasAttribute("data-keep-enabled")) return;
            // jangan disable hidden (biar tetap submit jika dibutuhkan)
            if (i.type === "hidden") return;
            i.disabled = !!muted;
        });
    };

    const clearFieldValues = (el) => {
        const inputs = el.querySelectorAll("input, textarea, select");
        inputs.forEach((i) => {
            if (i.name === "type") return;
            if (i.type === "checkbox" || i.type === "radio") {
                // jangan reset publish/featured dari sini
                return;
            }
            if (i.tagName === "SELECT") {
                i.selectedIndex = 0;
            } else {
                i.value = "";
            }
        });
    };

    // --- type-based fields
    const applyTypeRules = (type) => {
        const isAgenda = type === "agenda";
        const isAchievement = type === "achievement";

        onlyAgenda.forEach((wrap) => {
            setMuted(wrap, !isAgenda);
            if (!isAgenda) clearFieldValues(wrap);
        });

        onlyAchievement.forEach((wrap) => {
            setMuted(wrap, !isAchievement);
            if (!isAchievement) clearFieldValues(wrap);
        });
    };

    // --- draft/published sync
    const syncDraftPublished = () => {
        if (!publishedCb || !draftCb) return;

        // Draft = kebalikan dari Published
        draftCb.checked = !publishedCb.checked;

        // Kalau featured aktif => harus published
        if (featuredCb && featuredCb.checked) {
            publishedCb.checked = true;
            draftCb.checked = false;
            publishedCb.disabled = true;
        } else {
            publishedCb.disabled = false;
        }
    };

    // --- featured locks published
    if (featuredCb && publishedCb && draftCb) {
        featuredCb.addEventListener("change", () => {
            syncDraftPublished();
        });
    }

    if (publishedCb && draftCb) {
        publishedCb.addEventListener("change", () => {
            syncDraftPublished();
        });

        draftCb.addEventListener("change", () => {
            // draft clicked => toggle published
            publishedCb.checked = !draftCb.checked;
            syncDraftPublished();
        });
    }

    // --- slug lock/unlock + auto generate
    let slugLocked = true;

    const lockSlug = () => {
        slugLocked = true;
        if (slugView) slugView.setAttribute("readonly", "readonly");
    };

    const unlockSlug = () => {
        slugLocked = false;
        if (slugView) slugView.removeAttribute("readonly");
        if (slugView) slugView.focus();
    };

    if (slugToggle && slugView) {
        slugToggle.addEventListener("click", () => {
            slugLocked ? unlockSlug() : lockSlug();
        });
    }

    const setSlug = (value) => {
        const v = value || "";
        if (slugView) slugView.value = v;
        if (slugHidden) slugHidden.value = v;
    };

    // Auto slug from title (only when locked OR slug empty)
    if (titleInput) {
        titleInput.addEventListener("input", () => {
            const current = slugHidden
                ? slugHidden.value
                : slugView
                ? slugView.value
                : "";
            const canAuto = slugLocked || !current;
            if (!canAuto) return;
            setSlug(slugify(titleInput.value));
        });
    }

    // If slug edited manually, keep hidden in sync
    if (slugView) {
        slugView.addEventListener("input", () => {
            if (!slugHidden) return;
            slugHidden.value = slugify(slugView.value);
        });
        slugView.addEventListener("blur", () => {
            setSlug(slugify(slugView.value));
        });
    }

    // type change
    if (typeSelect) {
        typeSelect.addEventListener("change", () => {
            applyTypeRules(typeSelect.value);
        });
    }

    // init
    applyTypeRules(typeSelect ? typeSelect.value : "news");
    syncDraftPublished();
    lockSlug();
});
