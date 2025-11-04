<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PixelCat - Open Source Photography Portfolio Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-gradient {
            position: relative;
            background-image: url('https://images.unsplash.com/photo-1588200618450-3a5b1d3b9aa5?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.7) 0%, rgba(30, 64, 175, 0.6) 50%, rgba(30, 58, 138, 0.7) 100%);
        }

        .hero-gradient > * {
            position: relative;
            z-index: 1;
        }

        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.5);
        }

        .btn-secondary {
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #f3f4f6;
            transform: translateY(-2px);
        }

        .logo-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .github-stars {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-8 h-8 logo-bg rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold gradient-text">PixelCat</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-blue-900 font-medium transition">Features</a>
                    <a href="#tech-stack" class="text-gray-700 hover:text-blue-900 font-medium transition">Tech Stack</a>
                    <a href="#open-source" class="text-gray-700 hover:text-blue-900 font-medium transition">Open Source</a>
                    <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="flex items-center space-x-2 text-gray-700 hover:text-blue-900 font-medium transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                        <span>GitHub</span>
                    </a>
                    <a href="/photographer/login" class="px-5 py-2 btn-primary text-white rounded-full font-medium">
                        Admin Login
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-blue-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden pb-4">
                <a href="#features" class="block py-2 text-gray-700 hover:text-blue-900">Features</a>
                <a href="#tech-stack" class="block py-2 text-gray-700 hover:text-blue-900">Tech Stack</a>
                <a href="#open-source" class="block py-2 text-gray-700 hover:text-blue-900">Open Source</a>
                <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="block py-2 text-gray-700 hover:text-blue-900">GitHub</a>
                <a href="/photographer/login" class="block mt-2 px-5 py-2 btn-primary text-white rounded-full font-medium text-center">Admin Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-32 min-h-screen px-4 sm:px-6 lg:px-8 hero-gradient flex items-center">
        <div class="max-w-7xl mx-auto w-full">
            <div class="text-left max-w-3xl">
                <div class="mb-8">
                    <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="github-stars inline-flex">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
                        </svg>
                        <span>Open Source</span>
                        <span class="px-2 py-0.5 bg-white/20 rounded-full text-xs">Free</span>
                    </a>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight">
                    Professional
                    <br>
                    <span class="text-yellow-300">Photography Platform</span>
                </h1>

                <p class="text-xl md:text-2xl text-white/90 mb-12 leading-relaxed">
                    Elegantly manage and share your photography work with clients through a beautiful online gallery experience
                </p>

                <div class="flex flex-col sm:flex-row gap-4 items-start">
                    <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="px-8 py-4 bg-white text-blue-900 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                        <span>View Source Code</span>
                    </a>
                    <a href="/photographer/login" class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-full font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Get Started</span>
                    </a>
                </div>

                <div class="mt-12 flex items-center space-x-8 text-white/80 text-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>100% Free</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Open Source</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Easy Deploy</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600">Professional tools designed specifically for photographers</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Photo Management</h3>
                    <p class="text-gray-600 leading-relaxed">Bulk upload, edit, sort and manage your portfolio. Supports drag-and-drop sorting, preserves original filenames, and easily organizes your photo library.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Project Sharing</h3>
                    <p class="text-gray-600 leading-relaxed">Generate unique sharing links for each project, allowing clients to view without login. Set download permissions to protect your work.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Beautiful Gallery</h3>
                    <p class="text-gray-600 leading-relaxed">Dark theme design with integrated Viewer.js image viewer. Supports zooming, rotating, slideshow and other professional features.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Batch Download</h3>
                    <p class="text-gray-600 leading-relaxed">Support single, batch selection or full download. Automatically packaged as ZIP files, preserving original filenames for easy client access.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Analytics & Statistics</h3>
                    <p class="text-gray-600 leading-relaxed">Track project views and photo downloads. Record access logs to understand client behavior and optimize portfolio display.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                    <div class="w-14 h-14 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Flexible Configuration</h3>
                    <p class="text-gray-600 leading-relaxed">Modern admin dashboard built on Filament 3. Intuitive operations with powerful customization capabilities.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="tech-stack" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Modern Tech Stack</h2>
                <p class="text-xl text-gray-600">Built with the latest web technologies</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">🐘</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Laravel 11</h3>
                    <p class="text-gray-600 text-sm">Modern PHP Framework</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">⚡</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Filament 3</h3>
                    <p class="text-gray-600 text-sm">Elegant Admin Panel</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">🎨</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Tailwind CSS</h3>
                    <p class="text-gray-600 text-sm">Utility-First CSS</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">🖼️</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Viewer.js</h3>
                    <p class="text-gray-600 text-sm">Professional Image Viewer</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">🔐</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Authentication</h3>
                    <p class="text-gray-600 text-sm">Secure User Management</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">💾</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">MySQL</h3>
                    <p class="text-gray-600 text-sm">Reliable Database Storage</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">🌊</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Alpine.js</h3>
                    <p class="text-gray-600 text-sm">Lightweight Interactivity</p>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Composer</h3>
                    <p class="text-gray-600 text-sm">Dependency Management</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Source Section -->
    <section id="open-source" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-5xl mx-auto text-center">
            <div class="mb-8">
                <svg class="w-20 h-20 mx-auto text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Open Source & Free</h2>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                PixelCat is completely open source under the MIT License.<br>
                You can freely use, modify, and distribute it without any costs.
            </p>

            <div class="bg-gray-50 rounded-2xl p-8 mb-8">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold gradient-text mb-2">MIT License</div>
                        <p class="text-gray-600">Open Source License</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-text mb-2">100%</div>
                        <p class="text-gray-600">Completely Free</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-text mb-2">GitHub</div>
                        <p class="text-gray-600">Code Hosting</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="inline-flex items-center justify-center space-x-2 px-8 py-4 btn-primary text-white rounded-full font-bold text-lg shadow-xl hover:shadow-2xl">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Star on GitHub</span>
                </a>
                <a href="https://github.com/Jeremiah2077/PixelCat/fork" target="_blank" class="inline-flex items-center justify-center space-x-2 px-8 py-4 btn-secondary bg-white text-gray-800 rounded-full font-bold text-lg border-2 border-gray-200 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                    </svg>
                    <span>Fork Project</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 hero-gradient">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-xl text-white/90 mb-10">
                Deploy PixelCat now and begin your professional photography portfolio journey
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://github.com/Jeremiah2077/PixelCat#readme" target="_blank" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white text-blue-900 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>View Documentation</span>
                </a>
                <a href="/photographer/login" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-full font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Admin Login</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 logo-bg rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">PixelCat</span>
                    </div>
                    <p class="text-sm">
                        Open source portfolio platform for professional photographers
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#tech-stack" class="hover:text-white transition">Tech Stack</a></li>
                        <li><a href="#open-source" class="hover:text-white transition">Open Source</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="hover:text-white transition">GitHub</a></li>
                        <li><a href="https://github.com/Jeremiah2077/PixelCat#readme" target="_blank" class="hover:text-white transition">Documentation</a></li>
                        <li><a href="https://github.com/Jeremiah2077/PixelCat/issues" target="_blank" class="hover:text-white transition">Issue Tracker</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Community</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://github.com/Jeremiah2077/PixelCat/discussions" target="_blank" class="hover:text-white transition">Discussions</a></li>
                        <li><a href="https://github.com/Jeremiah2077/PixelCat/blob/main/CONTRIBUTING.md" target="_blank" class="hover:text-white transition">Contributing Guide</a></li>
                        <li><a href="https://github.com/Jeremiah2077/PixelCat/blob/main/LICENSE" target="_blank" class="hover:text-white transition">MIT License</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm">
                    &copy; 2025 PixelCat. Open source project under the MIT License.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="https://github.com/Jeremiah2077/PixelCat" target="_blank" class="hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
