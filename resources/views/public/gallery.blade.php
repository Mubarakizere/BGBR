@extends('layouts.public')

@section('title', 'Gallery — BGBR Rwanda')
@section('meta_description', 'Photo gallery of the Boys\' and Girls\' Brigade Rwanda activities, events, and programs.')

@section('styles')
<style>
    .gallery-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .gallery-filter {
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        border: 2px solid var(--border);
        background: white;
        color: var(--text-light);
        cursor: pointer;
        transition: all 0.2s;
    }

    .gallery-filter.active,
    .gallery-filter:hover {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .gallery-item {
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 4/3;
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
    }

    .gallery-item:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }

    .gallery-item:hover img {
        transform: scale(1.08);
    }

    .gallery-item-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        align-items: flex-end;
        padding: 16px;
    }

    .gallery-item:hover .gallery-item-overlay {
        opacity: 1;
    }

    .gallery-item-overlay span {
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(0,0,0,0.92);
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .lightbox.open {
        display: flex;
    }

    .lightbox img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
    }

    .lightbox-close {
        position: absolute;
        top: 24px;
        right: 24px;
        background: rgba(255,255,255,0.1);
        border: none;
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .lightbox-close:hover {
        background: rgba(255,255,255,0.2);
    }

    .lightbox-caption {
        position: absolute;
        bottom: 32px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        background: rgba(0,0,0,0.5);
        padding: 10px 24px;
        border-radius: 50px;
    }

    @media (max-width: 768px) {
        .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .gallery-item { border-radius: 10px; }
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Photo Gallery</h1>
        <p>Capturing moments of faith, fellowship, and growth across BGBR Rwanda.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            @if($images->count())
                @if($albums->count())
                <div class="gallery-filters fade-up">
                    <button class="gallery-filter active" onclick="filterGallery('all', this)">All Photos</button>
                    @foreach($albums as $album)
                        <button class="gallery-filter" onclick="filterGallery('{{ Str::slug($album) }}', this)">{{ $album }}</button>
                    @endforeach
                </div>
                @endif

                <div class="gallery-grid">
                    @foreach($images as $image)
                    <div class="gallery-item fade-up" data-album="{{ Str::slug($image->album) }}" onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}', '{{ e($image->caption ?? $image->title) }}')">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title ?? $image->caption ?? 'Gallery image' }}" loading="lazy">
                        @if($image->title || $image->caption)
                        <div class="gallery-item-overlay">
                            <span>{{ $image->title ?? $image->caption }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:60px 0;">
                    <div style="width:80px;height:80px;border-radius:20px;background:rgba(30,47,163,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:var(--primary);">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 style="font-weight:700;margin:0 0 8px;">Gallery Coming Soon</h3>
                    <p style="color:var(--text-light);">Photos will be uploaded shortly.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox" onclick="if(event.target===this)closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <img id="lightboxImg" src="" alt="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
@endsection

@section('scripts')
<script>
    function openLightbox(src, caption) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxCaption').textContent = caption || '';
        document.getElementById('lightboxCaption').style.display = caption ? 'block' : 'none';
        document.getElementById('lightbox').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    function filterGallery(album, btn) {
        document.querySelectorAll('.gallery-filter').forEach(f => f.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.gallery-item').forEach(item => {
            if (album === 'all' || item.dataset.album === album) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });
</script>
@endsection
