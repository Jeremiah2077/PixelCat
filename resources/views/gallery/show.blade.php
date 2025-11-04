<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <title>{{ $project->title }} - Photo Gallery</title>
    <meta name="color-scheme" content="dark">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pixel: {
                            'dark': '#0a0f14',
                            'slate': '#151b28',
                            'border': '#263246',
                            'accent': '#3b82f6',
                            'emerald': '#10b981',
                        }
                    },
                    boxShadow: {
                        'glass': '0 8px 32px rgba(0,0,0,.4), inset 0 1px rgba(255,255,255,.1)',
                        'glass-lg': '0 16px 48px rgba(0,0,0,.5), inset 0 1px rgba(255,255,255,.12)',
                    }
                }
            }
        }
    </script>

    <!-- Viewer.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --safe-top: env(safe-area-inset-top, 0px);
            --safe-bottom: env(safe-area-inset-bottom, 0px);
        }

        [x-cloak] { display: none !important; }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            position: relative;
            background: #0a0f14;
            overflow-x: hidden;
            min-height: 100vh;
            min-height: 100svh;
        }

        /* Full page dark gradient background + fine texture */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(180deg, rgba(10,15,20,.75) 0%, rgba(15,23,42,.85) 50%, rgba(10,15,20,.9) 100%),
                radial-gradient(1400px circle at 15% 20%, rgba(59,130,246,.08), transparent 60%),
                radial-gradient(1400px circle at 85% 80%, rgba(16,185,129,.06), transparent 60%),
                linear-gradient(135deg, #0f172a 0%, #020617 100%);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: -2;
            transform: translateZ(0);
            will-change: transform;
        }

        /* Fine grain noise */
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(0deg, rgba(255,255,255,.012), rgba(255,255,255,.012) 1px, transparent 2px);
            mix-blend-mode: overlay;
            pointer-events: none;
            z-index: -1;
        }

        /* Glass morphism card */
        .glass {
            background: rgba(21, 27, 40, .55);
            border: 1px solid rgba(255, 255, 255, .08);
            box-shadow: 0 8px 32px rgba(0,0,0,.4), inset 0 1px rgba(255,255,255,.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .glass-strong {
            background: rgba(21, 27, 40, .72);
            border: 1px solid rgba(255, 255, 255, .1);
            box-shadow: 0 16px 48px rgba(0,0,0,.5), inset 0 1px rgba(255,255,255,.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Photo card hover effect */
        .photo-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .photo-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,.6), inset 0 1px rgba(255,255,255,.15);
        }

        .photo-item img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .photo-item:hover img {
            transform: scale(1.08);
        }

        .selection-ring {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading animation */
        .loading {
            background: linear-gradient(90deg, #1f2937 25%, #374151 50%, #1f2937 75%);
            background-size: 200% 100%;
            animation: loading 1.2s ease-in-out infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Button ripple effect */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle, rgba(255,255,255,.15) 0%, transparent 70%);
            transform: scale(0);
            transition: transform 0.5s ease;
        }

        .btn-ripple:hover::before {
            transform: scale(2);
        }

        /* Responsive optimization */
        @media (max-width: 640px) {
            .glass { background: rgba(21, 27, 40, .62); }
            body::before { background-attachment: scroll; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        main { flex: 1; }

        /* Viewer.js dark theme customization */
        .viewer-backdrop {
            background-color: rgba(0, 0, 0, 0.92) !important;
            backdrop-filter: blur(8px);
        }

        .viewer-canvas > img {
            box-shadow: 0 20px 60px rgba(0,0,0,0.6) !important;
        }

        .viewer-title {
            background: rgba(0, 0, 0, 0.75) !important;
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 8px 16px !important;
            color: #e5e7eb !important;
            font-size: 14px !important;
        }

        .viewer-toolbar > ul > li {
            background-color: rgba(30, 41, 59, 0.8) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .viewer-toolbar > ul > li:hover {
            background-color: rgba(59, 130, 246, 0.8) !important;
        }

        .viewer-button {
            background-color: rgba(30, 41, 59, 0.8) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .viewer-button:hover {
            background-color: rgba(239, 68, 68, 0.8) !important;
        }

        .viewer-navbar {
            background-color: rgba(0, 0, 0, 0.75) !important;
            backdrop-filter: blur(10px);
        }

        .viewer-navbar > ul > li {
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .viewer-navbar > ul > li:hover,
        .viewer-navbar > ul > li.active {
            opacity: 1;
        }
    </style>
</head>
<body class="text-gray-100" x-data="gallery()" x-cloak>

    <!-- Hero Header -->
    <header class="sticky top-0 z-40" style="padding-top: var(--safe-top);">
        <div class="glass-strong">
            <div class="container mx-auto px-3 sm:px-4 py-4 sm:py-5">
                <div class="flex items-center justify-between gap-3 sm:gap-4">
                    <!-- Brand & Title -->
                    <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-base sm:text-lg md:text-xl font-bold text-white truncate leading-tight">
                                {{ $project->title }}
                            </h1>
                            <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                                <span class="text-blue-400 font-medium">{{ $project->client_name }}</span>
                                <span class="mx-1.5 text-gray-600">•</span>
                                <span>{{ $project->photos->count() }} Photos</span>
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                        @if($project->allow_download)
                        <a href="{{ route('gallery.download.all', $project->share_token) }}"
                           class="btn-ripple inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white transition shadow-lg shadow-emerald-500/25 text-xs sm:text-sm font-semibold"
                           aria-label="Download All">
                            <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                            <span class="hidden sm:inline">Download All</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Meta Info (expandable) -->
                <div class="mt-4 pt-4 border-t border-white/10">
                    <div class="flex flex-wrap gap-3 text-xs sm:text-sm text-gray-300">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $project->project_date->format('Y/m/d') }}</span>
                        </div>

                        @if($project->location)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $project->location }}</span>
                        </div>
                        @endif
                    </div>

                    @if($project->notes)
                    <p class="mt-3 text-sm text-gray-400 leading-relaxed">{{ $project->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Selection Toolbar (only shown when photos are selected) -->
    <div x-show="selectedPhotos.length > 0"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="sticky top-0 z-30 glass border-b border-white/10"
         style="top: calc(var(--safe-top));">
        <div class="container mx-auto px-3 sm:px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                <!-- Selection info -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-500/20 text-blue-300 rounded-lg font-medium border border-blue-500/30 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Selected <strong x-text="selectedPhotos.length"></strong></span>
                    </div>
                    <button @click="clearSelection()"
                            class="px-3 py-1.5 text-xs sm:text-sm text-gray-400 hover:text-white transition">
                        Clear
                    </button>
                </div>

                <!-- Batch action buttons -->
                @if($project->allow_download)
                <button @click="downloadSelected()"
                        class="btn-ripple px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium flex items-center gap-2 text-sm shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="hidden sm:inline">Download Selected</span>
                    <span class="sm:hidden">Download</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <main class="container mx-auto px-3 sm:px-4 py-6 sm:py-8" style="padding-bottom: calc(2rem + var(--safe-bottom));">
        <!-- Quick toolbar -->
        <div class="flex items-center justify-between mb-6">
            <button @click="selectAll()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Select All
            </button>
        </div>

        @if($project->photos->count() > 0)
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5" id="gallery">
            @foreach($project->photos as $index => $photo)
            <div class="photo-item glass rounded-lg md:rounded-xl overflow-hidden cursor-pointer"
                 role="button"
                 tabindex="0">
                <!-- Image Container -->
                <div class="aspect-square bg-pixel-slate loading relative">
                    <img src="{{ $photo->thumbnail_url }}"
                         data-original="{{ $photo->url }}"
                         alt="{{ $photo->original_name }}"
                         class="gallery-image w-full h-full object-cover cursor-pointer"
                         loading="lazy"
                         sizes="(max-width: 640px) 50vw, (max-width: 1024px) 33vw, 25vw"
                         data-photo-id="{{ $photo->id }}">

                    <!-- Selection Overlay -->
                    <div class="absolute inset-0 pointer-events-none transition-all"
                         :class="selectedPhotos.includes({{ $photo->id }}) ? 'bg-blue-500/25 ring-2 ring-inset ring-blue-400' : ''">
                    </div>

                    <!-- Selection Checkbox -->
                    <div class="absolute top-2 left-2 z-10">
                        <button @click.stop="togglePhoto({{ $photo->id }})"
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg shadow-glass selection-ring flex items-center justify-center"
                                :class="selectedPhotos.includes({{ $photo->id }}) ? 'bg-blue-600 scale-105 border-2 border-blue-300' : 'glass-strong hover:bg-white/10'"
                                aria-label="Select Photo">
                            <svg x-show="selectedPhotos.includes({{ $photo->id }})" class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <svg x-show="!selectedPhotos.includes({{ $photo->id }})" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Download Button -->
                    @if($project->allow_download)
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('gallery.photo.download', [$project->share_token, $photo->id]) }}"
                           onclick="event.stopPropagation()"
                           class="w-7 h-7 sm:w-8 sm:h-8 glass-strong rounded-lg shadow-glass flex items-center justify-center hover:bg-emerald-600 transition"
                           aria-label="Download Photo">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Photo Info -->
                <div class="p-2.5 sm:p-3">
                    <p class="text-xs sm:text-sm font-medium text-blue-300/95 truncate" title="{{ $photo->original_name }}">
                        {{ $photo->original_name }}
                    </p>
                    <div class="flex items-center gap-2 sm:gap-3 mt-1 text-[11px] sm:text-xs text-gray-400">
                        @if($photo->width && $photo->height)
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            {{ $photo->width }} × {{ $photo->height }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            {{ $photo->file_size_formatted }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="glass rounded-xl sm:rounded-2xl p-12 sm:p-16 text-center">
            <div class="inline-block p-6 bg-pixel-slate/60 rounded-full mb-6 border border-white/10">
                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-semibold text-gray-300 mb-2">No Photos</h3>
            <p class="text-sm sm:text-base text-gray-500">This project has no photos yet</p>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-3 sm:px-4 pb-6 sm:pb-8" style="padding-bottom: calc(1.5rem + var(--safe-bottom));">
        <div class="glass rounded-lg sm:rounded-xl px-4 py-3 text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-5 h-5 rounded bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-300">PixelCat</span>
            </div>
            <p class="text-xs sm:text-sm text-gray-500">Professional photography portfolio management and sharing platform</p>
        </div>
    </footer>

    <!-- Viewer.js -->
    <script src="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.js"></script>

    <!-- Alpine.js Gallery Logic -->
    <script>
        // Initialize Viewer.js
        let viewerInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const gallery = document.getElementById('gallery');
            if (gallery) {
                viewerInstance = new Viewer(gallery, {
                    url: 'data-original',
                    title: function(image) {
                        return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
                    },
                    toolbar: {
                        zoomIn: 1,
                        zoomOut: 1,
                        oneToOne: 1,
                        reset: 1,
                        prev: 1,
                        play: {
                            show: 1,
                            size: 'large',
                        },
                        next: 1,
                        rotateLeft: 1,
                        rotateRight: 1,
                        flipHorizontal: 1,
                        flipVertical: 1,
                    },
                    navbar: true,
                    backdrop: true,
                    button: true,
                    keyboard: true,
                    loop: true,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: true,
                    transition: true,
                    fullscreen: true,
                    tooltip: true,
                    loading: true,
                    className: 'viewer-dark',
                    filter: function(image) {
                        // Only display images with gallery-image class
                        return image.classList.contains('gallery-image');
                    },
                    viewed: function() {
                        // Callback after image loads
                    }
                });

                // Store in global
                window.viewerInstance = viewerInstance;
            }
        });

        function gallery() {
            return {
                selectedPhotos: [],
                allPhotoIds: @json($project->photos->pluck('id')),

                togglePhoto(photoId) {
                    const index = this.selectedPhotos.indexOf(photoId);
                    if (index > -1) {
                        this.selectedPhotos.splice(index, 1);
                    } else {
                        this.selectedPhotos.push(photoId);
                    }
                },

                selectAll() {
                    this.selectedPhotos = [...this.allPhotoIds];
                },

                clearSelection() {
                    this.selectedPhotos = [];
                },

                downloadSelected() {
                    if (this.selectedPhotos.length === 0) return;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('gallery.download.selected', $project->share_token) }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    this.selectedPhotos.forEach(photoId => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'photos[]';
                        input.value = photoId;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            }
        }

        // Keyboard shortcuts support (built-in PhotoSwipe)
    </script>
</body>
</html>
