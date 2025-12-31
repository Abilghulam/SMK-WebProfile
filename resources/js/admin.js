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
