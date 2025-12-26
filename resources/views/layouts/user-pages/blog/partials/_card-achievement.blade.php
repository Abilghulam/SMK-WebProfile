<a class="ach-mini" href="{{ route('blog.show', $post->slug) }}">
    <div class="ach-badge">{{ $post->level ?? 'Prestasi' }}</div>
    <div class="ach-title">{{ $post->title }}</div>
    <div class="ach-date">
        {{ optional($post->awarded_at)->format('d M Y') ?? optional($post->published_at)->format('d M Y') }}</div>

    <style>
        .ach-mini {
            display: block;
            padding: 12px;
            border-radius: 14px;
            text-decoration: none;
            color: inherit;
            border: 1px solid rgba(2, 6, 23, 0.06);
            background: #fbfdff;
            transition: transform .16s ease, border-color .16s ease;
        }

        .ach-mini+.ach-mini {
            margin-top: 10px;
        }

        .ach-mini:hover {
            transform: translateY(-2px);
            border-color: rgba(226, 179, 58, 0.26);
        }

        .ach-badge {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            color: rgba(11, 42, 85, 0.92);
            background: rgba(226, 179, 58, 0.14);
            border: 1px solid rgba(226, 179, 58, 0.26);
        }

        .ach-title {
            margin-top: 10px;
            font-weight: 900;
            font-size: 13px;
            color: #0f172a;
            line-height: 1.35;
        }

        .ach-date {
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
        }
    </style>
</a>
