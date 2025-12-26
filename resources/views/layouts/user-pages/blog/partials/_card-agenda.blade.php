<a class="agenda-mini" href="{{ route('blog.show', $post->slug) }}">
    <div class="agenda-date">
        <div class="d">{{ optional($post->event_start_at)->format('d') }}</div>
        <div class="m">{{ optional($post->event_start_at)->format('M') }}</div>
    </div>

    <div class="agenda-info">
        <div class="agenda-title">{{ $post->title }}</div>
        <div class="agenda-meta">
            {{ optional($post->event_start_at)->format('H:i') }}
            @if ($post->location)
                • {{ $post->location }}
            @endif
        </div>
    </div>

    <style>
        .agenda-mini {
            display: flex;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            text-decoration: none;
            color: inherit;
            border: 1px solid rgba(2, 6, 23, 0.06);
            background: #fbfdff;
            transition: transform .16s ease, border-color .16s ease;
        }

        .agenda-mini+.agenda-mini {
            margin-top: 10px;
        }

        .agenda-mini:hover {
            transform: translateY(-2px);
            border-color: rgba(226, 179, 58, 0.26);
        }

        .agenda-date {
            width: 54px;
            border-radius: 14px;
            background: rgba(11, 42, 85, 0.08);
            border: 1px solid rgba(11, 42, 85, 0.12);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 6px;
            flex-shrink: 0;
        }

        .agenda-date .d {
            font-size: 18px;
            font-weight: 950;
            color: #0f172a;
            line-height: 1;
        }

        .agenda-date .m {
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            color: rgba(11, 42, 85, 0.9);
            margin-top: 4px;
        }

        .agenda-title {
            font-weight: 900;
            font-size: 13px;
            color: #0f172a;
            line-height: 1.35;
        }

        .agenda-meta {
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
        }
    </style>
</a>
