<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $campaign->clean_title }} • Hoichoi Social Studio</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #060913;
            --bg-card: rgba(15, 23, 42, 0.82);
            --bg-card-inner: rgba(8, 14, 27, 0.95);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(225, 29, 72, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --accent-brand: #e11d48;
            --accent-hover: #f43f5e;
            --accent-glow: rgba(225, 29, 72, 0.45);
            --accent-cyan: #38bdf8;
            --accent-green: #10b981;
            --accent-purple: #a855f7;
            --accent-amber: #f59e0b;
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Sleek Global Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #060913;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-brand);
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            padding: 20px 24px 80px;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 8%, rgba(225, 29, 72, 0.14) 0%, transparent 40%),
                radial-gradient(circle at 90% 85%, rgba(56, 189, 248, 0.1) 0%, transparent 40%),
                linear-gradient(to bottom, #060913, #0a0f1d);
            background-attachment: fixed;
        }

        .ambient-glow {
            position: fixed;
            top: -120px;
            left: 25%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.12) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 1440px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Top Navigation Bar */
        .top-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 22px;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            flex-wrap: wrap;
            gap: 16px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 8px 14px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(-2px);
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .studio-brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .studio-brand-link:hover {
            transform: scale(1.03);
            filter: drop-shadow(0 0 16px rgba(225, 29, 72, 0.6));
        }

        .hoichoi-studio-nav-logo {
            height: 30px;
            width: auto;
            max-width: 125px;
            object-fit: contain;
            filter: drop-shadow(0 0 12px rgba(225, 29, 72, 0.4));
        }

        .brand-divider {
            width: 1px;
            height: 28px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.05));
        }

        .brand-title {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--text-muted);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-action-save {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action-save:hover {
            background: rgba(16, 185, 129, 0.25);
            color: #ffffff;
            border-color: rgba(16, 185, 129, 0.6);
            transform: translateY(-1px);
        }

        .btn-action-save.saving {
            opacity: 0.8;
            pointer-events: none;
            cursor: wait;
        }

        .btn-action-save.saved {
            background: rgba(16, 185, 129, 0.4) !important;
            border-color: rgba(16, 185, 129, 0.9) !important;
            color: #ffffff !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5) !important;
        }

        /* ========================================================= */
        /* Project Overview & Metadata Banner with Star Spotlight    */
        /* ========================================================= */
        .project-banner {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .banner-content-grid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .banner-main-info {
            flex: 1;
            min-width: 320px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--accent-green);
            margin-bottom: 8px;
        }

        .campaign-title-input {
            width: 100%;
            background: transparent;
            border: 1px solid transparent;
            color: #ffffff;
            font-family: var(--font-sans);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.02em;
            padding: 4px 0;
            border-radius: 8px;
            transition: all 0.2s;
            margin-bottom: 10px;
        }

        .campaign-title-input:hover,
        .campaign-title-input:focus {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--border-subtle);
            padding: 4px 10px;
            outline: none;
        }

        .meta-badges {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* Prominent Lead Star Spotlight Card */
        .star-spotlight-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);
            border: 1.5px solid rgba(244, 63, 94, 0.45);
            box-shadow: 0 0 25px rgba(225, 29, 72, 0.25), 0 8px 24px rgba(0, 0, 0, 0.5);
            border-radius: 18px;
            padding: 14px 20px;
            backdrop-filter: blur(16px);
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .star-spotlight-card:hover {
            border-color: rgba(244, 63, 94, 0.8);
            box-shadow: 0 0 35px rgba(225, 29, 72, 0.45);
            transform: translateY(-2px);
        }

        .star-avatar-wrap {
            position: relative;
            width: 64px;
            height: 64px;
            flex-shrink: 0;
        }

        .star-spotlight-img {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid var(--accent-brand);
            box-shadow: 0 0 16px var(--accent-glow);
            background: #1e293b;
            display: block;
        }

        .star-spotlight-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 2px dashed rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .star-verified-badge {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--accent-brand);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #0b1120;
            box-shadow: 0 0 8px var(--accent-glow);
        }

        .star-spotlight-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .star-role-label {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #fda4af;
        }

        .star-actor-name {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.01em;
        }

        .star-cast-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 8px var(--accent-green);
        }

        .brief-box {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .brief-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--accent-cyan);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ========================================================= */
        /* ✨ HIGHLIGHTED AI MARKETING COPILOT COMMAND CENTER        */
        /* ========================================================= */
        .ai-copilot-banner {
            position: relative;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.18) 0%, rgba(139, 92, 246, 0.22) 50%, rgba(56, 189, 248, 0.18) 100%);
            border: 1px solid rgba(244, 63, 94, 0.5);
            box-shadow: 0 0 35px rgba(225, 29, 72, 0.25), inset 0 0 20px rgba(139, 92, 246, 0.15);
            border-radius: 20px;
            padding: 18px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            backdrop-filter: blur(20px);
        }

        .ai-copilot-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .ai-copilot-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #e11d48, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 0 20px rgba(225, 29, 72, 0.6);
            animation: pulseAura 3s infinite alternate;
        }

        @keyframes pulseAura {
            from { box-shadow: 0 0 16px rgba(225, 29, 72, 0.4); transform: scale(1); }
            to { box-shadow: 0 0 28px rgba(139, 92, 246, 0.7); transform: scale(1.03); }
        }

        .ai-copilot-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .ai-copilot-title {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #ffffff;
            text-shadow: 0 0 12px rgba(255, 255, 255, 0.4);
        }

        .ai-zero-images-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 9999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #6ee7b7;
            letter-spacing: 0.04em;
        }

        .ai-copilot-desc {
            font-size: 12.5px;
            color: #cbd5e1;
            line-height: 1.4;
        }

        .ai-copilot-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-ai-magic {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #e11d48 0%, #be123c 50%, #8b5cf6 100%);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 0 20px var(--accent-glow);
            text-shadow: 0 1px 2px rgba(0,0,0,0.4);
        }

        .btn-ai-magic:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(225, 29, 72, 0.7);
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 50%, #a855f7 100%);
        }

        .btn-ai-pill-quick {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }

        .btn-ai-pill-quick:hover {
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-1px);
        }

        /* 3-Platform Studio Grid */
        .studio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 40px;
            align-items: start;
        }

        @media (max-width: 1150px) {
            .studio-grid {
                grid-template-columns: 1fr;
            }
        }

        .platform-panel {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .platform-panel:hover {
            border-color: rgba(255, 255, 255, 0.16);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.55);
        }

        .platform-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.02);
        }

        .platform-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 800;
        }

        .platform-badge-tag {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .tag-ig { background: rgba(225, 29, 72, 0.15); color: #fda4af; border: 1px solid rgba(225, 29, 72, 0.3); }
        .tag-yt { background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); }
        .tag-x { background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3); }

        /* Schedule Publish Widget Styles */
        .schedule-publish-box {
            padding: 12px 18px;
            background: rgba(15, 23, 42, 0.65);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.25s ease;
        }

        .schedule-status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .schedule-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: -0.1px;
            transition: all 0.25s ease;
        }

        .schedule-badge.published {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.5);
            color: #34d399;
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.2);
        }

        .schedule-badge.scheduled {
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.5);
            color: #38bdf8;
            box-shadow: 0 0 16px rgba(56, 189, 248, 0.2);
        }

        .schedule-badge.unscheduled {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--text-muted);
        }

        .schedule-indicator-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .schedule-badge.published .schedule-indicator-dot {
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulsePublished 2s infinite;
        }

        .schedule-badge.scheduled .schedule-indicator-dot {
            background: #38bdf8;
            box-shadow: 0 0 8px #38bdf8;
            animation: pulseScheduled 1.8s infinite;
        }

        .schedule-badge.unscheduled .schedule-indicator-dot {
            background: #94a3b8;
        }

        @keyframes pulsePublished {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(1.3); }
        }

        @keyframes pulseScheduled {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.25); }
        }

        .btn-toggle-schedule {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-toggle-schedule:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .schedule-form-wrap {
            display: none;
            flex-direction: column;
            gap: 8px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px 12px;
            margin-top: 4px;
            animation: paneEnter 0.25s ease forwards;
        }

        .schedule-form-wrap.open {
            display: flex;
        }

        .schedule-input-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .schedule-datetime-input {
            flex: 1;
            min-width: 170px;
            background: rgba(15, 23, 42, 0.85);
            border: 1.5px solid var(--border-subtle);
            border-radius: 8px;
            color: #ffffff;
            font-family: inherit;
            font-size: 12px;
            padding: 6px 10px;
            outline: none;
            transition: all 0.2s;
            color-scheme: dark;
        }

        .schedule-datetime-input:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.3);
        }

        .btn-schedule-save {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .btn-schedule-save:hover {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transform: translateY(-1px);
        }

        .btn-schedule-now {
            background: linear-gradient(135deg, #059669, #047857);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .btn-schedule-now:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            transform: translateY(-1px);
        }

        .schedule-quick-presets {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .preset-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-dim);
            font-weight: 700;
        }

        .btn-quick-sched {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-size: 10.5px;
            padding: 3px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-quick-sched:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: rgba(56, 189, 248, 0.4);
            color: #ffffff;
        }

        .btn-quick-sched.clear {
            color: #fda4af;
        }

        .btn-quick-sched.clear:hover {
            background: rgba(244, 63, 94, 0.2);
            border-color: rgba(244, 63, 94, 0.5);
            color: #ffffff;
        }

        /* Media Box */
        .panel-image-wrap {
            position: relative;
            background: #000000;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .panel-image-wrap.ratio-1-1 { aspect-ratio: 1 / 1; }
        .panel-image-wrap.ratio-16-9 { aspect-ratio: 16 / 9; }

        .panel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .panel-image-wrap:hover .panel-image {
            transform: scale(1.02);
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 60%);
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 14px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .panel-image-wrap:hover .image-overlay {
            opacity: 1;
        }

        .btn-overlay-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.95);
            color: #0f172a;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(0,0,0,0.4);
        }

        .btn-overlay-download:hover {
            background: #ffffff;
            transform: translateY(-2px);
        }

        /* Platform Featured AI Action Header inside Card */
        .platform-ai-bar {
            padding: 10px 18px;
            background: linear-gradient(90deg, rgba(225, 29, 72, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
            border-bottom: 1px solid rgba(225, 29, 72, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .btn-platform-ai-boost {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.25), rgba(139, 92, 246, 0.3));
            border: 1px solid rgba(244, 63, 94, 0.55);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 800;
            padding: 8px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 0 14px rgba(225, 29, 72, 0.3);
        }

        .btn-platform-ai-boost:hover {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.45), rgba(139, 92, 246, 0.5));
            border-color: rgba(244, 63, 94, 0.9);
            transform: translateY(-1px);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        /* Panel Body & Form Blocks */
        .panel-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
        }

        .field-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .field-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .field-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .char-counter {
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--text-dim);
            padding: 2px 6px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 4px;
        }

        .char-counter.warning { color: #f59e0b; }
        .char-counter.danger { color: #ef4444; font-weight: 700; }

        .btn-field-copy {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-field-copy:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        /* Radiant, Highly Highlighted AI Buttons */
        .btn-field-ai {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.35) 0%, rgba(139, 92, 246, 0.45) 100%);
            border: 1px solid rgba(244, 63, 94, 0.6);
            color: #ffffff;
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 11.5px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 0 12px rgba(225, 29, 72, 0.35);
        }

        .btn-field-ai:hover {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.6) 0%, rgba(139, 92, 246, 0.7) 100%);
            border-color: #fda4af;
            color: #ffffff;
            box-shadow: 0 0 18px var(--accent-glow);
            transform: translateY(-1px);
        }

        /* Auto-expanding clean textarea with NO internal scrollbar */
        .field-textarea {
            width: 100%;
            background: var(--bg-card-inner);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--text-main);
            font-family: var(--font-sans);
            font-size: 13.5px;
            line-height: 1.6;
            overflow-y: hidden; /* Eliminates internal scroller! */
            resize: none; /* Auto-resizes via JavaScript */
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-input {
            width: 100%;
            background: var(--bg-card-inner);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--text-main);
            font-family: var(--font-sans);
            font-size: 13.5px;
            line-height: 1.5;
            transition: all 0.2s ease;
        }

        .field-input:focus, .field-textarea:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.18);
            background: rgba(8, 14, 27, 0.98);
        }

        /* Tag Chips & Input */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px;
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(56, 189, 248, 0.08);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 12px;
            color: #7dd3fc;
            font-family: var(--font-mono);
            font-weight: 500;
        }

        /* Highlight pulse animation for AI updated field */
        @keyframes fieldUpdatedGlow {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.8); border-color: var(--accent-green); }
            50% { box-shadow: 0 0 25px 4px rgba(16, 185, 129, 0.5); border-color: var(--accent-green); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); border-color: var(--border-subtle); }
        }

        .field-highlight {
            animation: fieldUpdatedGlow 1.6s ease-out;
        }

        /* Panel Footer */
        .panel-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.015);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .btn-panel-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.12), rgba(255, 61, 0, 0.08));
            border: 1px solid rgba(229, 9, 20, 0.35);
            color: #ff9e99;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }

        .btn-panel-save:hover {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.28), rgba(255, 61, 0, 0.18));
            border-color: rgba(229, 9, 20, 0.7);
            color: #ffffff;
            box-shadow: 0 0 16px rgba(229, 9, 20, 0.35);
            transform: translateY(-1px);
        }

        .btn-panel-save:active {
            transform: translateY(0);
        }

        .btn-panel-save.saving {
            opacity: 0.8;
            pointer-events: none;
            cursor: wait;
        }

        .btn-panel-save.saved {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.25), rgba(5, 150, 105, 0.15)) !important;
            border-color: rgba(16, 185, 129, 0.8) !important;
            color: #34d399 !important;
            box-shadow: 0 0 18px rgba(16, 185, 129, 0.4) !important;
        }

        /* AI Prompt Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-card {
            background: #0b1120;
            border: 1px solid var(--border-focus);
            border-radius: 22px;
            padding: 28px;
            max-width: 540px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.9), 0 0 50px var(--accent-glow);
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-close-modal {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.15s;
        }

        .btn-close-modal:hover { color: #ffffff; }

        .modal-notice {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #6ee7b7;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .prompt-chips-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .preset-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 16px;
        }

        .preset-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 10px 12px;
            text-align: left;
            cursor: pointer;
            transition: all 0.15s;
            color: var(--text-main);
            font-size: 12px;
            font-weight: 600;
        }

        .preset-btn:hover {
            background: rgba(225, 29, 72, 0.18);
            border-color: rgba(225, 29, 72, 0.5);
            color: #ffffff;
        }

        .modal-textarea {
            width: 100%;
            background: var(--bg-card-inner);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px;
            color: #ffffff;
            font-family: var(--font-sans);
            font-size: 13px;
            min-height: 80px;
            margin-bottom: 20px;
            resize: vertical;
        }

        .modal-textarea:focus {
            outline: none;
            border-color: var(--border-focus);
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal-cancel {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-modal-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--accent-brand), #be123c);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 0 16px var(--accent-glow);
        }

        .btn-modal-submit:hover {
            background: linear-gradient(135deg, var(--accent-hover), var(--accent-brand));
            box-shadow: 0 0 24px var(--accent-glow);
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid var(--accent-green);
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 2000;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Loading Spinner */
        .spinner-mini {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <div class="container">

        <!-- Top Navigation Bar -->
        <header class="top-navbar">
            <div class="nav-left">
                <a href="{{ route('campaign.index') }}" class="btn-back">
                    <span>←</span>
                    <span>Campaign Studio Hub</span>
                </a>
                <div class="brand-badge">
                    <a href="{{ route('campaign.index') }}" class="studio-brand-link" title="Back to Hub">
                        <img src="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}" alt="Hoichoi" class="hoichoi-studio-nav-logo">
                    </a>
                    <div class="brand-divider"></div>
                    <div>
                        <div class="brand-title">Social Studio</div>
                        <div class="brand-subtitle">Multi-Platform Campaign Workspace</div>
                    </div>
                </div>
            </div>

            <div class="nav-actions">
                <button type="button" class="btn-action-save" id="btnSaveAllTop" onclick="saveAllCopy(this)">
                    <span>💾</span>
                    <span>Save All Changes</span>
                </button>
                <a href="{{ route('campaign.index') }}?view=projects" class="btn-back">
                    <span>📂</span>
                    <span>Ongoing Projects</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;padding:8px 14px;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;transition:all 0.2s ease;font-family:inherit;">
                        <span>🚪</span>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Project Overview & Metadata Banner with Prominent Star Spotlight -->
        <section class="project-banner">
            <div class="banner-content-grid">
                <!-- Left: Title, Status & Meta Tags -->
                <div class="banner-main-info">
                    <div class="status-pill">
                        <span class="pulse-dot"></span>
                        <span>Active Campaign #{{ $campaign->id }}</span>
                    </div>

                    <input 
                        type="text" 
                        id="campaignTitleInput" 
                        class="campaign-title-input" 
                        value="{{ $campaign->clean_title }}" 
                        placeholder="Campaign Title..."
                    >

                    <div class="meta-badges">
                        @if ($campaign->tone)
                            <div class="badge-chip">
                                <span>🎨</span>
                                <span>{{ $campaign->tone }}</span>
                            </div>
                        @endif

                        @if ($campaign->language)
                            <div class="badge-chip">
                                <span>🌐</span>
                                <span>{{ ucfirst($campaign->language) }}</span>
                            </div>
                        @endif

                        @if ($campaign->publish_date)
                            <div class="badge-chip">
                                <span>📅</span>
                                <span>{{ $campaign->publish_date }}</span>
                            </div>
                        @endif

                        <div class="badge-chip">
                            <span>⏱️</span>
                            <span>{{ $campaign->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Prominent Star Cast Persona Spotlight Card -->
                <div class="star-spotlight-card">
                    <div class="star-avatar-wrap">
                        @if ($campaign->actor_photo_url)
                            <img src="{{ $campaign->actor_photo_url }}" alt="{{ $campaign->actor }}" class="star-spotlight-img">
                        @else
                            <div class="star-spotlight-placeholder">🌟</div>
                        @endif
                        <span class="star-verified-badge" title="Lead Cast Persona">✓</span>
                    </div>
                    <div class="star-spotlight-details">
                        <div class="star-role-label">Lead Cast Persona</div>
                        <div class="star-actor-name">{{ $campaign->actor ?: 'Auto Character' }}</div>
                        <div class="star-cast-status">
                            <span class="pulse-dot"></span>
                            <span>Hoichoi OTT Star Roster</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Prompt / Story Brief -->
            <div class="brief-box">
                <div class="brief-label">
                    <span>📝</span>
                    <span>Campaign Prompt / Story Brief</span>
                </div>
                <div>{{ $campaign->brief }}</div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- ✨ HIGHLIGHTED AI MARKETING COPILOT COMMAND CENTER        -->
        <!-- ========================================================= -->
        <section class="ai-copilot-banner">
            <div class="ai-copilot-info">
                <div class="ai-copilot-icon">✨</div>
                <div>
                    <div class="ai-copilot-title-row">
                        <span class="ai-copilot-title">AI Marketing Copilot</span>
                        <span class="ai-zero-images-badge">⚡ Zero-Image Generation • Instant Text & Hashtag Polish</span>
                    </div>
                    <div class="ai-copilot-desc">
                        Powered by <strong>Gemini 3 Flash</strong>. Refines copy, hooks, and hashtags in seconds while keeping your master visuals 100% intact.
                    </div>
                </div>
            </div>

            <div class="ai-copilot-actions">
                <button type="button" class="btn-ai-magic" onclick="openImproveModal('all', 'Entire Campaign Package')">
                    <span>✨</span>
                    <span>Magic Polish All Platforms</span>
                </button>
                <button type="button" class="btn-ai-pill-quick" onclick="quickImproveAll('Make it punchier, high energy and click-compelling')">
                    <span>⚡</span>
                    <span>High-CTR Viral</span>
                </button>
                <button type="button" class="btn-ai-pill-quick" onclick="quickImproveAll('Add deep atmospheric suspense, dark mystery and psychological intrigue')">
                    <span>🕵️</span>
                    <span>Dark Thriller</span>
                </button>
            </div>
        </section>

        <!-- 3-Platform Studio Workspaces -->
        <main class="studio-grid">

            <!-- ============================================== -->
            <!-- 1. INSTAGRAM HUB (1:1 Square)                 -->
            <!-- ============================================== -->
            <div class="platform-panel" id="panelInstagram">
                <div class="platform-header">
                    <div class="platform-title">
                        <span>📸</span>
                        <span>Instagram Post</span>
                    </div>
                    <span class="platform-badge-tag tag-ig">1:1 Square</span>
                </div>

                @php
                    $igStatus = $campaign->getPostPublishStatus('instagram');
                @endphp
                <!-- Instagram Schedule Publish Widget -->
                <div class="schedule-publish-box" id="scheduleBox_instagram">
                    <div class="schedule-status-row">
                        <div class="schedule-badge {{ $igStatus['status'] }}" id="schedBadge_instagram">
                            <span class="schedule-indicator-dot"></span>
                            <span class="schedule-status-text" id="schedStatusText_instagram">
                                @if ($igStatus['status'] === 'published')
                                    ✅ Published ({{ $igStatus['scheduled_at_formatted'] }})
                                @elseif ($igStatus['status'] === 'scheduled')
                                    ⏳ Scheduled: {{ $igStatus['scheduled_at_formatted'] }} ({{ $igStatus['human_diff'] }})
                                @else
                                    ⏱️ Draft • Unscheduled
                                @endif
                            </span>
                        </div>
                        <button type="button" class="btn-toggle-schedule" onclick="toggleScheduleForm('instagram')">
                            <span>📅 Schedule Publish</span>
                        </button>
                    </div>

                    <div class="schedule-form-wrap" id="scheduleForm_instagram">
                        <div class="schedule-input-row">
                            <input 
                                type="datetime-local" 
                                class="schedule-datetime-input" 
                                id="schedInput_instagram" 
                                value="{{ $igStatus['scheduled_at_input'] }}"
                            >
                            <button type="button" class="btn-schedule-save" onclick="savePostSchedule('instagram', this)">
                                <span>📅 Set Time</span>
                            </button>
                            <button type="button" class="btn-schedule-now" onclick="scheduleQuick('instagram', 'now', this)">
                                <span>⚡ Publish Now</span>
                            </button>
                        </div>
                        <div class="schedule-quick-presets">
                            <span class="preset-label">Quick:</span>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('instagram', '+1hour')">+1 Hr</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('instagram', '+3hours')">+3 Hrs</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('instagram', 'tomorrow_9am')">Tomorrow 9 AM</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('instagram', 'tomorrow_8pm')">Tomorrow 8 PM</button>
                            <button type="button" class="btn-quick-sched clear" onclick="scheduleQuick('instagram', 'clear')">✕ Clear</button>
                        </div>
                    </div>
                </div>

                <div class="panel-image-wrap ratio-1-1">
                    <img id="imgInstagram" src="{{ $campaign->instagram_image_url }}" alt="Instagram Visual" class="panel-image">
                    <div class="image-overlay">
                        <span style="font-size: 11px; color: #ffffff; font-weight: 600;">1080 × 1080 Master Visual</span>
                        <a href="{{ $campaign->instagram_image_url }}" download="instagram-post-{{ $campaign->id }}.jpg" class="btn-overlay-download">
                            <span>⬇️</span>
                            <span>Download 1:1</span>
                        </a>
                    </div>
                </div>

                <!-- High-Impact Platform AI Header -->
                <div class="platform-ai-bar">
                    <button type="button" class="btn-platform-ai-boost" onclick="openImproveModal('instagram', 'Full Instagram Package')">
                        <span>✨</span>
                        <span>AI Polish Instagram Post (Caption + Hashtags)</span>
                    </button>
                </div>

                <div class="panel-body">
                    <!-- Post Caption -->
                    <div class="field-group" id="groupIgCaption">
                        <div class="field-header">
                            <label class="field-label" for="igCaptionInput">
                                <span>Post Caption</span>
                            </label>
                            <div class="field-actions">
                                <span class="char-counter" id="igCaptionCount">0 chars</span>
                                <button type="button" class="btn-field-copy" onclick="copyField('igCaptionInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('instagram_caption', 'Instagram Caption')">
                                    <span>✨</span>
                                    <span>Improve with AI</span>
                                </button>
                            </div>
                        </div>
                        <textarea 
                            id="igCaptionInput" 
                            class="field-textarea" 
                            placeholder="Enter Instagram caption with hook, storyline, and CTA..."
                            oninput="onTextareaInput(this, 'igCaptionCount')"
                        >{{ $campaign->instagram_caption }}</textarea>
                    </div>

                    <!-- Instagram Hashtags -->
                    <div class="field-group" id="groupIgHashtags">
                        <div class="field-header">
                            <label class="field-label" for="igHashtagsInput">
                                <span>Hashtags (Space/Comma-separated)</span>
                            </label>
                            <div class="field-actions">
                                <button type="button" class="btn-field-copy" onclick="copyField('igHashtagsInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('instagram_hashtags', 'Instagram Hashtags')">
                                    <span>✨</span>
                                    <span>AI Trending Tags</span>
                                </button>
                            </div>
                        </div>
                        <input 
                            type="text" 
                            id="igHashtagsInput" 
                            class="field-input" 
                            value="{{ is_array($campaign->instagram_hashtags) ? implode(' ', $campaign->instagram_hashtags) : $campaign->instagram_hashtags }}"
                            placeholder="#Hoichoi #BengaliOTT #NewSeries..."
                            oninput="renderTagPills('igHashtagsInput', 'igTagPills')"
                        >
                        <div class="tags-container" id="igTagPills"></div>
                    </div>
                </div>

                <div class="panel-footer">
                    <span style="font-size: 11px; color: var(--text-dim);">1:1 Feed Ready</span>
                    <button type="button" class="btn-panel-save" id="btnSaveInstagram" onclick="savePlatformCopy('instagram', this)">
                        <span>💾</span>
                        <span>Save Instagram</span>
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- 2. YOUTUBE VIDEO HUB (16:9 Thumbnail & Title)  -->
            <!-- ============================================== -->
            <div class="platform-panel" id="panelYoutube">
                <div class="platform-header">
                    <div class="platform-title">
                        <span>▶️</span>
                        <span>YouTube Video</span>
                    </div>
                    <span class="platform-badge-tag tag-yt">16:9 Landscape</span>
                </div>

                @php
                    $ytStatus = $campaign->getPostPublishStatus('youtube');
                @endphp
                <!-- YouTube Schedule Publish Widget -->
                <div class="schedule-publish-box" id="scheduleBox_youtube">
                    <div class="schedule-status-row">
                        <div class="schedule-badge {{ $ytStatus['status'] }}" id="schedBadge_youtube">
                            <span class="schedule-indicator-dot"></span>
                            <span class="schedule-status-text" id="schedStatusText_youtube">
                                @if ($ytStatus['status'] === 'published')
                                    ✅ Published ({{ $ytStatus['scheduled_at_formatted'] }})
                                @elseif ($ytStatus['status'] === 'scheduled')
                                    ⏳ Scheduled: {{ $ytStatus['scheduled_at_formatted'] }} ({{ $ytStatus['human_diff'] }})
                                @else
                                    ⏱️ Draft • Unscheduled
                                @endif
                            </span>
                        </div>
                        <button type="button" class="btn-toggle-schedule" onclick="toggleScheduleForm('youtube')">
                            <span>📅 Schedule Publish</span>
                        </button>
                    </div>

                    <div class="schedule-form-wrap" id="scheduleForm_youtube">
                        <div class="schedule-input-row">
                            <input 
                                type="datetime-local" 
                                class="schedule-datetime-input" 
                                id="schedInput_youtube" 
                                value="{{ $ytStatus['scheduled_at_input'] }}"
                            >
                            <button type="button" class="btn-schedule-save" onclick="savePostSchedule('youtube', this)">
                                <span>📅 Set Time</span>
                            </button>
                            <button type="button" class="btn-schedule-now" onclick="scheduleQuick('youtube', 'now', this)">
                                <span>⚡ Publish Now</span>
                            </button>
                        </div>
                        <div class="schedule-quick-presets">
                            <span class="preset-label">Quick:</span>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('youtube', '+1hour')">+1 Hr</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('youtube', '+3hours')">+3 Hrs</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('youtube', 'tomorrow_9am')">Tomorrow 9 AM</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('youtube', 'tomorrow_8pm')">Tomorrow 8 PM</button>
                            <button type="button" class="btn-quick-sched clear" onclick="scheduleQuick('youtube', 'clear')">✕ Clear</button>
                        </div>
                    </div>
                </div>

                <div class="panel-image-wrap ratio-16-9">
                    <img id="imgYoutube" src="{{ $campaign->youtube_image_url }}" alt="YouTube Thumbnail" class="panel-image">
                    <div class="image-overlay">
                        <span style="font-size: 11px; color: #ffffff; font-weight: 600;">1920 × 1080 Thumbnail</span>
                        <a href="{{ $campaign->youtube_image_url }}" download="youtube-thumbnail-{{ $campaign->id }}.jpg" class="btn-overlay-download">
                            <span>⬇️</span>
                            <span>Download 16:9</span>
                        </a>
                    </div>
                </div>

                <!-- High-Impact Platform AI Header -->
                <div class="platform-ai-bar">
                    <button type="button" class="btn-platform-ai-boost" onclick="openImproveModal('youtube', 'Full YouTube Package')">
                        <span>✨</span>
                        <span>AI Optimize Video Package (Title + Desc + Tags)</span>
                    </button>
                </div>

                <div class="panel-body">
                    <!-- Video Title -->
                    <div class="field-group" id="groupYtTitle">
                        <div class="field-header">
                            <label class="field-label" for="ytTitleInput">
                                <span>Video Title</span>
                            </label>
                            <div class="field-actions">
                                <span class="char-counter" id="ytTitleCount">0 / 100</span>
                                <button type="button" class="btn-field-copy" onclick="copyField('ytTitleInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('youtube_title', 'YouTube Title')">
                                    <span>✨</span>
                                    <span>AI Boost CTR Title</span>
                                </button>
                            </div>
                        </div>
                        <input 
                            type="text" 
                            id="ytTitleInput" 
                            class="field-input" 
                            style="font-weight: 700;"
                            value="{{ $campaign->youtube_title }}" 
                            placeholder="Enter catchy YouTube video title..."
                            oninput="updateCharCount('ytTitleInput', 'ytTitleCount', 100)"
                        >
                    </div>

                    <!-- Video Description -->
                    <div class="field-group" id="groupYtDescription">
                        <div class="field-header">
                            <label class="field-label" for="ytDescInput">
                                <span>Video Description</span>
                            </label>
                            <div class="field-actions">
                                <span class="char-counter" id="ytDescCount">0 chars</span>
                                <button type="button" class="btn-field-copy" onclick="copyField('ytDescInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('youtube_description', 'YouTube Description')">
                                    <span>✨</span>
                                    <span>AI Enhance Synopsis</span>
                                </button>
                            </div>
                        </div>
                        <textarea 
                            id="ytDescInput" 
                            class="field-textarea" 
                            placeholder="Enter YouTube video description, synopsis, release schedule..."
                            oninput="onTextareaInput(this, 'ytDescCount')"
                        >{{ $campaign->youtube_description }}</textarea>
                    </div>

                    <!-- Video Tags -->
                    <div class="field-group" id="groupYtTags">
                        <div class="field-header">
                            <label class="field-label" for="ytTagsInput">
                                <span>Search Tags / Keywords</span>
                            </label>
                            <div class="field-actions">
                                <button type="button" class="btn-field-copy" onclick="copyField('ytTagsInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('youtube_tags', 'YouTube Tags')">
                                    <span>✨</span>
                                    <span>AI SEO Tags</span>
                                </button>
                            </div>
                        </div>
                        <input 
                            type="text" 
                            id="ytTagsInput" 
                            class="field-input" 
                            value="{{ is_array($campaign->youtube_tags) ? implode(', ', $campaign->youtube_tags) : $campaign->youtube_tags }}"
                            placeholder="Hoichoi, Bengali Series, Detective, New Trailer..."
                            oninput="renderTagPills('ytTagsInput', 'ytTagPills')"
                        >
                        <div class="tags-container" id="ytTagPills"></div>
                    </div>
                </div>

                <div class="panel-footer">
                    <span style="font-size: 11px; color: var(--text-dim);">16:9 Thumbnail Ready</span>
                    <button type="button" class="btn-panel-save" id="btnSaveYoutube" onclick="savePlatformCopy('youtube', this)">
                        <span>💾</span>
                        <span>Save YouTube</span>
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- 3. X / TWITTER HUB (16:9 Banner & Tweet Hook)  -->
            <!-- ============================================== -->
            <div class="platform-panel" id="panelX">
                <div class="platform-header">
                    <div class="platform-title">
                        <span>𝕏</span>
                        <span>X (Twitter) Post</span>
                    </div>
                    <span class="platform-badge-tag tag-x">16:9 Banner</span>
                </div>

                @php
                    $xStatus = $campaign->getPostPublishStatus('x');
                @endphp
                <!-- X Schedule Publish Widget -->
                <div class="schedule-publish-box" id="scheduleBox_x">
                    <div class="schedule-status-row">
                        <div class="schedule-badge {{ $xStatus['status'] }}" id="schedBadge_x">
                            <span class="schedule-indicator-dot"></span>
                            <span class="schedule-status-text" id="schedStatusText_x">
                                @if ($xStatus['status'] === 'published')
                                    ✅ Published ({{ $xStatus['scheduled_at_formatted'] }})
                                @elseif ($xStatus['status'] === 'scheduled')
                                    ⏳ Scheduled: {{ $xStatus['scheduled_at_formatted'] }} ({{ $xStatus['human_diff'] }})
                                @else
                                    ⏱️ Draft • Unscheduled
                                @endif
                            </span>
                        </div>
                        <button type="button" class="btn-toggle-schedule" onclick="toggleScheduleForm('x')">
                            <span>📅 Schedule Publish</span>
                        </button>
                    </div>

                    <div class="schedule-form-wrap" id="scheduleForm_x">
                        <div class="schedule-input-row">
                            <input 
                                type="datetime-local" 
                                class="schedule-datetime-input" 
                                id="schedInput_x" 
                                value="{{ $xStatus['scheduled_at_input'] }}"
                            >
                            <button type="button" class="btn-schedule-save" onclick="savePostSchedule('x', this)">
                                <span>📅 Set Time</span>
                            </button>
                            <button type="button" class="btn-schedule-now" onclick="scheduleQuick('x', 'now', this)">
                                <span>⚡ Publish Now</span>
                            </button>
                        </div>
                        <div class="schedule-quick-presets">
                            <span class="preset-label">Quick:</span>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('x', '+1hour')">+1 Hr</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('x', '+3hours')">+3 Hrs</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('x', 'tomorrow_9am')">Tomorrow 9 AM</button>
                            <button type="button" class="btn-quick-sched" onclick="scheduleQuick('x', 'tomorrow_8pm')">Tomorrow 8 PM</button>
                            <button type="button" class="btn-quick-sched clear" onclick="scheduleQuick('x', 'clear')">✕ Clear</button>
                        </div>
                    </div>
                </div>

                <div class="panel-image-wrap ratio-16-9">
                    <img id="imgX" src="{{ $campaign->x_image_url }}" alt="X Feed Visual" class="panel-image">
                    <div class="image-overlay">
                        <span style="font-size: 11px; color: #ffffff; font-weight: 600;">1200 × 675 Widescreen Banner</span>
                        <a href="{{ $campaign->x_image_url }}" download="x-post-{{ $campaign->id }}.jpg" class="btn-overlay-download">
                            <span>⬇️</span>
                            <span>Download 16:9</span>
                        </a>
                    </div>
                </div>

                <!-- High-Impact Platform AI Header -->
                <div class="platform-ai-bar">
                    <button type="button" class="btn-platform-ai-boost" onclick="openImproveModal('x', 'Full X Post')">
                        <span>✨</span>
                        <span>AI Polish X Post (Viral Hook + Hashtags)</span>
                    </button>
                </div>

                <div class="panel-body">
                    <!-- Tweet Hook -->
                    <div class="field-group" id="groupXHook">
                        <div class="field-header">
                            <label class="field-label" for="xHookInput">
                                <span>Tweet Hook Copy</span>
                            </label>
                            <div class="field-actions">
                                <span class="char-counter" id="xHookCount">0 / 280</span>
                                <button type="button" class="btn-field-copy" onclick="copyField('xHookInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('x_hook', 'Tweet Hook')">
                                    <span>✨</span>
                                    <span>AI Punchy Hook</span>
                                </button>
                            </div>
                        </div>
                        <textarea 
                            id="xHookInput" 
                            class="field-textarea" 
                            placeholder="Enter short, punchy, viral tweet hook..."
                            oninput="onTextareaInput(this, 'xHookCount', 280)"
                        >{{ $campaign->x_hook }}</textarea>
                    </div>

                    <!-- X Hashtags -->
                    <div class="field-group" id="groupXHashtags">
                        <div class="field-header">
                            <label class="field-label" for="xHashtagsInput">
                                <span>Trending Hashtags</span>
                            </label>
                            <div class="field-actions">
                                <button type="button" class="btn-field-copy" onclick="copyField('xHashtagsInput')">📋 Copy</button>
                                <button type="button" class="btn-field-ai" onclick="openImproveModal('x_hashtags', 'X Hashtags')">
                                    <span>✨</span>
                                    <span>AI Viral Tags</span>
                                </button>
                            </div>
                        </div>
                        <input 
                            type="text" 
                            id="xHashtagsInput" 
                            class="field-input" 
                            value="{{ is_array($campaign->x_hashtags) ? implode(' ', $campaign->x_hashtags) : $campaign->x_hashtags }}"
                            placeholder="#Hoichoi #BengaliCinema #NowStreaming..."
                            oninput="renderTagPills('xHashtagsInput', 'xTagPills')"
                        >
                        <div class="tags-container" id="xTagPills"></div>
                    </div>
                </div>

                <div class="panel-footer">
                    <span style="font-size: 11px; color: var(--text-dim);">16:9 Timeline Ready</span>
                    <button type="button" class="btn-panel-save" id="btnSaveX" onclick="savePlatformCopy('x', this)">
                        <span>💾</span>
                        <span>Save X</span>
                    </button>
                </div>
            </div>

        </main>

    </div>

    <!-- AI Improvement Modal Drawer -->
    <div id="aiModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <span>✨</span>
                    <span id="modalTargetLabel">Improve Section with AI</span>
                </div>
                <button type="button" class="btn-close-modal" onclick="closeImproveModal()">✕</button>
            </div>

            <div class="modal-notice">
                <span>⚡</span>
                <span>Fast AI refinement: Generates only high-impact text & hashtags. <strong>No images are regenerated.</strong></span>
            </div>

            <div class="prompt-chips-label">Quick AI Style Direction:</div>
            <div class="preset-grid">
                <button type="button" class="preset-btn" onclick="selectInstruction('Make it punchier, high energy and click-compelling')">
                    ⚡ Punchier & High Energy
                </button>
                <button type="button" class="preset-btn" onclick="selectInstruction('Add deep atmospheric suspense, dark mystery and psychological intrigue')">
                    🕵️ Dark Suspense & Mystery
                </button>
                <button type="button" class="preset-btn" onclick="selectInstruction('Add premiere urgency, excitement, streaming call-to-action and emojis')">
                    🔥 Premiere Urgency & CTA
                </button>
                <button type="button" class="preset-btn" onclick="selectInstruction('Optimize for SEO algorithms, maximum viral reach and trending Bengali keywords')">
                    📈 Viral & SEO Trending
                </button>
            </div>

            <label class="prompt-chips-label" for="customInstructionInput">Custom Instruction (Optional - or type prompt & press Ctrl+Enter):</label>
            <textarea 
                id="customInstructionInput" 
                class="modal-textarea" 
                placeholder="e.g. Focus on the zamindar house secret, make it dramatic, or shorten by 20%..."
                onkeydown="if((event.ctrlKey || event.metaKey) && event.key === 'Enter'){ executeImproveAi(); }"
            ></textarea>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeImproveModal()">Cancel</button>
                <button type="button" class="btn-modal-submit" id="btnSubmitAiImprove" onclick="executeImproveAi()">
                    <span id="btnSubmitAiIcon">✨</span>
                    <span id="btnSubmitAiText">Run AI Improvement</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <span>✅</span>
        <span id="toastMsg">Changes saved!</span>
    </div>

    <script>
        const campaignId = {{ $campaign->id }};
        let activeImproveSection = 'all';

        // Auto-expand textarea to content height (ZERO internal scrollbars!)
        function autoResizeTextarea(el) {
            if (!el) return;
            el.style.height = 'auto';
            el.style.height = Math.max(80, el.scrollHeight + 4) + 'px';
        }

        function onTextareaInput(el, counterId, limit = null) {
            autoResizeTextarea(el);
            updateCharCount(el.id, counterId, limit);
        }

        // Initialize character counters, auto-resizing, and tag pills on page load
        document.addEventListener('DOMContentLoaded', () => {
            const textareas = document.querySelectorAll('.field-textarea');
            textareas.forEach(ta => autoResizeTextarea(ta));

            updateCharCount('igCaptionInput', 'igCaptionCount');
            updateCharCount('ytTitleInput', 'ytTitleCount', 100);
            updateCharCount('ytDescInput', 'ytDescCount');
            updateCharCount('xHookInput', 'xHookCount', 280);

            renderTagPills('igHashtagsInput', 'igTagPills');
            renderTagPills('ytTagsInput', 'ytTagPills');
            renderTagPills('xHashtagsInput', 'xTagPills');
        });

        function updateCharCount(inputId, counterId, limit = null) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (!input || !counter) return;

            const len = input.value.length;
            if (limit) {
                counter.textContent = `${len} / ${limit}`;
                counter.className = 'char-counter';
                if (len > limit) counter.classList.add('danger');
                else if (len > limit * 0.85) counter.classList.add('warning');
            } else {
                counter.textContent = `${len} chars`;
            }
        }

        function renderTagPills(inputId, containerId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);
            if (!input || !container) return;

            const val = input.value.trim();
            if (!val) {
                container.innerHTML = '';
                return;
            }

            // Split by space or comma
            const tags = val.split(/[,\s]+/).filter(t => t.length > 0);
            container.innerHTML = tags.map(t => {
                const formatted = t.startsWith('#') ? t : (t.includes(' ') ? t : '#' + t);
                return `<span class="tag-pill">${formatted}</span>`;
            }).join(' ');
        }

        function copyField(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;

            navigator.clipboard.writeText(input.value).then(() => {
                showToast('Copied to clipboard!');
            }).catch(() => {
                input.select();
                document.execCommand('copy');
                showToast('Copied to clipboard!');
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Modal Controls
        function openImproveModal(section, label) {
            activeImproveSection = section;
            document.getElementById('modalTargetLabel').textContent = '✨ Improve ' + label;
            const input = document.getElementById('customInstructionInput');
            input.value = '';

            const placeholders = {
                'youtube_description': 'e.g. Focus on the 7 secrets of Geilpur and the sea storm betrayal in 2 paragraphs, high suspense...',
                'youtube_title': 'e.g. Include release date, make it punchy and high CTR under 60 characters...',
                'youtube_tags': 'e.g. Add trending Bengali web series and detective thriller search keywords...',
                'instagram_caption': 'e.g. Add deep emotional hook, premiere urgency, and engaging Bengali storytelling...',
                'instagram_hashtags': 'e.g. Include trending OTT tags, Bengali drama, and cast actor tags...',
                'x_hook': 'e.g. Viral question hook under 220 characters with high curiosity and emojis...',
                'x_hashtags': 'e.g. Trending Twitter Bengali tags for OTT premieres...',
                'youtube': 'e.g. Optimize entire YouTube package with dramatic title and rich synopsis...',
                'instagram': 'e.g. Elevate Instagram caption with emotional storytelling and viral hashtags...',
                'x': 'e.g. Make Tweet punchier and provocative with viral trending tags...',
                'all': 'e.g. Transform entire campaign into dark psychological thriller tone...'
            };
            input.placeholder = placeholders[section] || 'e.g. Focus on the plot twist, make it dramatic, or shorten by 20%...';

            document.getElementById('aiModal').style.display = 'flex';
            setTimeout(() => {
                input.focus();
            }, 60);
        }

        function closeImproveModal() {
            document.getElementById('aiModal').style.display = 'none';
        }

        function selectInstruction(text) {
            document.getElementById('customInstructionInput').value = text;
        }

        // Quick 1-click Copilot improvement without opening modal
        async function quickImproveAll(instruction) {
            activeImproveSection = 'all';
            document.getElementById('customInstructionInput').value = instruction;
            showToast('✨ AI Copilot running: ' + instruction.substring(0, 30) + '...');
            await executeImproveAi();
        }

        // Execute AI Copy Improvement (No images generated!)
        async function executeImproveAi() {
            const instruction = document.getElementById('customInstructionInput').value.trim();
            const btn = document.getElementById('btnSubmitAiImprove');
            const btnText = document.getElementById('btnSubmitAiText');
            const btnIcon = document.getElementById('btnSubmitAiIcon');

            if (btn) {
                btn.disabled = true;
                btnIcon.innerHTML = '<div class="spinner-mini"></div>';
                btnText.textContent = 'Refining Copy with AI...';
            }

            try {
                const response = await fetch(`/campaign/${campaignId}/improve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        section: activeImproveSection,
                        instruction: instruction
                    })
                });

                const res = await response.json();

                if (response.ok && res.success && res.data) {
                    applyUpdatedData(res.data, activeImproveSection);
                    closeImproveModal();

                    const sectionNames = {
                        'youtube_description': 'YouTube Synopsis & Description',
                        'youtube_title': 'YouTube Title',
                        'youtube_tags': 'YouTube Tags',
                        'instagram_caption': 'Instagram Caption',
                        'instagram_hashtags': 'Instagram Hashtags',
                        'x_hook': 'X (Twitter) Hook',
                        'x_hashtags': 'X Hashtags',
                        'instagram': 'Instagram Package',
                        'youtube': 'YouTube Package',
                        'x': 'X (Twitter) Post',
                        'all': 'Complete Campaign Package'
                    };
                    const friendlyName = sectionNames[activeImproveSection] || 'Campaign copy';
                    showToast('✨ ' + friendlyName + ' improved with AI! (Saved)');
                } else {
                    alert(res.message || 'Failed to improve copy. Please try again.');
                }
            } catch (err) {
                console.error(err);
                alert('A network error occurred while improving copy.');
            } finally {
                if (btn) {
                    btn.disabled = false;
                    btnIcon.textContent = '✨';
                    btnText.textContent = 'Run AI Improvement';
                }
            }
        }

        function applyUpdatedData(data, section) {
            if (data.title) {
                const titleInput = document.getElementById('campaignTitleInput');
                if (titleInput) {
                    // Clean repeated Campaign: prefixes if any
                    let clean = data.title.replace(/^(Campaign:\s*)+/i, '').replace(/^Title:\s*/i, '').trim();
                    titleInput.value = clean || data.title;
                    highlightField(titleInput);
                }
            }

            // Instagram
            if (data.instagram) {
                if (['all', 'instagram', 'instagram_caption'].includes(section) && data.instagram.caption) {
                    const el = document.getElementById('igCaptionInput');
                    el.value = data.instagram.caption;
                    highlightField(el);
                    autoResizeTextarea(el);
                    updateCharCount('igCaptionInput', 'igCaptionCount');
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                if (['all', 'instagram', 'instagram_hashtags'].includes(section) && data.instagram.hashtags) {
                    const el = document.getElementById('igHashtagsInput');
                    el.value = (data.instagram.hashtags || []).join(' ');
                    highlightField(el);
                    renderTagPills('igHashtagsInput', 'igTagPills');
                }
            }

            // YouTube
            if (data.youtube) {
                if (['all', 'youtube', 'youtube_title'].includes(section) && data.youtube.title) {
                    const el = document.getElementById('ytTitleInput');
                    el.value = data.youtube.title;
                    highlightField(el);
                    updateCharCount('ytTitleInput', 'ytTitleCount', 100);
                }
                if (['all', 'youtube', 'youtube_description'].includes(section) && data.youtube.description) {
                    const el = document.getElementById('ytDescInput');
                    el.value = data.youtube.description;
                    highlightField(el);
                    autoResizeTextarea(el);
                    updateCharCount('ytDescInput', 'ytDescCount');
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                if (['all', 'youtube', 'youtube_tags'].includes(section) && data.youtube.tags) {
                    const el = document.getElementById('ytTagsInput');
                    el.value = (data.youtube.tags || []).join(', ');
                    highlightField(el);
                    renderTagPills('ytTagsInput', 'ytTagPills');
                }
            }

            // X
            if (data.x) {
                if (['all', 'x', 'x_hook'].includes(section) && data.x.hook) {
                    const el = document.getElementById('xHookInput');
                    el.value = data.x.hook;
                    highlightField(el);
                    autoResizeTextarea(el);
                    updateCharCount('xHookInput', 'xHookCount', 280);
                }
                if (['all', 'x', 'x_hashtags'].includes(section) && data.x.hashtags) {
                    const el = document.getElementById('xHashtagsInput');
                    el.value = (data.x.hashtags || []).join(' ');
                    highlightField(el);
                    renderTagPills('xHashtagsInput', 'xTagPills');
                }
            }
        }

        function highlightField(el) {
            el.classList.remove('field-highlight');
            void el.offsetWidth; // trigger reflow
            el.classList.add('field-highlight');
        }

        // Save individual platform copy
        async function savePlatformCopy(platform, btn) {
            btn = btn || event?.currentTarget || document.getElementById('btnSave' + platform.charAt(0).toUpperCase() + platform.slice(1));
            const originalHtml = btn ? btn.innerHTML : '';

            if (btn) {
                btn.disabled = true;
                btn.classList.add('saving');
                btn.innerHTML = '<div class="spinner-mini"></div><span>Saving...</span>';
            }

            let payload = {};
            let successMsg = '';

            if (platform === 'instagram') {
                const igTags = document.getElementById('igHashtagsInput').value
                    .split(/[,\s]+/)
                    .filter(t => t.length > 0)
                    .map(t => t.startsWith('#') ? t : '#' + t);

                payload = {
                    instagram_caption: document.getElementById('igCaptionInput').value.trim(),
                    instagram_hashtags: igTags,
                    instagram_scheduled_at: document.getElementById('schedInput_instagram')?.value || null
                };
                successMsg = '💾 Instagram copy, hashtags & schedule saved to database!';
            } else if (platform === 'youtube') {
                const ytTags = document.getElementById('ytTagsInput').value
                    .split(',')
                    .map(t => t.trim())
                    .filter(t => t.length > 0);

                payload = {
                    youtube_title: document.getElementById('ytTitleInput').value.trim(),
                    youtube_description: document.getElementById('ytDescInput').value.trim(),
                    youtube_tags: ytTags,
                    youtube_scheduled_at: document.getElementById('schedInput_youtube')?.value || null
                };
                successMsg = '💾 YouTube title, synopsis, tags & schedule saved to database!';
            } else if (platform === 'x') {
                const xTags = document.getElementById('xHashtagsInput').value
                    .split(/[,\s]+/)
                    .filter(t => t.length > 0)
                    .map(t => t.startsWith('#') ? t : '#' + t);

                payload = {
                    x_hook: document.getElementById('xHookInput').value.trim(),
                    x_hashtags: xTags,
                    x_scheduled_at: document.getElementById('schedInput_x')?.value || null
                };
                successMsg = '💾 X (Twitter) hook, hashtags & schedule saved to database!';
            }

            const titleEl = document.getElementById('campaignTitleInput');
            if (titleEl && titleEl.value.trim()) {
                payload.title = titleEl.value.trim();
            }

            try {
                const response = await fetch(`/campaign/${campaignId}/copy`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const res = await response.json();
                if (response.ok && res.success) {
                    showToast(successMsg);
                    if (res.data && res.data[platform]) {
                        updateScheduleBadgeInView(platform, res.data[platform].publish_status);
                    }
                    if (btn) {
                        btn.classList.remove('saving');
                        btn.classList.add('saved');
                        btn.innerHTML = '<span>✅</span><span>Saved!</span>';
                        setTimeout(() => {
                            btn.classList.remove('saved');
                            btn.innerHTML = originalHtml;
                            btn.disabled = false;
                        }, 2200);
                    }
                } else {
                    alert(res.message || 'Failed to save changes.');
                    if (btn) {
                        btn.classList.remove('saving');
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                }
            } catch (err) {
                console.error(err);
                alert('A network error occurred while saving.');
                if (btn) {
                    btn.classList.remove('saving');
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            }
        }

        // Save All Copy Changes Manually
        async function saveAllCopy(btn) {
            btn = btn || event?.currentTarget || document.getElementById('btnSaveAllTop') || document.querySelector('.btn-action-save');
            const originalHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.classList.add('saving');
                btn.innerHTML = '<div class="spinner-mini"></div><span>Saving All...</span>';
            }

            const igTags = document.getElementById('igHashtagsInput').value
                .split(/[,\s]+/)
                .filter(t => t.length > 0)
                .map(t => t.startsWith('#') ? t : '#' + t);

            const ytTags = document.getElementById('ytTagsInput').value
                .split(',')
                .map(t => t.trim())
                .filter(t => t.length > 0);

            const xTags = document.getElementById('xHashtagsInput').value
                .split(/[,\s]+/)
                .filter(t => t.length > 0)
                .map(t => t.startsWith('#') ? t : '#' + t);

            const payload = {
                title: document.getElementById('campaignTitleInput').value.trim(),
                instagram_caption: document.getElementById('igCaptionInput').value.trim(),
                instagram_hashtags: igTags,
                instagram_scheduled_at: document.getElementById('schedInput_instagram')?.value || null,
                youtube_title: document.getElementById('ytTitleInput').value.trim(),
                youtube_description: document.getElementById('ytDescInput').value.trim(),
                youtube_tags: ytTags,
                youtube_scheduled_at: document.getElementById('schedInput_youtube')?.value || null,
                x_hook: document.getElementById('xHookInput').value.trim(),
                x_hashtags: xTags,
                x_scheduled_at: document.getElementById('schedInput_x')?.value || null,
            };

            try {
                const response = await fetch(`/campaign/${campaignId}/copy`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const res = await response.json();
                if (response.ok && res.success) {
                    showToast('💾 All campaign copy, hashtags & schedules saved to database!');

                    if (res.data) {
                        if (res.data.instagram) updateScheduleBadgeInView('instagram', res.data.instagram.publish_status);
                        if (res.data.youtube) updateScheduleBadgeInView('youtube', res.data.youtube.publish_status);
                        if (res.data.x) updateScheduleBadgeInView('x', res.data.x.publish_status);
                    }

                    if (btn) {
                        btn.classList.remove('saving');
                        btn.classList.add('saved');
                        btn.innerHTML = '<span>✅</span><span>All Saved!</span>';
                        setTimeout(() => {
                            btn.classList.remove('saved');
                            btn.innerHTML = originalHtml;
                            btn.disabled = false;
                        }, 2200);
                    }

                    // Flash feedback on all 3 platform buttons too
                    ['btnSaveInstagram', 'btnSaveYoutube', 'btnSaveX'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            const orig = el.innerHTML;
                            el.classList.add('saved');
                            el.innerHTML = '<span>✅</span><span>Saved!</span>';
                            setTimeout(() => {
                                el.classList.remove('saved');
                                el.innerHTML = orig;
                            }, 2200);
                        }
                    });
                } else {
                    alert(res.message || 'Failed to save changes.');
                    if (btn) {
                        btn.classList.remove('saving');
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                }
            } catch (err) {
                console.error(err);
                alert('A network error occurred while saving.');
                if (btn) {
                    btn.classList.remove('saving');
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            }
        }

        // ==========================================
        // Schedule Publish Interactive Functionality
        // ==========================================
        function toggleScheduleForm(platform) {
            const form = document.getElementById('scheduleForm_' + platform);
            if (!form) return;
            form.classList.toggle('open');
            if (form.classList.contains('open')) {
                const input = document.getElementById('schedInput_' + platform);
                if (input && !input.value) {
                    // Default to current time + 1 hour if empty
                    input.value = formatToLocalDateTimeInput(new Date(Date.now() + 60 * 60 * 1000));
                }
            }
        }

        function formatToLocalDateTimeInput(d) {
            if (!d) return '';
            const date = new Date(d);
            const pad = n => String(n).padStart(2, '0');
            return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
        }

        async function savePostSchedule(platform, btn) {
            btn = btn || event?.currentTarget;
            const originalHtml = btn ? btn.innerHTML : '';
            const input = document.getElementById('schedInput_' + platform);
            const val = input ? input.value : null;

            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<div class="spinner-mini"></div>';
            }

            try {
                const response = await fetch(`/campaign/${campaignId}/schedule`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        platform: platform,
                        scheduled_at: val ? new Date(val).toISOString() : null
                    })
                });

                const res = await response.json();
                if (response.ok && res.success && res.data) {
                    const postData = res.data[platform];
                    updateScheduleBadgeInView(platform, postData?.publish_status);
                    showToast(res.message);

                    if (btn) {
                        btn.innerHTML = '<span>✅</span>';
                        setTimeout(() => {
                            btn.innerHTML = originalHtml;
                            btn.disabled = false;
                        }, 1500);
                    }
                } else {
                    alert(res.message || 'Failed to update schedule.');
                    if (btn) {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                }
            } catch (err) {
                console.error(err);
                alert('A network error occurred while updating schedule.');
                if (btn) {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            }
        }

        function scheduleQuick(platform, preset, btn) {
            const input = document.getElementById('schedInput_' + platform);
            if (!input) return;

            let targetDate = null;
            const now = new Date();

            if (preset === 'now') {
                // Set to 1 minute ago so it immediately registers as passed / published
                targetDate = new Date(Date.now() - 60 * 1000);
            } else if (preset === '+1hour') {
                targetDate = new Date(Date.now() + 60 * 60 * 1000);
            } else if (preset === '+3hours') {
                targetDate = new Date(Date.now() + 3 * 60 * 60 * 1000);
            } else if (preset === 'tomorrow_9am') {
                targetDate = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 9, 0, 0);
            } else if (preset === 'tomorrow_8pm') {
                targetDate = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 20, 0, 0);
            } else if (preset === 'clear') {
                targetDate = null;
            }

            input.value = targetDate ? formatToLocalDateTimeInput(targetDate) : '';
            savePostSchedule(platform, btn);
        }

        function updateScheduleBadgeInView(platform, publishStatus) {
            const badge = document.getElementById('schedBadge_' + platform);
            const text = document.getElementById('schedStatusText_' + platform);
            const input = document.getElementById('schedInput_' + platform);

            if (!badge || !text) return;

            badge.classList.remove('published', 'scheduled', 'unscheduled');

            if (!publishStatus || publishStatus.status === 'unscheduled') {
                badge.classList.add('unscheduled');
                text.textContent = '⏱️ Draft • Unscheduled';
                if (input && !input.value) input.value = '';
            } else if (publishStatus.status === 'published') {
                badge.classList.add('published');
                text.textContent = `✅ Published (${publishStatus.scheduled_at_formatted || 'Live'})`;
            } else {
                badge.classList.add('scheduled');
                text.textContent = `⏳ Scheduled: ${publishStatus.scheduled_at_formatted || ''} (${publishStatus.human_diff || 'Upcoming'})`;
            }
        }

        // Live Timer: Checks every 10 seconds if any scheduled post target time has arrived
        function checkLiveSchedules() {
            ['instagram', 'youtube', 'x'].forEach(platform => {
                const badge = document.getElementById('schedBadge_' + platform);
                const input = document.getElementById('schedInput_' + platform);
                if (badge && badge.classList.contains('scheduled') && input && input.value) {
                    const scheduledTime = new Date(input.value).getTime();
                    if (Date.now() >= scheduledTime) {
                        badge.classList.remove('scheduled');
                        badge.classList.add('published');
                        const text = document.getElementById('schedStatusText_' + platform);
                        if (text) {
                            text.textContent = '✅ Published (Just Now)';
                        }
                        showToast(`🎉 ${platform.toUpperCase()} post scheduled time reached! Post published.`);
                    }
                }
            });
        }
        setInterval(checkLiveSchedules, 10000);
    </script>
</body>
</html>
