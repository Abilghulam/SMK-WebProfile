@if (session('success'))
    <div class="admin-flash admin-flash--success" role="status" data-flash data-flash-autoclose="5000">
        <span class="admin-flash-ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 22s8-4 8-10V6l-8-3-8 3v6c0 6 8 10 8 10Z" stroke="currentColor" stroke-width="1.8"
                    stroke-linejoin="round" />
                <path d="M9.5 12l1.8 1.8L15.8 9.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
        <div class="admin-flash-body">
            <div class="admin-flash-title">Berhasil</div>
            <div class="admin-flash-text">{{ session('success') }}</div>
        </div>
        <button class="admin-flash-x" type="button" aria-label="Tutup" data-flash-close>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 7l10 10M17 7 7 17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="admin-flash admin-flash--error" role="alert" data-flash data-flash-autoclose="0">
        <span class="admin-flash-ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 9v5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                <path d="M12 17h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                <path d="M10.3 4.5h3.4L21 19a2 2 0 0 1-1.7 3H4.7A2 2 0 0 1 3 19L10.3 4.5Z" stroke="currentColor"
                    stroke-width="1.6" stroke-linejoin="round" />
            </svg>
        </span>
        <div class="admin-flash-body">
            <div class="admin-flash-title">Gagal</div>
            <div class="admin-flash-text">{{ session('error') }}</div>
        </div>
        <button class="admin-flash-x" type="button" aria-label="Tutup" data-flash-close>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 7l10 10M17 7 7 17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="admin-flash admin-flash--error" role="alert" data-flash data-flash-autoclose="0">
        <span class="admin-flash-ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 9v5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                <path d="M12 17h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                <path d="M10.3 4.5h3.4L21 19a2 2 0 0 1-1.7 3H4.7A2 2 0 0 1 3 19L10.3 4.5Z" stroke="currentColor"
                    stroke-width="1.6" stroke-linejoin="round" />
            </svg>
        </span>

        <div class="admin-flash-body">
            <div class="admin-flash-title">Terjadi kesalahan</div>
            <div class="admin-flash-text">Silakan periksa input berikut:</div>
            <ul class="admin-flash-list">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>

        <button class="admin-flash-x" type="button" aria-label="Tutup" data-flash-close>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 7l10 10M17 7 7 17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
        </button>
    </div>
@endif
