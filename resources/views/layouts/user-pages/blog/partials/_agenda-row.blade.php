@php
    $start = $post->event_start_at;
    $end = $post->event_end_at;
    $isUpcoming = ($state ?? 'upcoming') === 'upcoming';
@endphp

<a class="agenda-row {{ $isUpcoming ? 'agenda-row--upcoming' : 'agenda-row--past' }}"
    href="{{ route('blog.show', $post->slug) }}">

    <div class="agenda-datebox">
        <div class="agenda-day">{{ optional($start)->format('d') }}</div>
        <div class="agenda-month">{{ optional($start)->format('M') }}</div>
        <div class="agenda-year">{{ optional($start)->format('Y') }}</div>
    </div>

    <div class="agenda-main">
        <div class="agenda-title">{{ $post->title }}</div>

        <div class="agenda-meta">
            <span class="agenda-time">
                {{ optional($start)->format('H:i') }}
                @if ($end)
                    – {{ optional($end)->format('H:i') }}
                @endif
            </span>

            @if (!empty($post->location))
                <span class="agenda-sep">|</span>
                <span class="agenda-loc">{{ $post->location }}</span>
            @endif
        </div>

        @if (!empty($post->excerpt))
            <p class="agenda-excerpt">{{ $post->excerpt }}</p>
        @endif
    </div>

    <div class="agenda-arrow" aria-hidden="true">→</div>

    {{-- CSS khusus row agenda --}}
    <style>
        .agenda-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;

            padding: 12px;
            border-radius: 16px;

            text-decoration: none;
            color: inherit;

            border: 1px solid rgba(2, 6, 23, 0.07);
            background: #fbfdff;

            transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        }

        .agenda-row+.agenda-row {
            margin-top: 10px;
        }

        .agenda-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(2, 6, 23, 0.08);
            border-color: rgba(226, 179, 58, 0.26);
        }

        .agenda-datebox {
            width: 64px;
            border-radius: 16px;
            padding: 10px 8px;
            flex-shrink: 0;

            background: rgba(11, 42, 85, 0.08);
            border: 1px solid rgba(11, 42, 85, 0.12);

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .agenda-day {
            font-size: 20px;
            font-weight: 950;
            color: #0f172a;
            line-height: 1;
        }

        .agenda-month {
            margin-top: 5px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            color: rgba(11, 42, 85, 0.95);
            text-transform: uppercase;
        }

        .agenda-year {
            margin-top: 4px;
            font-size: 11px;
            font-weight: 800;
            color: rgba(2, 6, 23, 0.55);
        }

        .agenda-main {
            flex: 1;
        }

        .agenda-title {
            font-size: 13px;
            font-weight: 950;
            color: #0f172a;
            line-height: 1.35;
        }

        .agenda-meta {
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 750;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .agenda-sep {
            color: rgba(2, 6, 23, 0.35);
            font-weight: 900;
        }

        .agenda-excerpt {
            margin: 8px 0 0 0;
            font-size: 13px;
            line-height: 1.7;
            color: #475569;
        }

        .agenda-arrow {
            margin-left: 6px;
            font-weight: 900;
            color: rgba(11, 42, 85, 0.85);
            align-self: center;
        }

        /* Past state lebih soft */
        .agenda-row--past {
            opacity: .88;
        }
    </style>

</a>
