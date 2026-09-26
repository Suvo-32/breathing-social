<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OTT Social Campaign AI • Hoichoi Studio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg-dark: #07090e;
            --bg-card: rgba(15, 23, 42, 0.75);
            --bg-card-inner: rgba(10, 15, 29, 0.85);
            --accent-brand: #e11d48;
            --accent-glow: rgba(225, 29, 72, 0.35);
            --accent-yellow: #fbbf24;
            --accent-blue: #38bdf8;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(225, 29, 72, 0.6);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --font-main: 'Outfit', sans-serif;
            --font-bn: 'Hind Siliguri', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: var(--font-main);
            min-height: 100vh;
            line-height: 1.5;
            padding: 24px 20px 80px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glows */
        .ambient-glow-1 {
            position: fixed;
            top: -120px;
            left: 20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.15) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-2 {
            position: fixed;
            bottom: -100px;
            right: 15%;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.1) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header Navigation */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            margin-bottom: 28px;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .brand-text h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .brand-text p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .header-badges {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pill-badge {
            font-size: 11px;
            font-family: var(--font-mono);
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pill-badge.active {
            border-color: rgba(34, 197, 94, 0.4);
            color: #4ade80;
            background: rgba(34, 197, 94, 0.1);
        }

        .nav-link-btn {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-main);
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            transition: all 0.2s;
        }

        .nav-link-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Brief Studio Input Card */
        .brief-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 22px;
            padding: 26px;
            margin-bottom: 32px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .brief-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .brief-title {
            font-size: 17px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brief-textarea {
            width: 100%;
            height: 90px;
            background: var(--bg-card-inner);
            border: 1.5px solid var(--border-subtle);
            border-radius: 14px;
            padding: 14px 16px;
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            line-height: 1.5;
            resize: none;
            outline: none;
            transition: all 0.2s;
        }

        .brief-textarea:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .brief-presets {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .preset-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .preset-chip:hover {
            background: rgba(225, 29, 72, 0.15);
            border-color: var(--accent-brand);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .cast-chip {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            color: var(--text-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .cast-chip:hover {
            border-color: #38bdf8;
            color: #ffffff;
            background: rgba(56, 189, 248, 0.1);
        }

        .cast-chip.active {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.3) 0%, rgba(190, 18, 60, 0.3) 100%);
            border-color: var(--accent-brand);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 0 12px var(--accent-glow);
        }

        .brief-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            gap: 16px;
            flex-wrap: wrap;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .options-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .select-wrap label {
            font-size: 11px;
            color: var(--text-muted);
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .select-input {
            background: var(--bg-card-inner);
            border: 1px solid var(--border-subtle);
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 13px;
            outline: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-generate-campaign {
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 50%, #fb7185 100%);
            color: #ffffff;
            border: none;
            padding: 13px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px var(--accent-glow);
            transition: all 0.2s;
        }

        .btn-generate-campaign:hover:not(:disabled) {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 12px 30px rgba(225, 29, 72, 0.5);
        }

        .btn-generate-campaign:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Progress Loader Card */
        .progress-box {
            display: none;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 32px;
            text-align: center;
        }

        .progress-spinner {
            width: 44px;
            height: 44px;
            border: 3px solid rgba(225, 29, 72, 0.2);
            border-top-color: var(--accent-brand);
            border-radius: 50%;
            margin: 0 auto 16px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .progress-step-text {
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .progress-subtext {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Multi-Platform Output Grid */
        .campaign-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        @media (max-width: 1024px) {
            .campaign-grid {
                grid-template-columns: 1fr;
            }
        }

        .platform-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.25s ease;
        }

        .platform-card:hover {
            border-color: rgba(255, 255, 255, 0.16);
            transform: translateY(-2px);
        }

        .platform-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.02);
        }

        .platform-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .platform-badge.ig { color: #f43f5e; }
        .platform-badge.yt { color: #ef4444; }
        .platform-badge.x { color: #38bdf8; }

        .ratio-tag {
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Image Stage */
        .platform-image-wrap {
            position: relative;
            background: #000000;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .platform-image-wrap.ratio-1-1 { aspect-ratio: 1 / 1; }
        .platform-image-wrap.ratio-16-9 { aspect-ratio: 16 / 9; }

        .platform-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .platform-card:hover .platform-image {
            transform: scale(1.02);
        }

        .image-overlay-actions {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 6px;
        }

        .btn-overlay {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: all 0.15s;
        }

        .btn-overlay:hover {
            background: #e11d48;
            border-color: #e11d48;
        }

        /* Body Details */
        .platform-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex: 1;
        }

        .content-block {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .content-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .btn-copy {
            background: transparent;
            border: none;
            color: var(--accent-blue);
            font-size: 11px;
            cursor: pointer;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border-radius: 4px;
            transition: background 0.15s;
        }

        .btn-copy:hover {
            background: rgba(56, 189, 248, 0.1);
        }

        .text-box {
            background: var(--bg-card-inner);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            line-height: 1.5;
            color: #e2e8f0;
            font-family: var(--font-bn);
            white-space: pre-wrap;
            max-height: 140px;
            overflow-y: auto;
        }

        .hashtags-box {
            background: var(--bg-card-inner);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 12px;
            color: #38bdf8;
            font-family: var(--font-mono);
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .hashtag-item {
            background: rgba(56, 189, 248, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* Toast Feedback */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            border: 1px solid var(--border-subtle);
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            z-index: 2000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.25s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">

        <!-- Header -->
        <header class="header">
            <div class="brand-area">
                <div class="brand-logo">🎬</div>
                <div class="brand-text">
                    <h1>Hoichoi Social Studio</h1>
                    <p>One Brief → Multi-Platform Social Media Campaign Generator</p>
                </div>
            </div>

            <div class="header-badges">
                <div class="pill-badge active">
                    <span>⚡</span>
                    <span>Cloudflare FLUX</span>
                </div>
                <div class="pill-badge active">
                    <span>🧠</span>
                    <span>Gemini 3 Flash</span>
                </div>
                <a href="{{ route('image-generator.index') }}" class="nav-link-btn">
                    Single Image Generator →
                </a>
            </div>
        </header>

        <!-- Brief Input Section -->
        <section class="brief-card">
            <div class="brief-header">
                <div class="brief-title">
                    <span>📝</span>
                    <span>Enter Campaign Brief</span>
                </div>
                <span style="font-size: 12px; color: var(--text-muted);">Generates Instagram, YouTube & X assets together</span>
            </div>

            <form id="campaignForm" onsubmit="generateCampaign(event)">
                <textarea
                    id="briefInput"
                    name="brief"
                    class="brief-textarea"
                    placeholder="e.g. Byomkesh S9, dark & mysterious, from 10 Oct..."
                    required
                >Byomkesh S9, dark & mysterious, from 10 Oct</textarea>

                <div class="brief-presets">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Sample Briefs:</span>
                    <button type="button" class="preset-chip" onclick="setBrief('Byomkesh S9, dark & mysterious, from 10 Oct')">
                        🔍 Byomkesh S9 (Dark Thriller)
                    </button>
                    <button type="button" class="preset-chip" onclick="setBrief('Feludar Goyendagiri Season 3, snowy mountains adventure in Darjeeling, releasing 25th Dec')">
                        🏔️ Feludar Goyendagiri (Winter Thriller)
                    </button>
                    <button type="button" class="preset-chip" onclick="setBrief('Mandaar Season 2, intense crime drama and betrayal by the sea, streaming now on Hoichoi')">
                        🌊 Mandaar S2 (Crime Drama)
                    </button>
                    <button type="button" class="preset-chip" onclick="setBrief('উৎসবের মেজাজে নতুন ওয়েব সিরিজ মুক্তি পাচ্ছে কালীপূজায়, পারিবারিক নাটক ও কমেডি')">
                        🏮 উৎসবের নাটক (Family Drama in Bengali)
                    </button>
                </div>

                <div class="brief-controls">
                    <div class="options-row">
                        <div class="select-wrap">
                            <label>Language Style</label>
                            <select id="languageSelect" class="select-input">
                                <option value="bilingual" selected>Bilingual (বাংলিশ / Bengali+English)</option>
                                <option value="bengali">Pure Bengali (খাঁটি বাংলা)</option>
                                <option value="english">English</option>
                            </select>
                        </div>

                        <div class="select-wrap">
                            <label>Tone</label>
                            <select id="toneSelect" class="select-input">
                                <option value="Dark & Mysterious" selected>Dark & Mysterious (Thriller)</option>
                                <option value="High-Octane Action">High-Octane Action</option>
                                <option value="Emotional & Nostalgic">Emotional & Nostalgic</option>
                                <option value="Grand Festival Premiere">Grand Festival Premiere</option>
                            </select>
                        </div>

                        <div class="select-wrap">
                            <label>Visual Composition Mode</label>
                            <select id="imageModeSelect" class="select-input">
                                <option value="unified" selected>🎯 Same Picture in 3 Ratios (1:1 & 16:9 - Uniform Branding)</option>
                                <option value="distinct">🎭 3 Distinct Shots (Separate AI Visuals)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="btn-generate-campaign">
                        <span>✨</span>
                        <span id="submitBtnText">Generate 3-Platform Campaign</span>
                    </button>
                </div>

                <!-- Cast / Star Face Selection Row -->
                <div class="cast-selection-row" style="margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap; gap: 8px;">
                        <span style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            🌟 Star / Face Persona:
                        </span>
                        <span style="font-size: 11px; color: #38bdf8;">
                            📁 Drop up to 10 actor face photos into <code>public/cast/</code> to load them here automatically!
                        </span>
                    </div>

                    <input type="hidden" id="selectedActor" value="">
                    <div class="cast-chips" style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        <button type="button" class="cast-chip active" onclick="selectActor('', this)">
                            ✨ Auto Character
                        </button>
                        @if (!empty($castMembers))
                            @foreach ($castMembers as $actor)
                                <button type="button" class="cast-chip" onclick="selectActor('{{ $actor['name'] }}', this)">
                                    <img src="{{ $actor['image_url'] }}" style="width: 20px; height: 20px; border-radius: 50%; object-fit: cover;" onerror="this.style.display='none'">
                                    <span>{{ $actor['name'] }}</span>
                                </button>
                            @endforeach
                        @else
                            <button type="button" class="cast-chip" onclick="selectActor('Byomkesh Bakshi (Anirban Bhattacharya)', this)">
                                🕵️ Byomkesh (Anirban)
                            </button>
                            <button type="button" class="cast-chip" onclick="selectActor('Feluda / Pradosh Mitter (Tota Roy Chowdhury)', this)">
                                🔍 Feluda (Tota)
                            </button>
                            <button type="button" class="cast-chip" onclick="selectActor('Mandaar (Debasish Mondal)', this)">
                                🌊 Mandaar (Debasish)
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </section>

        <!-- Generation Progress Bar -->
        <div id="progressBox" class="progress-box">
            <div class="progress-spinner"></div>
            <div id="progressStep" class="progress-step-text">Generating campaign package...</div>
            <div id="progressSub" class="progress-subtext">Creating platform copy & rendering 3 distinct AI images</div>
        </div>

        <!-- 3-Platform Output Grid -->
        <main class="campaign-grid" id="campaignGrid" style="{{ $latestCampaign ? '' : 'display: none;' }}">

            <!-- Column 1: Instagram (1:1) -->
            <div class="platform-card">
                <div class="platform-card-header">
                    <div class="platform-badge ig">
                        <span>📸</span>
                        <span>Instagram Post</span>
                    </div>
                    <span class="ratio-tag">1:1 Square</span>
                </div>

                <div class="platform-image-wrap ratio-1-1">
                    <img id="igImage" src="{{ $latestCampaign?->instagram_image_path ? asset('storage/'.$latestCampaign->instagram_image_path) : '' }}" alt="Instagram Visual" class="platform-image">
                    <div class="image-overlay-actions">
                        <a id="igDownload" href="{{ $latestCampaign?->instagram_image_path ? asset('storage/'.$latestCampaign->instagram_image_path) : '#' }}" download="instagram-post.jpg" class="btn-overlay">
                            <span>⬇️</span>
                            <span>Download</span>
                        </a>
                    </div>
                </div>

                <div class="platform-body">
                    <div class="content-block">
                        <div class="content-label">
                            <span>Caption / Copy</span>
                            <button type="button" class="btn-copy" onclick="copyText('igCaptionText')">📋 Copy</button>
                        </div>
                        <div id="igCaptionText" class="text-box">{{ $latestCampaign?->instagram_caption }}</div>
                    </div>

                    <div class="content-block">
                        <div class="content-label">
                            <span>Hashtags</span>
                            <button type="button" class="btn-copy" onclick="copyText('igHashtagsText')">📋 Copy</button>
                        </div>
                        <div id="igHashtagsText" class="hashtags-box">
                            @if ($latestCampaign && is_array($latestCampaign->instagram_hashtags))
                                @foreach ($latestCampaign->instagram_hashtags as $tag)
                                    <span class="hashtag-item">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: YouTube (16:9 Thumbnail & Video Meta) -->
            <div class="platform-card">
                <div class="platform-card-header">
                    <div class="platform-badge yt">
                        <span>▶️</span>
                        <span>YouTube Video</span>
                    </div>
                    <span class="ratio-tag">16:9 Thumbnail</span>
                </div>

                <div class="platform-image-wrap ratio-16-9">
                    <img id="ytImage" src="{{ $latestCampaign?->youtube_image_path ? asset('storage/'.$latestCampaign->youtube_image_path) : '' }}" alt="YouTube Thumbnail" class="platform-image">
                    <div class="image-overlay-actions">
                        <a id="ytDownload" href="{{ $latestCampaign?->youtube_image_path ? asset('storage/'.$latestCampaign->youtube_image_path) : '#' }}" download="youtube-thumbnail.jpg" class="btn-overlay">
                            <span>⬇️</span>
                            <span>Download</span>
                        </a>
                    </div>
                </div>

                <div class="platform-body">
                    <div class="content-block">
                        <div class="content-label">
                            <span>Video Title</span>
                            <button type="button" class="btn-copy" onclick="copyText('ytTitleText')">📋 Copy</button>
                        </div>
                        <div id="ytTitleText" class="text-box" style="max-height: 60px; font-weight: 600;">{{ $latestCampaign?->youtube_title }}</div>
                    </div>

                    <div class="content-block">
                        <div class="content-label">
                            <span>Description</span>
                            <button type="button" class="btn-copy" onclick="copyText('ytDescText')">📋 Copy</button>
                        </div>
                        <div id="ytDescText" class="text-box">{{ $latestCampaign?->youtube_description }}</div>
                    </div>

                    <div class="content-block">
                        <div class="content-label">
                            <span>Tags / Keywords</span>
                            <button type="button" class="btn-copy" onclick="copyText('ytTagsText')">📋 Copy</button>
                        </div>
                        <div id="ytTagsText" class="hashtags-box">
                            @if ($latestCampaign && is_array($latestCampaign->youtube_tags))
                                @foreach ($latestCampaign->youtube_tags as $t)
                                    <span class="hashtag-item">{{ $t }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3: X / Twitter (16:9 Banner & Tweet Hook) -->
            <div class="platform-card">
                <div class="platform-card-header">
                    <div class="platform-badge x">
                        <span>𝕏</span>
                        <span>X (Twitter) Post</span>
                    </div>
                    <span class="ratio-tag">16:9 Banner</span>
                </div>

                <div class="platform-image-wrap ratio-16-9">
                    <img id="xImage" src="{{ $latestCampaign?->x_image_path ? asset('storage/'.$latestCampaign->x_image_path) : '' }}" alt="X Feed Image" class="platform-image">
                    <div class="image-overlay-actions">
                        <a id="xDownload" href="{{ $latestCampaign?->x_image_path ? asset('storage/'.$latestCampaign->x_image_path) : '#' }}" download="x-post.jpg" class="btn-overlay">
                            <span>⬇️</span>
                            <span>Download</span>
                        </a>
                    </div>
                </div>

                <div class="platform-body">
                    <div class="content-block">
                        <div class="content-label">
                            <span>Tweet Hook Copy</span>
                            <button type="button" class="btn-copy" onclick="copyText('xHookText')">📋 Copy</button>
                        </div>
                        <div id="xHookText" class="text-box" style="min-height: 120px;">{{ $latestCampaign?->x_hook }}</div>
                    </div>

                    <div class="content-block">
                        <div class="content-label">
                            <span>Hashtags</span>
                            <button type="button" class="btn-copy" onclick="copyText('xHashtagsText')">📋 Copy</button>
                        </div>
                        <div id="xHashtagsText" class="hashtags-box">
                            @if ($latestCampaign && is_array($latestCampaign->x_hashtags))
                                @foreach ($latestCampaign->x_hashtags as $xt)
                                    <span class="hashtag-item">{{ $xt }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <span>✅</span>
        <span id="toastMsg">Copied to clipboard!</span>
    </div>

    <script>
        function setBrief(text) {
            document.getElementById('briefInput').value = text;
            document.getElementById('briefInput').focus();
        }

        function selectActor(actorName, btn) {
            document.getElementById('selectedActor').value = actorName;
            document.querySelectorAll('.cast-chip').forEach(c => c.classList.remove('active'));
            if (btn) btn.classList.add('active');
        }

        async function generateCampaign(e) {
            e.preventDefault();

            const brief = document.getElementById('briefInput').value.trim();
            if (!brief) return;

            const language = document.getElementById('languageSelect').value;
            const tone = document.getElementById('toneSelect').value;
            const imageMode = document.getElementById('imageModeSelect').value;
            const actor = document.getElementById('selectedActor').value;

            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const progressBox = document.getElementById('progressBox');
            const campaignGrid = document.getElementById('campaignGrid');

            submitBtn.disabled = true;
            submitBtnText.textContent = 'Generating Package...';
            progressBox.style.display = 'block';

            // Cycle progress steps depending on mode
            const steps = imageMode === 'unified' ? [
                '🧠 Gemini 3 Flash crafting campaign copy & master poster prompt...',
                '📸 Cloudflare FLUX rendering master cinematic hero visual...',
                '📐 Formatting 1:1 Instagram post & 16:9 YouTube/X thumbnails...',
                '📦 Finalizing unified social media package...'
            ] : [
                '🧠 Gemini 3 Flash crafting platform copy & tailored prompts...',
                '📸 Cloudflare FLUX rendering Instagram 1:1 square visual...',
                '▶️ Cloudflare FLUX rendering YouTube 16:9 thumbnail...',
                '𝕏 Cloudflare FLUX rendering X 16:9 widescreen still...',
                '📦 Packaging social media assets...'
            ];

            let stepIdx = 0;
            const stepEl = document.getElementById('progressStep');
            stepEl.textContent = steps[0];
            const progressInterval = setInterval(() => {
                stepIdx = (stepIdx + 1) % steps.length;
                stepEl.textContent = steps[stepIdx];
            }, 2500);

            try {
                const response = await fetch('{{ route("campaign.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        brief: brief,
                        language: language,
                        tone: tone,
                        image_mode: imageMode,
                        actor: actor
                    })
                });

                const res = await response.json();

                if (response.ok && res.success && res.data) {
                    renderCampaign(res.data);
                    campaignGrid.style.display = 'grid';
                    showToast('🎉 Complete Campaign Package Generated!');
                    campaignGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    alert(res.message || 'Failed to generate campaign. Please try again.');
                }
            } catch (err) {
                console.error(err);
                alert('A network or server error occurred. Please check execution timeout.');
            } finally {
                clearInterval(progressInterval);
                progressBox.style.display = 'none';
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Generate 3-Platform Campaign';
            }
        }

        function renderCampaign(data) {
            // Instagram
            if (data.instagram) {
                document.getElementById('igImage').src = data.instagram.image_url || '';
                document.getElementById('igDownload').href = data.instagram.image_url || '#';
                document.getElementById('igCaptionText').textContent = data.instagram.caption || '';
                const igTagsEl = document.getElementById('igHashtagsText');
                igTagsEl.innerHTML = (data.instagram.hashtags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }

            // YouTube
            if (data.youtube) {
                document.getElementById('ytImage').src = data.youtube.image_url || '';
                document.getElementById('ytDownload').href = data.youtube.image_url || '#';
                document.getElementById('ytTitleText').textContent = data.youtube.title || '';
                document.getElementById('ytDescText').textContent = data.youtube.description || '';
                const ytTagsEl = document.getElementById('ytTagsText');
                ytTagsEl.innerHTML = (data.youtube.tags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }

            // X
            if (data.x) {
                document.getElementById('xImage').src = data.x.image_url || '';
                document.getElementById('xDownload').href = data.x.image_url || '#';
                document.getElementById('xHookText').textContent = data.x.hook || '';
                const xTagsEl = document.getElementById('xHashtagsText');
                xTagsEl.innerHTML = (data.x.hashtags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }
        }

        function copyText(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const text = el.innerText || el.textContent;
            navigator.clipboard.writeText(text.trim());
            showToast('📋 Copied to clipboard!');
        }

        let toastTimer = null;
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            if (toastTimer) clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>
