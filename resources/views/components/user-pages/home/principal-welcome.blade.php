<section class="principal-welcome">
    <div class="container">

        <div class="welcome-wrapper">

            {{-- Foto + Shape background --}}
            <div class="principal-image-container">
                <div class="principal-image-bg"></div>
                @if ($principal?->photo_url)
                    <img src="{{ $principal->photo_url }}" alt="{{ $principal->name }}" class="principal-image" />
                @else
                    <img src="{{ asset('assets/images/principal.jpg') }}" alt="Kepala Sekolah" class="principal-image" />
                @endif
            </div>

            {{-- Konten --}}
            <div class="welcome-content">

                <div class="principal-identity">
                    <h3 class="principal-name">
                        {{ $principal->name ?? 'Nama Kepala Sekolah' }}
                    </h3>

                    <div class="principal-meta">
                        <span class="principal-position">
                            {{ $principal->position ?? 'Kepala Sekolah' }}
                        </span>

                        <span class="principal-school">
                            {{ $schoolProfile->school_name ?? 'SMK' }}
                        </span>
                    </div>
                </div>

                {{-- Quote --}}
                <div class="quote-card">
                    <span class="quote-mark" aria-hidden="true">“</span>

                    <p class="welcome-message">
                        {{ $principal->welcome_message ?? 'Sambutan kepala sekolah akan ditampilkan di sini.' }}
                    </p>

                    <span class="quote-mark quote-mark--bottom" aria-hidden="true">”</span>
                </div>

            </div>

        </div>

    </div>
</section>
