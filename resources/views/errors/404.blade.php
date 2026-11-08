<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>404 - Halaman Tidak Ditemukan | CampSewa</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <!-- Preload primary bird images with lightweight WebP format for instant render -->
    <link rel="preconnect" href="https://images.ctfassets.net">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            height: 100dvh;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            font-family: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            touch-action: none;
            -webkit-user-select: none;
            user-select: none;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            height: 100dvh;
            z-index: 1;
            pointer-events: none;
        }

        .error-container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px 16px;
            gap: 16px;
            max-width: 620px;
            pointer-events: none;
        }

        h1.error-code {
            font-size: clamp(130px, 30vw, 360px);
            line-height: 0.85;
            color: #ffffff;
            -webkit-text-stroke: 1.5px rgba(203, 213, 225, 0.7);
            margin: 0;
            padding: 0;
            font-weight: 900;
            letter-spacing: -0.05em;
            user-select: none;
            text-shadow: 0 12px 36px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .quote-card {
            max-width: min(540px, 92vw);
            text-align: center;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 12px 22px;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            pointer-events: none;
        }

        .quote-text {
            font-size: 13.5px;
            font-style: italic;
            color: #334155;
            line-height: 1.55;
            letter-spacing: 0.2px;
            font-weight: 500;
        }

        a.back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            padding: 10px 24px;
            background: #111827;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            border-radius: 999px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.16);
            pointer-events: all;
            transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
        }

        a.back-link:hover,
        a.back-link:active {
            background: #70f46d;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(112, 244, 109, 0.35);
        }

        /* Mobile Adjustments (Handphone & Touch Devices) */
        @media (max-width: 600px) {
            .error-container {
                gap: 12px;
                padding: 16px 12px;
            }

            h1.error-code {
                font-size: clamp(110px, 30vw, 170px);
                -webkit-text-stroke: 1.2px rgba(203, 213, 225, 0.85);
            }

            .quote-card {
                padding: 10px 16px;
                border-radius: 14px;
                max-width: 90vw;
            }

            .quote-text {
                font-size: 12px;
                line-height: 1.48;
            }

            a.back-link {
                padding: 8px 20px;
                font-size: 13px;
                gap: 6px;
            }
        }

        /* Small Phones (e.g. iPhone SE, 360px width) */
        @media (max-width: 380px) {
            h1.error-code {
                font-size: clamp(95px, 28vw, 140px);
            }

            .quote-card {
                padding: 8px 12px;
            }

            .quote-text {
                font-size: 11px;
            }

            a.back-link {
                padding: 7px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <canvas id="featherCanvas"></canvas>

    <main class="error-container">
        <h1 class="error-code">404</h1>

        <div class="quote-card">
            <p class="quote-text">
                Halaman yang Anda tuju sepertinya tersesat di alam liar atau sudah tidak tersedia.
            </p>
        </div>

        <a href="{{ route('public.beranda') }}" class="back-link">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
    </main>

    <script>
        const canvas = document.getElementById("featherCanvas");
        const ctx = canvas.getContext("2d", { alpha: true });

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener("resize", resizeCanvas);

        // SVG Feather Path (Single compiled instance for maximum performance)
        const featherSvg = "M527.4 85.1v-2.3c0-1.6-.2-3.1-.5-4.7a294 294 0 0 1-4.7-36.3c-.3-4.7-1-9.4-1.6-14-.2-1.9-.8-3.6-1.2-5.4-.2-.7-.4-1.4-.4-2.1 0-1 .4-1.9 1.3-2.2 1-.3 2.1-.4 2.7.7.7 1.2 2 1.5 3.2 1.5h5.4c2.6-.2 4.3.9 5.2 3.2l3.4 9c.4 1.1 1 2 1.8 3.4 1.2-2.4.4-4.4.2-6.3-.1-2-.5-3.9-.8-6.3 5.3 4.5 9.5 9 9.6 16v13.3c-.3 6.9-.5 13.7.3 20.6.5 4.5 1.2 9 3 13.3 1.2 3.2 3 6.2 5.7 8.4l1.2.7c-.2-.7-.1-1-.3-1.4a27.3 27.3 0 0 1-1.6-16c2-14 6.2-27.5 12-40.5 1-2.1 2.4-4.1 4-6 1.6-1.8 3-1.8 4.8 0a16 16 0 0 0 5.3 3.6 13 13 0 0 1 7 7c1.7 3.8 2.5 7.9 2.8 12 .7 9.3-.7 18.3-3.8 27-1.8 5.1-3.7 10.2-4.4 15.5-.3 2-.4 4-.4 6 0 1.1 0 2.4 1.6 3.4.4-.8.9-1.6 1-2.4.6-2.2 1-4.5 1.5-6.7a28.8 28.8 0 0 1 26-21.7c3.4-.1 6.7.3 9.6 2.4.7.5 1.4 1.2 2 1.9.6 1 .3 1.7-1 2l-1.9-.1c-.9-.1-1.8-.4-2.6-.6-7.7-2.5-14.4-.3-20.6 4a19 19 0 0 0-6.3 7l2.6-1.5c7.9-5 16.4-5.8 25.3-4.1 2.5.4 5 1.4 6.5 3.6 1.3 1.7 1.6 3.2.8 3.8-1.4.9-2.6.1-3.6-.7l-2.8-2c-1.5-1-1.8-.9-3.3 0-1.8 1.2-3.8 2.2-5.6 3.3-2 1.1-4.1 2-6 3.4-7.7 5.5-5 15 .5 18.1 3.8 2.2 7.8 4.1 11.9 5.6a568 568 0 0 1 102.2 49.8c3.5 2.5 6.8 5.3 10.1 8 1.1 1 1.8 2.2 1.4 3.8-1 .9-2.2.4-3.3 0-4.6-2.2-9.3-4.2-13.8-6.6-16-8.6-31.8-17.5-48.2-25.4-14.6-7-29.3-13.7-44.5-19.3a23.5 23.5 0 0 0-24.7 4.5 60 60 0 0 0-14.5 18.4c-.5 1-.7 2.2-1 3.3l-.7 2.6c-.4 1-1.1 1.5-2.2 1.3-1-.2-1.8-.8-1.8-2s-.1-2.5.2-3.6c1-3.5 2.1-7 3.5-10.3 1.9-4.8 4.2-9.4 7.3-13.5 1.6-2.2 3.6-4 5.5-6 .9-.8 2-1.5 2.4-2.8-1-.9-2-.3-2.8 0a17.5 17.5 0 0 0-10.5 9.2c-2 4.4-3.7 8.8-5.5 13.3l-3.4 8.7a28.4 28.4 0 0 1-8.4 11.3 335 335 0 0 1-13.4 10.5c-1.5 1.2-3.2 2-5 2.8-1.7.7-2.5.3-3.5-1.2l-1.3-1.8c-.1-.2-.4-.2-.7-.4-1.5.7-1.8 2.1-2.2 3.4-.9 3.5-1.5 7-2.4 10.4-1 4.2-2.1 8.3-3.3 12.4-.3 1.3-.9 2.5-2.3 3.4-1.4-4 .4-8-.3-11.7-2.4.6-4.1 3.1-4.1 5.8 0 .7.2 1.4 0 2a9 9 0 0 1-1.3 2.8c-.3.4-1.2.6-1.7.4-.5-.2-1-1-.9-1.5.3-2.4.6-4.8 1.2-7 .8-3.6 2-7 3-10.6.2-.6.4-1.4.3-2.2l-6 8c-.8 1-1.8 2-2.7 2.8-.7.6-1.6 1-2.2.3-.4-.5-.6-1.6-.4-2.2.3-1.1 1-2.1 1.7-3a60.9 60.9 0 0 0 8.5-15.9c.2-.3.2-.7 0-1.4l-1.9 1.8c-2.7 3.3-5.4 6.7-8.3 9.8a88.2 88.2 0 0 1-16.3 14.4c-1.7 1.1-3.5 2-5.2 2.9-1.7.7-3.1.5-4.6-.7-3.5-2.9-4.3-2.7-8.4-.5-3 1.6-6 3-9.1 4.4-1.6.6-3.4.8-5 1.1-.7.1-1.3 0-2.1-.1.3-1.6 1.2-2.4 2-3.4 3-3.6 6-7.1 8.9-10.8 3-4 5.3-8.2 7.3-12.7.1-.3.2-.7-.1-1.3-.7.7-1.5 1.4-2.1 2.2L471 195.7a11.2 11.2 0 0 1-4.2 3.3l-.6-.3c-1.7-1.8-2.3-1.9-4.2-.2-2.6 2.1-5 4.4-7.4 6.6l-.8.7c-1.2 1.1-2.4 2.3-4.3 1.5a5 5 0 0 1-3-4.4c-.1-1.2.1-2.5.2-4-.6.4-1.1.5-1.5.9-1.4 1-2.8 2.3-4.2 3.4-1 .8-2.1 1.3-3.7.9 0-.9 0-1.7.3-2.4.3-.8.7-1.7 1.3-2.3 3.8-4.2 6.4-9 8.8-14 4.8-10.1 9.4-20.2 14.1-30.4 4.2-9 8.7-17.8 14.6-25.8 3.6-4.8 7.5-9.5 11.2-14.2l3.7-4.9c-1.3-.4-2 .3-2.7.8a67 67 0 0 0-14.5 12.3 102.2 102.2 0 0 0-18 29.4c-3 7.5-5.8 15.1-9.6 22.3a95 95 0 0 1-14.7 21.6c-1.9 2-4 3.6-6.1 5-2.7 1.9-5.7 1.6-8.6.5a5 5 0 0 1-3.3-5.7c.2-1.1.5-2.3 1-3.3a95.6 95.6 0 0 0 7.6-21.1c1.8-6.3 3.3-12.7 5-19a98.6 98.6 0 0 1 15.3-31.2l14.3-18.7c.6-.7 1-1.6 1.4-2.5-2.9.9-5.1 2.6-7.3 4.6a72.5 72.5 0 0 0-12.9 16.8 241.5 241.5 0 0 0-17 36c-4 10.5-8.2 20.8-13.6 30.6a47 47 0 0 1-8.8 11.3c.2-.5.3-1.1.6-1.6a331.5 331.5 0 0 0 19.1-44.6A155 155 0 0 1 434 121c3.6-5.5 7.7-10.8 11.5-16.1l1-1.6a95 95 0 0 0-16.7 18.5c-8 12.2-13.8 25.5-19 39a1205 1205 0 0 1-11.3 28 29.7 29.7 0 0 1-7.8 10.5c-1.2 1.1-2.5 2.3-4.6 2.3l-.3-4.1c-3.6-.1-6.4 2.4-10 3.4l5-14.3c-3 2.7-4.5 6.5-7.9 9.2l-2-3c-.9.8-1.7 1.4-2.3 2.2-1.4 1.7-2.5 3.5-3.9 5.2-2.3 3-3.8 3.4-7.3 2.3a21 21 0 0 1-3.7-1.5c-1.7-1-2.3-1.9-1.7-3.7a35 35 0 0 0-1-20 160 160 0 0 1-4.9-41.2c0-3.6 0-7.1 2-10.3v-.6c-1.2-.2-1.6.7-2 1.4-1.6 2.7-3.1 5.5-4.5 8.3-2.7 5.6-5.1 11.4-8 17a72 72 0 0 1-40.7 35c-1.8.8-3.6 1.4-5.7 1.2-1-.2-2 .6-2.9 1.2l-6.5 5.7c-1.1 1-2.4 1.8-3.7 2.4-1.7.8-2.8 0-2.8-1.8 0-1.2.1-2.5.6-3.6 1-3 2.1-6 3.6-8.7 7.5-13.7 13.7-28 19.8-42.4 3.1-7.4 6.2-15 10.6-21.8 2-3 4.2-6 6.7-8.9 3.3-3.7 7-7.3 10.4-10.9l1.3-1.5-1.8-.3-5.4-.1a18.2 18.2 0 0 0-14.3 6.2 53 53 0 0 0-9 14.1c-4 8.2-6.9 16.8-9.7 25.5-4 12.6-8.2 25.3-13.4 37.5-1.6 3.6-3.5 7.1-5.3 10.6a5.1 5.1 0 0 1-3.5 2.7c-.8-.7-.7-1.6-.4-2.5.5-1.6.9-3.4 1.8-4.8a59 59 0 0 0 6-16.5c1.9-7.6 3.4-15.3 5.2-23 2.2-9.2 4.4-18.4 7-27.5 1-4 2.8-7.6 4.3-11.4l1.3-3.6-.4-.3c-.4.2-1 .4-1.3.8-1.3 1.7-2.8 3.5-3.9 5.4-3.8 6.8-6.5 14-8.6 21.6-2 7.2-4 14.5-5.2 21.9a81 81 0 0 1-13.8 33.3c-1.3 1.8-2.5 3.7-3.9 5.5-.5.7-1.1 1.4-1.8 2-.5.2-1.1.4-1.7.3-3-.3-5-4.5-3.2-7l.4-.6c5.5-6.5 8.1-14.3 10.2-22.4.2-.9.1-1.8.2-2.8-.2 0-.4-.2-.5-.3-.6.5-1.2.9-1.5 1.4l-6.5 9a47.2 47.2 0 0 1-9.8 11.5 27.3 27.3 0 0 1-5.3 3.2c-1.2.6-2.7.9-4 .8-3.1-.3-6.2 0-9 1-7.6 2.2-15.2 3.3-23 3.8a53.7 53.7 0 0 0-18.2 3c-4.4 1.4-8.8 2.5-13.2 3.5-1.3.4-2.8.3-4.2.2-1.5-.2-2-1-1.3-2.5a7 7 0 0 1 1.2-1.8c1.3-1.5 2.7-3 4.1-4.3a37 37 0 0 0 11.6-19.8 176 176 0 0 0 3.8-28.7l-.1-2.8-.5-.2c-.3.5-.8 1-1 1.7l-4.5 13a95 95 0 0 1-5.6 14.6 49.9 49.9 0 0 1-14 16.2c-7.6 6-15.5 11.5-24.2 16-1.3.6-2.6 1.2-4 1.6-1.1.3-2.3.1-3.4.2-1.6.1-3.2 0-4.6.6-3 1-6 2.5-9.1 3.8l-10 4.4c-1.2.5-2.5 1-3.8 1l-21.3 1.1a27 27 0 0 1-4.7-.3c-1.4-.2-2.8-.5-2.4-3l-2.4 1.8a26.8 26.8 0 0 1-14.4 5.9c-1.8.2-3.4-.3-5-1-2.6-.9-5.3-1.2-8-1.6-3.7-.6-7.5-1-11.2-1.7-1.8-.4-3.4-1.3-5-2.1-.8-.4-1.3-1.2-2.2-2l2.6-1.7c1.9-1.1 2-2 .3-3.3l-5-3.7a22 22 0 0 1-7-9.4l-.6-2.4c-.1-1.2.4-2.2 1.5-2.7 1-.4 1.6-1 .9-2.2-.8-1.2-.3-2.1.6-2.9 1.3-1.1 2.7-2 4-3.2l2.5-2c-2-1.5-3.8-1.5-5.9 0-3 2.2-6.3 2.9-9.7 3.2H.6l-.6-.6 2.3-2.3c5.8-4.6 11-9.8 15.2-15.9 2.6-3.6 4.9-7.3 7.5-10.8 5-6.4 10.5-12.3 17.1-17.1 1.8-1.3 4-2.3 6-3.3 2.1-1 4.2-1.8 6-3.7-1.4-.7-2.5-.3-3.5 0-2.7.7-5.3 1.6-8 2.1-3.3.6-6.8 1-10.2 1.2-2.1.1-2.4-.2-3.8-1.5.5-1.1 1.7-1.1 2.7-1.3l5.1-.7L40 124c-2.3-2.2-5.1-1.2-7.5-2.5.8-.5 1.3-.9 2-1.2 2.7-1.6 2.9-1.9 2.3-5.1 1.1-.5 2.3-1.2 3.5-1.5 5-1.3 9.1-4.1 12.6-8 3.8-4.3 8.2-7.8 13.7-9.9 3-1 5.2-3 6.6-6 1.4-3.2 3.8-5.3 7-6.5 3.1-1.2 6.2-2.4 9.4-3.4l13.9-4.4c1.2-.4 2.3-.9 3.4-1.5 2.3-1.2 2.5-2.3 1.2-4.6a8 8 0 0 0-3.4-3.5l-1.3-.9c1.1-.5 1.8-1 2.7-1.3 9.5-3.2 19-6.4 29-8 2.6-.3 2.9-.6 2.4-3.1-.4-1.6 0-2.2 1.5-2.4 2-.2 3.8-.1 5.7-.2 1.4 0 2.8 0 4-.7-1.2-3.3-1-4.1 2.4-5.5 1.8-.7 3.8-1.2 5.7-1.7l7.7-1.6a14 14 0 0 0 7-3.2 11 11 0 0 1 5.6-2.7l8.8-1.5 9.9-1.3c1.4-.3 2.8-.5 4-1.7.5-.5 1.7-.6 2.5-.7l9-.7c1.7-.2 3.5-.4 5.3-.8.8-.1 1.9-.3 2.2-1 1.3-1.8 3-1.5 4.7-1.3A85.5 85.5 0 0 1 255 36.2c5.9 3.5 11 8 15.8 12.8l16.6 17c2 2 3.8 4 6.6 5.9l-.5-1.8c-5.2-10.4-10.2-21-15.5-31.3-3-5.7-6.8-11-10.7-16-1.6-2.2-3-4.4-4.2-6.8-.8-1.5-2-3.5-.5-5 1.5-1.7 3.4-.5 5 .2 4 1.6 7.2 4.1 10.3 6.8a109 109 0 0 1 16.5 18.8c5.5 7.5 9.7 15.7 14 23.9l3.4 5.2c.2-1.1.5-1.5.4-2 0-1-.1-2-.3-2.9-3-13.7-6.8-27-12.2-40-2.2-5.1-4.7-10-8.7-14-2.2-2.2-1.9-3 1-3.8 3.1-.8 6.2-1 9.1.7 1.8 1 3.7.5 5.6.1 1.3-.3 2.6-.8 3.8-1 3-.3 5.6.6 8.1 2 5.8 3 10 7.7 14 12.8 2.9 4 5.3 8.3 7.4 12.8l1.9 3.2c1.3-1.2 1-2.6 1-3.7a216 216 0 0 0-2-12.5c-.6-3.3-1.5-6.6-2.2-9.9-.2-1-.3-2-.3-3.2-.1-1-.2-2.2 1-2.5.6-.2 1.7 0 2.4.5l5 4 3 2.7c-.2-3.5-2.9-6-1.8-9.2 1.7.5 2.7 1.6 3.3 2.8.9 1.7 1.6 3.5 2.3 5.2.7 1.5 1.1 3.3 3 4.6.1-1.3.2-2.3.1-3.3-.2-2 0-3.8 1-5.6 2-3.8 5.5-4.5 8.4-1.2 1.7 2 3 4.3 4.2 6.6 2.7 5.3 4.3 11 6 16.8 2.8 9.5 5.5 19 8.5 28.5 1.5 4.5 3.4 9 5.3 13.3 2 4.6 4.9 8.4 8.4 11.8 2 1.9 4 3.6 6.3 5.2l-1.2-2.5c-2-4.3-4.3-8.5-6-12.8a57.8 57.8 0 0 1-4.4-23.7c.2-10.2 1.9-20 5.3-29.7 1.3-3.8 3.1-7.4 6-10.3 2.4-2.3 5.1-3.4 8.4-3.2 2.4.2 3.5 1 4 3.3.4 2 .7 4.2.8 6.4.5 6.6.7 13.3 1.5 20 1.5 12.9 5.1 25.2 11.5 36.6a47.4 47.4 0 0 0 16.8 18c3.4 1.8 7 2.6 10.9 3.2l-1.7-1.9a36.4 36.4 0 0 1-10.4-16.6c-2.4-7.4-4.5-14.9-6.5-22.4-2.5-9.5-4.8-19.2-8.3-28.5-1-2.6-2.3-5.1-3.4-7.7-.6-1-1.2-2.2-1.6-3.3-.6-2.2.3-3 2.5-2.4 2.6.7 4.8 2.1 6.8 3.9A43 43 0 0 1 446 23.5c2.2 4 4.1 8.3 6 12.5l3.7 8.1c.4.9 1 1.6 1.6 2.6 1.2-1.1 1-2.3 1-3.4 0-6.6-.8-13-2.3-19.4-.8-3.9-2-7.6-3.3-11.4-1.3-3.8-.9-4.4 3.1-4.9 6.3-.7 10.6 2.3 14 7 4.4 6 7.7 12.4 10.7 19l17 38.8 3.4 6.8.5-.1-.1-1.8c-3-14.2-6.6-28.2-11-42A41.8 41.8 0 0 0 479 18.1c-2.3-2.3-4.2-5-6.3-7.7-.5-.7-.6-1.7-1-2.6 1.4-.8 2.3-.3 3.2.2l4.7 3.2c1.2.7 2.2 1.7 4 2l.1-3.7c1 .7 1.6 1 2.1 1.6a71.5 71.5 0 0 1 12.8 19.3c1.8 4 2.8 8.5 4 12.8l5 20.2a11 11 0 0 0 2.3 5c1-1.1 1-2.3 1-3.4-.1-4.5-.1-9-.6-13.6-.6-6.2-1.5-12.3-2.6-18.4-1.3-7.3-3.9-14.1-8.9-19.9-.7-.8-1.5-2-.8-3.1.8-1.3 2.2-1 3.3-.6 2.6.7 4.7 2 6.4 4 3 3.7 5 8 6.6 12.5 2.8 7.8 4.1 16 4.7 24.2.6 8.5 1.6 17 3.7 25.2.6 2.6 1.5 5 2.4 7.6.3.9 1 1.6 1.5 2.4l.8-.2Z";
        const featherPath = new Path2D(featherSvg);

        // Highly-optimized, lightweight WebP image sources (instant ~12KB each)
        const imageSources = [
            "https://images.ctfassets.net/beeay9aupl8z/3kS8zCAqAaViBuakHdni1D/0aecd7a6a83e4732f3e2275c29bbedf5/bird3.jpg?w=380&h=380&fm=webp&q=75",
            "https://images.ctfassets.net/beeay9aupl8z/SrzRQTz94ucUUXSRQw57n/d389f72fa0695d30b3b8c9f22278c7e0/beach.jpg?w=380&h=380&fm=webp&q=75",
            "https://images.ctfassets.net/beeay9aupl8z/73bT2TBQiUOtaQYdJLQgMt/50c131ed50ad2a9e56c3bc7044bf97a1/boarder.jpg?w=380&h=380&fm=webp&q=75",
            "https://images.ctfassets.net/beeay9aupl8z/7xXaESXat6mBfjFQAzamrv/2f43ef3ed50c3085ab393b1b8f29f1cc/bird2.jpg?w=380&h=380&fm=webp&q=75",
            "https://images.ctfassets.net/beeay9aupl8z/36xnMMfdPZiymYMnYJMjNf/4d682fdd5ed8ca5ed89361b1d195799b/bird1.jpg?w=380&h=380&fm=webp&q=75"
        ];

        const loadedImages = [];
        imageSources.forEach((src) => {
            const img = new Image();
            img.crossOrigin = "anonymous";
            img.onload = () => loadedImages.push(img);
            img.src = src;
        });

        // Theme palette for instant zero-lag rendering
        const darkColors = ["#111827", "#0f172a", "#1e293b", "#064e3b", "#052e16", "#14532d"];
        let colorCounter = 0;
        let alternateImage = false;

        function drawFeather(x, y, customScale = null, customRot = null) {
            const w = window.innerWidth;
            const isMobile = w < 600;
            const sizeMultiplier = isMobile ? (w / 1250) : Math.min(1.0, w / 1400);

            const baseRandScale = isMobile ? (0.35 + Math.random() * 0.40) : (0.32 + Math.random() * 0.48);
            const scale = (customScale ?? baseRandScale) * sizeMultiplier;
            const rot = customRot ?? (Math.random() * Math.PI * 2);

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(rot);
            ctx.scale(scale, scale);
            ctx.translate(-280, -110);

            if (alternateImage && loadedImages.length > 0) {
                ctx.save();
                ctx.clip(featherPath);
                const chosen = loadedImages[Math.floor(Math.random() * loadedImages.length)];
                ctx.drawImage(chosen, -80, -80, 750, 450);
                ctx.restore();
                alternateImage = false;
            } else {
                ctx.fillStyle = darkColors[colorCounter % darkColors.length];
                colorCounter++;
                ctx.fill(featherPath);
                alternateImage = loadedImages.length > 0;
            }

            ctx.restore();
        }

        // Pointer & touch move event with smooth interpolation (60+ FPS responsive)
        let lastX = null;
        let lastY = null;
        let lastTime = 0;

        function getEventPos(e) {
            if (e.touches && e.touches.length > 0) {
                return { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }
            return { x: e.clientX, y: e.clientY };
        }

        function handlePointer(e) {
            const pos = getEventPos(e);
            if (!pos || pos.x === undefined || pos.y === undefined) return;

            if (lastX === null) {
                lastX = pos.x;
                lastY = pos.y;
                drawFeather(pos.x, pos.y);
                return;
            }

            const dx = pos.x - lastX;
            const dy = pos.y - lastY;
            const dist = Math.hypot(dx, dy);
            const now = performance.now();

            const isMobile = window.innerWidth < 600;
            const minDistance = isMobile ? 18 : 26;
            const minInterval = isMobile ? 25 : 35;

            if (dist > minDistance || now - lastTime > minInterval) {
                drawFeather(pos.x, pos.y);
                lastX = pos.x;
                lastY = pos.y;
                lastTime = now;
            }
        }

        window.addEventListener("pointerdown", handlePointer, { passive: true });
        window.addEventListener("pointermove", handlePointer, { passive: true });
        window.addEventListener("touchmove", (e) => {
            if (!e.target.closest("a.back-link")) {
                e.preventDefault();
            }
            handlePointer(e);
        }, { passive: false });

        // Instantly Auto-Render scene framing 404 nicely on Mobile & Desktop
        function autoRenderScene() {
            const w = window.innerWidth;
            const h = window.innerHeight;
            const isMobile = w < 600;
            const sizeMultiplier = isMobile ? (w / 1250) : Math.min(1.0, w / 1400);

            const initialBurst = isMobile ? [
                // Mobile layout: framing top, sides and bottom around 404
                { x: w * 0.16, y: h * 0.24, s: 0.85 },
                { x: w * 0.84, y: h * 0.25, s: 0.80 },
                { x: w * 0.50, y: h * 0.15, s: 0.90 },
                { x: w * 0.10, y: h * 0.42, s: 0.75 },
                { x: w * 0.90, y: h * 0.42, s: 0.75 },
                { x: w * 0.22, y: h * 0.76, s: 0.85 },
                { x: w * 0.78, y: h * 0.76, s: 0.85 },
                // Atmospheric corners
                { x: w * 0.12, y: h * 0.10, s: 0.80 },
                { x: w * 0.88, y: h * 0.10, s: 0.80 },
                { x: w * 0.14, y: h * 0.90, s: 0.80 },
                { x: w * 0.86, y: h * 0.90, s: 0.80 }
            ] : [
                // Desktop full panoramic layout
                { x: w * 0.28, y: h * 0.32, s: 0.70 },
                { x: w * 0.72, y: h * 0.32, s: 0.75 },
                { x: w * 0.50, y: h * 0.22, s: 0.70 },
                { x: w * 0.18, y: h * 0.44, s: 0.65 },
                { x: w * 0.82, y: h * 0.44, s: 0.70 },
                { x: w * 0.26, y: h * 0.74, s: 0.75 },
                { x: w * 0.74, y: h * 0.74, s: 0.70 },
                { x: w * 0.12, y: h * 0.16, s: 0.80 },
                { x: w * 0.88, y: h * 0.18, s: 0.80 },
                { x: w * 0.15, y: h * 0.88, s: 0.75 },
                { x: w * 0.85, y: h * 0.88, s: 0.80 }
            ];

            initialBurst.forEach((pt, i) => {
                setTimeout(() => {
                    drawFeather(pt.x, pt.y, pt.s);
                }, i * 20);
            });
        }

        if (document.readyState === "complete" || document.readyState === "interactive") {
            autoRenderScene();
        } else {
            window.addEventListener("DOMContentLoaded", autoRenderScene);
        }
    </script>
</body>
</html>
