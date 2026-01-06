@php
    $img = $post->thumbnail_url ? asset($post->thumbnail_url) : asset('assets/images/blog/placeholder.jpg');
@endphp

<a class="post-card" href="{{ route('blog.show', $post->slug) }}">
    <div class="post-thumb">
        <img src="{{ $img }}" alt="{{ $post->title }}" loading="lazy">
    </div>

    <div class="post-body">
        <div class="post-meta">
            <span class="post-type">{{ strtoupper($post->type) }}</span>
            <span class="post-dot">•</span>
            <span class="post-date">{{ optional($post->published_at)->format('d M Y') }}</span>
        </div>

        <h4 class="post-title">{{ $post->title }}</h4>

        @if (!empty($post->excerpt))
            <p class="post-excerpt">{{ $post->excerpt }}</p>
        @endif
    </div>

    <style>
        .post-card {
            display: block;
            text-decoration: none;
            color: inherit;

            border-radius: 16px;
            border: 1px solid rgba(2, 6, 23, 0.08);
            background: #fff;
            overflow: hidden;
            box-shadow: 0 10px 22px rgba(2, 6, 23, 0.06);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(2, 6, 23, 0.10);
            border-color: rgba(11, 42, 85, 0.16);
        }

        .post-thumb img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            background: #f1f5f9;
        }

        .post-body {
            padding: 14px 14px 16px;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
        }

        .post-type {
            color: rgba(11, 42, 85, 0.92);
        }

        .post-dot {
            opacity: .5;
        }

        .post-title {
            margin: 8px 0 8px;
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.2px;
            line-height: 1.35;
        }

        .post-excerpt {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
            color: #475569;
        }
    </style>
</a>
