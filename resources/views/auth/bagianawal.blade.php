<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Kinerja Dosen | Universitas Malikussaleh</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        dark: '#0b3532',
                        teal: {
                            light: '#5eead4',
                            dark: '#0f766e'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Glide JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
    <!-- Google Translate API -->
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
        :root {
            --primary: #0f766e;
            --secondary: #115e59;
            --accent: #5eead4;
            --dark: #0b3532;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            scroll-behavior: smooth;
            top: 0 !important;
        }

        .heading-font {
            font-family: 'Playfair Display', serif;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
            border-radius: 3px;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .btn-primary {
            background-color: var(--accent);
            color: var(--dark);
            transition: all 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
            box-shadow: 0 4px 15px rgba(94, 234, 212, 0.3);
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(94, 234, 212, 0.4);
        }

        .btn-outline {
            border: 2px solid var(--accent);
            color: var(--accent);
            transition: all 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
            font-weight: 600;
        }

        .btn-outline:hover {
            background-color: var(--accent);
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(94, 234, 212, 0.4);
        }

        .card-feature {
            background: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
            box-shadow: 0 8px 32px rgba(15, 118, 110, 0.1);
            border-radius: 16px;
            overflow: hidden;
        }

        .card-feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(15, 118, 110, 0.2);
        }

        .card-feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            color: white;
            font-size: 32px;
            margin-bottom: 24px;
            box-shadow: 0 10px 20px rgba(15, 118, 110, 0.2);
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(17, 94, 89, 0.95), rgba(11, 53, 50, 0.98)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            background-attachment: fixed;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            bottom: -10px;
            left: 0;
            background: linear-gradient(90deg, var(--accent), transparent);
            border-radius: 2px;
        }
        .glide__slide {
            padding: 20px 0;
        }

        .glide__arrows button {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .glide__arrows button:hover {
            background: var(--accent);
            color: var(--dark);
        }

        .stats-item {
            background: linear-gradient(135deg, rgba(94, 234, 212, 0.1), rgba(20, 184, 166, 0.1));
            border-radius: 16px;
            padding: 30px;
            transition: all 0.4s ease;
        }

        .stats-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.1);
        }

        .tooltip {
            position: relative;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: var(--dark);
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 14px;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(94, 234, 212, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(94, 234, 212, 0); }
            100% { box-shadow: 0 0 0 0 rgba(94, 234, 212, 0); }
        }

        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }

        .mobile-menu.active {
            max-height: 500px;
        }

        .progress-container {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-top: 10px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--primary));
            border-radius: 3px;
            transition: width 0.4s ease;
        }

        .feature-step {
            position: relative;
            padding-left: 60px;
            margin-bottom: 40px;
        }

        .feature-step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(15, 118, 110, 0.3);
        }

        .feature-step:last-child {
            margin-bottom: 0;
        }

        .feature-step:after {
            content: '';
            position: absolute;
            left: 20px;
            top: 40px;
            bottom: -40px;
            width: 2px;
            background: linear-gradient(to bottom, var(--accent), transparent);
        }

        .feature-step:last-child:after {
            display: none;
        }

        .input-field {
            transition: all 0.3s ease;
            border: 1px solid #cbd5e1;
        }

        .input-field:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(94, 234, 212, 0.2);
        }

        /* Custom Message Notification */
        .message-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 350px;
            width: 100%;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.4s ease;
        }

        .message-notification.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .message-content {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            border-left: 5px solid var(--accent);
        }

        .message-content.success {
            border-left-color: #10b981;
        }

        .message-content.error {
            border-left-color: #ef4444;
        }

        .message-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
        }

        .message-icon.success {
            color: #10b981;
        }

        .message-icon.error {
            color: #ef4444;
        }

        .close-message {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            font-size: 18px;
        }

        /* Hero Section Improvements */
        .hero-content {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .hero-image-container {
            position: relative;
            perspective: 1000px;
        }

        .hero-image {
            border-radius: 20px;
            transform-style: preserve-3d;
            transform: rotateY(-5deg) rotateX(2deg);
            box-shadow: 20px 20px 50px rgba(0, 0, 0, 0.3);
            border: 10px solid rgba(255, 255, 255, 0.1);
        }

        /* Form Improvements */
        .form-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 118, 110, 0.1);
            overflow: hidden;
            position: relative;
        }

        .form-container:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
        }

        /* Video Player Improvements */
        .video-container {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
            transition: transform 0.5s ease;
        }

        .video-container:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0);
        }

        /* Loading Spinner */
        .spinner {
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Google Translate Styles */
        #google_translate_element {
            display: inline-block;
            vertical-align: middle;
            margin-left: 15px;
        }

        .goog-te-gadget {
            font-family: 'Poppins', sans-serif !important;
        }

        .goog-te-gadget-simple {
            background-color: transparent !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 20px !important;
            padding: 5px 10px !important;
            font-size: 14px !important;
            color: white !important;
        }

        .goog-te-menu-value {
            color: white !important;
        }

        .goog-te-menu-value span:first-child {
            display: none !important;
        }

        .goog-te-menu-value span:last-child::before {
            content: '\f1ab';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: 5px;
        }

        .goog-te-menu-value span:last-child::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: 5px;
            font-size: 12px;
        }

        .goog-te-gadget-simple .goog-te-menu-value span:nth-child(3) {
            display: none !important;
        }

        /* Skip to content link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: var(--primary);
            color: white;
            padding: 8px;
            z-index: 100;
            transition: top 0.3s;
        }

        .skip-link:focus {
            top: 0;
        }

        /* Language switcher mobile */
        .mobile-language-switcher {
            display: none;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            #google_translate_element {
                display: none;
            }

            .mobile-language-switcher {
                display: block;
            }

            .goog-te-gadget-simple {
                width: 100%;
                text-align: center;
            }
        }

        /* Fix for Google Translate banner */
        .goog-te-banner-frame {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        /* Print styles - hide Google Translate */
        @media print {
            #google_translate_element, .mobile-language-switcher {
                display: none !important;
            }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Skip to content link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Message Notification -->
    <div id="messageNotification" class="message-notification">
        <div class="message-content success">
            <button class="close-message" aria-label="Close message">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-start">
                <div class="mr-4">
                    <i class="fas fa-check-circle message-icon success"></i>
                </div>
                <div>
                    <h4 class="font-bold text-lg text-gray-800 mb-1">Pesan Terkirim!</h4>
                    <p class="text-gray-600" id="notificationMessage">Pertanyaan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-12" src="https://ppimfe.unimal.ac.id/img/unimal_ppim.png" alt="Universitas Malikussaleh Logo">
                    </div>
                    <div class="hidden md:block ml-6">
                        <div class="flex space-x-8">
                            <a href="#" class="nav-link text-primary-800 px-3 py-2 text-sm font-medium">Beranda</a>
                            <a href="#fitur" class="nav-link text-primary-800 px-3 py-2 text-sm font-medium">Fitur</a>
                            <a href="#panduan" class="nav-link text-primary-800 px-3 py-2 text-sm font-medium">Panduan</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex items-center">
                    <div id="google_translate_element"></div>
                    <a href="/login" class="btn-primary inline-flex items-center px-6 py-3 rounded-full font-bold shadow-lg ml-4">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk Sistem
                    </a>
                </div>
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-primary-800 hover:text-primary-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu md:hidden bg-white w-full">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-primary-800 hover:bg-primary-50">Beranda</a>
                <a href="#fitur" class="block px-3 py-3 rounded-md text-base font-medium text-primary-800 hover:bg-primary-50">Fitur</a>
                <a href="#panduan" class="block px-3 py-3 rounded-md text-base font-medium text-primary-800 hover:bg-primary-50">Panduan</a>
                <div class="mobile-language-switcher">
                    <div id="google_translate_element_mobile"></div>
                </div>
                <a href="/login" class="btn-primary block text-center px-3 py-3 rounded-md text-base font-bold mt-2">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk Sistem
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">
        <!-- Hero Section -->
        <section class="hero-section pt-32 pb-20 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                        <div class="hero-content">
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 heading-font text-white">
                                <span class="text-primary-300">Sistem </span>Monitoring <span class="text-primary-300">Kinerja</span> Dosen
                            </h1>
                            <p class="text-xl text-primary-200 mb-8 leading-relaxed">
                                Sistem terintegrasi untuk memantau dan mengevaluasi kinerja dosen Fakultas Ekonomi <br>
                                <span class="font-semibold text-primary-300">Universitas Malikussaleh</span>
                            </p>
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                <a href="/login" class="btn-primary inline-flex items-center justify-center px-8 py-4 rounded-full font-bold shadow-lg transform transition hover:scale-105">
                                    <i class="fas fa-sign-in-alt mr-3"></i> Masuk Sistem
                                </a>
                                <a href="#demo" class="btn-outline inline-flex items-center justify-center px-8 py-4 rounded-full font-bold border-2 hover:border-transparent">
                                    <i class="fas fa-play-circle mr-3"></i> Lihat Demo
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2" data-aos="fade-left">
                        <div class="hero-video-wrapper relative">
                            <!-- Video Container -->
                            <div class="hero-video-container rounded-xl overflow-hidden shadow-2xl">
                                <video autoplay muted loop playsinline class="w-full h-full object-cover">
                                    <source src="https://ppimfe.unimal.ac.id/img/intro.mp4" type="video/mp4">
                                </video>
                            </div>

                            <!-- Tombol Unmute (Selalu di atas) -->
                            <button id="unmuteBtn" class="unmute-button">
                                <i class="fas fa-volume-mute"></i>
                                <span class="unmute-tooltip">Nyalakan Suara</span>
                            </button>
                        </div>
                    </div>

                    <style>
                        /* Container Utama */
                        .hero-video-wrapper {
                            perspective: 1000px;
                            transform-style: preserve-3d;
                        }

                        /* Video Container */
                        .hero-video-container {
                            position: relative;
                            width: 100%;
                            aspect-ratio: 16/9;
                            transform: rotateY(-5deg) rotateX(2deg);
                            transition: transform 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
                            border: 8px solid rgba(255, 255, 255, 0.1);
                        }

                        .hero-video-wrapper:hover .hero-video-container {
                            transform: rotateY(0) rotateX(0);
                        }

                        /* Tombol Unmute */
                        .unmute-button {
                            position: absolute;
                            bottom: 10px;
                            right: -60px;
                            width: 44px;
                            height: 44px;
                            background: rgba(255, 255, 255, 0.95);
                            color: #0f766e;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 1000; /* Pastikan selalu di atas */
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                            border: none;
                            cursor: pointer;
                            transition: all 0.3s ease;
                        }

                        .unmute-button:hover {
                            background: white;
                            transform: scale(1.1);
                            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
                        }

                        .unmute-button i {
                            font-size: 18px;
                        }

                        /* Tooltip */
                        .unmute-tooltip {
                            position: absolute;
                            right: 50px;
                            white-space: nowrap;
                            background: rgba(0, 0, 0, 0.8);
                            color: white;
                            padding: 6px 12px;
                            border-radius: 4px;
                            font-size: 13px;
                            opacity: 0;
                            transition: opacity 0.3s;
                            pointer-events: none;
                        }

                        .unmute-button:hover .unmute-tooltip {
                            opacity: 1;
                        }

                        /* Responsive */
                        @media (max-width: 768px) {
                            .hero-video-container {
                                transform: none;
                                border-width: 4px;
                            }

                            .unmute-button {
                                width: 40px;
                                height: 40px;
                                bottom: -49px;
                                right: 38px;
                            }
                        }
                    </style>

                    <script>
                        const video = document.querySelector('.hero-video-container video');
                        const unmuteBtn = document.getElementById('unmuteBtn');

                        // Toggle mute/unmute
                        unmuteBtn.addEventListener('click', () => {
                            video.muted = !video.muted;
                            const icon = video.muted ? 'fa-volume-mute' : 'fa-volume-up';
                            const tooltip = video.muted ? 'Nyalakan Suara' : 'Matikan Suara';

                            unmuteBtn.innerHTML = `<i class="fas ${icon}"></i><span class="unmute-tooltip">${tooltip}</span>`;

                            if (video.paused) video.play();
                        });

                        // Coba unmute setelah interaksi pertama
                        document.addEventListener('click', () => {
                            if (video.muted) {
                                video.muted = false;
                                unmuteBtn.innerHTML = '<i class="fas fa-volume-up"></i><span class="unmute-tooltip">Matikan Suara</span>';
                            }
                        }, { once: true });
                    </script>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0 60L60 53.3C120 47 240 33 360 42.7C480 53 600 87 720 90.7C840 95 960 69 1080 60C1200 53 1320 65 1380 71.3L1440 77.3V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V60Z" fill="#F8FAFC"/>
                </svg>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="stats-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-4xl font-bold text-primary-700 mb-2">{{ $dosenCount ?? 0 }}</div>
                        <div class="text-primary-600">Dosen Aktif</div>
                    </div>

                    <div class="stats-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-4xl font-bold text-primary-700 mb-2">24/7</div>
                        <div class="text-primary-600">Dukungan Sistem</div>
                    </div>
                    <div class="stats-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-4xl font-bold text-primary-700 mb-2">3+</div>
                        <div class="text-primary-600">Fitur Unggulan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl font-bold mb-4 heading-font text-primary-800 section-title">Fitur Unggulan Sistem</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai fitur canggih yang akan membantu memonitor dan meningkatkan kinerja dosen secara efektif</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                    <div class="card-feature p-8" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-feature-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-primary-800">Dashboard Interaktif</h3>
                        <p class="text-gray-600 mb-4">Visualisasi data kinerja dosen secara real-time dengan grafik dan diagram yang mudah dipahami.</p>
                        <div class="tooltip inline-block">
                            <span class="text-primary-600 font-medium cursor-pointer">Lihat Detail <i class="fas fa-chevron-right ml-1"></i></span>
                            <span class="tooltip-text">Dashboard dengan berbagai widget yang dapat disesuaikan sesuai kebutuhan</span>
                        </div>
                    </div>

                    <div class="card-feature p-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-feature-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-primary-800">Penilaian Komprehensif</h3>
                        <p class="text-gray-600 mb-4">Sistem penilaian multi-aspek mencakup Tri Dharma Perguruan Tinggi secara menyeluruh.</p>
                        <div class="tooltip inline-block">
                            <span class="text-primary-600 font-medium cursor-pointer">Lihat Detail <i class="fas fa-chevron-right ml-1"></i></span>
                            <span class="tooltip-text">Penilaian meliputi pengajaran, penelitian, pengabdian, dan unsur penunjang</span>
                        </div>
                    </div>

                    <div class="card-feature p-8" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-feature-icon">
                            <i class="fas fa-file-export"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-primary-800">Laporan Otomatis</h3>
                        <p class="text-gray-600 mb-4">Generate laporan periodik secara otomatis dalam berbagai format file yang siap unduh.</p>
                        <div class="tooltip inline-block">
                            <span class="text-primary-600 font-medium cursor-pointer">Lihat Detail <i class="fas fa-chevron-right ml-1"></i></span>
                            <span class="tooltip-text">Format laporan: PDF, Excel, Word, dan CSV dengan template profesional</span>
                        </div>
                    </div>

                    <div class="card-feature p-8" data-aos="fade-up" data-aos-delay="600">
                        <div class="card-feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-primary-800">Keamanan Data</h3>
                        <p class="text-gray-600 mb-4">Sistem dengan enkripsi tingkat tinggi untuk melindungi data sensitif pengguna.</p>
                        <div class="tooltip inline-block">
                            <span class="text-primary-600 font-medium cursor-pointer">Lihat Detail <i class="fas fa-chevron-right ml-1"></i></span>
                            <span class="tooltip-text">Menggunakan teknologi enkripsi AES-256 dan sistem autentikasi dua faktor</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Demo Section -->
        <section id="demo" class="py-20 bg-gradient-to-r from-primary-700 to-primary-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                        <h2 class="text-3xl font-bold mb-6 heading-font">Lihat Sistem <span class="text-primary-300">Dalam Aksi</span></h2>
                        <p class="text-primary-200 mb-8 leading-relaxed">Tonton demo singkat untuk melihat bagaimana sistem ini dapat membantu meningkatkan kinerja dan produktivitas dosen.</p>

                        <a href="/login" class="btn-primary inline-flex items-center justify-center px-8 py-2 rounded-full font-bold shadow-lg mt-8 transform transition hover:scale-105">
                            <i class="fas fa-rocket mr-3"></i> Coba Sekarang
                        </a>
                    </div>
                    <div class="md:w-1/2 mx-5" data-aos="fade-left">
                        <div class="video-container">
                            <div class="aspect-w-16 aspect-h-9">
                                <video class="w-full h-full object-cover">
                                    <!-- Ganti dengan sumber video Anda -->
                                    <source src="https://bhimbvfirtmnovvtcjxo.supabase.co/storage/v1/object/public/smkd/videos/demo_20250813_224750s.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <button id="videoControl" class="pulse w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-xl transform transition hover:scale-110">
                                    <i class="fas fa-play text-2xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Panduan Section -->
        <section id="panduan" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl font-bold mb-4 heading-font text-primary-800 section-title">Panduan Penggunaan</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Pelajari cara menggunakan sistem kami dengan panduan langkah demi langkah yang mudah diikuti</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <div class="feature-step">
                            <div class="feature-step-number">1</div>
                            <h3 class="text-xl font-bold mb-2 text-primary-800">Login ke Sistem</h3>
                            <p class="text-gray-600">Gunakan akun yang telah diberikan admin untuk mengakses sistem. Jika lupa password, Anda dapat menggunakan fitur reset password.</p>
                        </div>

                        <div class="feature-step">
                            <div class="feature-step-number">2</div>
                            <h3 class="text-xl font-bold mb-2 text-primary-800">Eksplorasi Dashboard</h3>
                            <p class="text-gray-600">Setelah login, Anda akan diarahkan ke dashboard yang menampilkan ringkasan kinerja dan notifikasi penting.</p>
                        </div>

                        <div class="feature-step">
                            <div class="feature-step-number">3</div>
                            <h3 class="text-xl font-bold mb-2 text-primary-800">Input Data Kinerja</h3>
                            <p class="text-gray-600">Masukkan data kinerja sesuai dengan periode yang ditentukan. Pastikan data yang dimasukkan valid dan dapat dipertanggungjawabkan.</p>
                        </div>

                        <div class="feature-step">
                            <div class="feature-step-number">4</div>
                            <h3 class="text-xl font-bold mb-2 text-primary-800">Pantau Perkembangan</h3>
                            <p class="text-gray-600">Gunakan fitur monitoring untuk melihat perkembangan kinerja Anda dari waktu ke waktu.</p>
                        </div>
                    </div>

                    <div data-aos="fade-left">
                        <div class="form-container p-8">
                            <h3 class="text-xl font-bold mb-6 text-primary-800">Butuh Bantuan?</h3>
                            <form id="helpForm">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2" for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" required class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2" for="email">Email</label>
                                    <input type="email" id="email" name="email" required class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2" for="question">Pertanyaan Anda</label>
                                    <textarea id="question" name="question" rows="4" required class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                                </div>
                                <button type="submit" class="btn-primary w-full py-3 rounded-lg font-bold flex items-center justify-center">
                                    <span id="submitText">Kirim Pertanyaan</span>
                                    <span id="submitSpinner" class="spinner hidden"></span>
                                </button>
                                <div id="formMessage" class="mt-4 hidden"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <img src="https://ppimfe.unimal.ac.id/img/unimal_ppim.png" alt="Universitas Malikussaleh Logo" class="h-16 mb-4">
                    <p class="text-white-300 mb-4">
                        Sistem Monitoring Kinerja Dosen<br>
                        Fakultas Ekonomi - Program Studi Ilmu Manajemen
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://web.facebook.com/portal.unimal/?_rdc=1&_rdr#" class="text-white hover:text-orange-400 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/univ.malikussaleh/?hl=id" class="text-white hover:text-orange-400 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@UnimalTV" class="text-white hover:text-orange-400 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.linkedin.com/school/universitas-malikussaleh/" class="text-white hover:text-orange-400 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-white hover:text-orange-400 transition">Beranda</a></li>
                        <li><a href="#fitur" class="text-white hover:text-orange-400 transition">Fitur</a></li>
                        <li><a href="#panduan" class="text-white hover:text-orange-400 transition">Panduan</a></li>
                        <li><a href="/login" class="text-white hover:text-orange-400 transition">Masuk Sistem</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-orange-400"></i>
                            <span>Jl. Cot Tgk Nie, Reuleut, Kec. Muara Batu, Kabupaten Aceh Utara, Aceh 24355</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-orange-400"></i>
                            <span>(0645) 41386</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-orange-400"></i>
                            <span>info@unimal.ac.id</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xl font-bold mb-4 text-white relative">
                        <span class="absolute bottom-0 left-0 w-10 h-1 bg-accent"></span>
                        Fakultas Ekonomi
                    </h4>
                    <ul class="space-y-3">
                        <li class="text-white flex items-start">
                            <i class="fas fa-university mt-1 mr-3 text-orange-400"></i>
                            <span>Program Studi Ilmu Manajemen</span>
                        </li>
                        <li class="text-white flex items-center">
                            <i class="fas fa-star mr-3 text-orange-400"></i>
                            <span>Akreditasi: B</span>
                        </li>
                        <li class="text-white flex items-start">
                            <i class="fas fa-user-tie mt-1 mr-3 text-orange-400"></i>
                            <span>Ketua Program Studi: Dr. John Doe, M.M.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-primary-700 pt-8 text-center text-white-700">
               <p>&copy; Copyright <strong>SMKD PMIMFE</strong> 2025 - {{ now()->year }}.  </p>
               <p>All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-teal-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-primary-500">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Translate Script -->
    <script>
        function googleTranslateElementInit() {
            // Desktop version
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,es,fr,de,ja,zh-CN,ar,ru,pt,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false,
                multilanguagePage: true
            }, 'google_translate_element');

            // Mobile version
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,es,fr,de,ja,zh-CN,ar,ru,pt,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false,
                multilanguagePage: true
            }, 'google_translate_element_mobile');

            // Remove Google branding
            var googleBranding = document.querySelector('.goog-logo-link');
            if (googleBranding) {
                googleBranding.style.display = 'none';
            }

            // Remove powered by text
            var googleText = document.querySelector('.goog-te-gadget');
            if (googleText) {
                var poweredBy = googleText.querySelector('span');
                if (poweredBy) {
                    poweredBy.style.display = 'none';
                }
            }
        }

        // Function to change language programmatically
        function changeLanguage(lang) {
            var select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event('change'));
            }
        }

        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Mobile menu toggle
        $('.mobile-menu-button').click(function() {
            $('.mobile-menu').toggleClass('active');
            $(this).find('i').toggleClass('fa-bars fa-times');
        });

        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#backToTop').removeClass('opacity-0 invisible').addClass('opacity-100 visible');
            } else {
                $('#backToTop').removeClass('opacity-100 visible').addClass('opacity-0 invisible');
            }
        });

        $('#backToTop').click(function() {
            $('html, body').animate({scrollTop: 0}, 'smooth');
            return false;
        });

        // Smooth scrolling for anchor links
        $('a[href*="#"]').on('click', function(e) {
            e.preventDefault();

            $('html, body').animate(
                {
                    scrollTop: $($(this).attr('href')).offset().top - 80,
                },
                500,
                'linear'
            );

            // Close mobile menu if open
            $('.mobile-menu').removeClass('active');
            $('.mobile-menu-button').find('i').removeClass('fa-times').addClass('fa-bars');
        });

        // Tooltip initialization
        $(document).ready(function() {
            $('.tooltip').hover(function() {
                $(this).find('.tooltip-text').fadeIn(200);
            }, function() {
                $(this).find('.tooltip-text').fadeOut(200);
            });
        });

        // Video Player Control
        document.addEventListener('DOMContentLoaded', function() {
            const videoControl = document.getElementById('videoControl');
            const video = document.querySelector('video');
            const playIcon = videoControl.querySelector('i');

            // Set video to display first frame
            video.addEventListener('loadedmetadata', function() {
                video.currentTime = 0.1; // Ambil frame awal
            });

            videoControl.addEventListener('click', function() {
                if (video.paused) {
                    video.play();
                    playIcon.classList.remove('fa-play');
                    playIcon.classList.add('fa-pause');
                } else {
                    video.pause();
                    playIcon.classList.remove('fa-pause');
                    playIcon.classList.add('fa-play');
                }
            });

            video.addEventListener('play', function() {
                videoControl.classList.add('opacity-0', 'pointer-events-none');
            });

            video.addEventListener('pause', function() {
                videoControl.classList.remove('opacity-0', 'pointer-events-none');
            });
        });

        // Script untuk form bantuan
        document.getElementById('helpForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            // Tambahkan email tujuan dan subject ke formData
            formData.append('_to', 'fm230602@gmail.com');
            formData.append('_subject', 'Pertanyaan Baru dari Form Bantuan');
            formData.append('_template', 'table');

            try {
                // Tampilkan loading state
                submitButton.disabled = true;
                submitText.textContent = 'Mengirim...';
                submitSpinner.classList.remove('hidden');

                // Kirim data ke FormSubmit
                const response = await fetch('https://formsubmit.co/ajax/fm230602@gmail.com', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesan Terkirim!',
                        text: 'Pertanyaan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.',
                        confirmButtonColor: '#0f766e',
                        timer: 5000
                    });

                    // Reset form
                    form.reset();
                } else {
                    throw new Error(data.message || 'Gagal mengirim pesan');
                }
            } catch (error) {
                // Tampilkan notifikasi error
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim',
                    text: 'Terjadi kesalahan: ' + error.message,
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                // Reset button state
                submitButton.disabled = false;
                submitText.textContent = 'Kirim Pertanyaan';
                submitSpinner.classList.add('hidden');
            }
        });

        // Fix for Google Translate banner
        document.addEventListener('DOMContentLoaded', function() {
            // Remove Google Translate banner if it appears
            function removeGoogleBanner() {
                var banner = document.querySelector('.goog-te-banner-frame');
                if (banner) {
                    banner.style.display = 'none';
                }
                var body = document.querySelector('body');
                if (body) {
                    body.style.top = '0';
                }
            }

            // Run initially and then periodically to catch late-loading elements
            removeGoogleBanner();
            setInterval(removeGoogleBanner, 1000);
        });
    </script>
</body>
</html>
