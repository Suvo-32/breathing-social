<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hoichoi Social Studio • Campaign Studio & Ongoing Projects</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #060913;
            --bg-card: rgba(15, 23, 42, 0.72);
            --bg-card-inner: rgba(8, 14, 27, 0.85);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(225, 29, 72, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --accent-brand: #e11d48;
            --accent-hover: #f43f5e;
            --accent-glow: rgba(225, 29, 72, 0.4);
            --accent-cyan: #38bdf8;
            --accent-green: #10b981;
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            padding: 24px 16px 80px;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 10%, rgba(225, 29, 72, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(56, 189, 248, 0.08) 0%, transparent 40%),
                linear-gradient(to bottom, #060913, #0a0f1d);
            background-attachment: fixed;
        }

        .ambient-glow-1 {
            position: fixed;
            top: -120px;
            left: 20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.14) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            filter: blur(100px);
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
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .brand-link:hover {
            transform: scale(1.03);
            filter: drop-shadow(0 0 16px rgba(225, 29, 72, 0.6));
        }

        .brand-hoichoi-svg {
            height: 38px;
            width: auto;
            max-width: 150px;
            object-fit: contain;
            filter: drop-shadow(0 0 14px rgba(225, 29, 72, 0.4));
        }

        .brand-divider {
            width: 1px;
            height: 32px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.05));
        }

        .brand-text h1 {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: #ffffff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-pill-pro {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.6px;
            padding: 2px 7px;
            border-radius: 6px;
            background: rgba(225, 29, 72, 0.18);
            border: 1px solid rgba(225, 29, 72, 0.45);
            color: #fb7185;
            text-transform: uppercase;
        }

        .brand-text p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        .empty-state-hoichoi-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
            margin-bottom: 18px;
            opacity: 0.9;
            filter: drop-shadow(0 0 20px rgba(225, 29, 72, 0.45));
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 5px 12px 5px 8px;
        }

        .user-avatar-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e11d48, #be123c);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 0 10px rgba(225, 29, 72, 0.4);
        }

        .user-profile-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-profile-name {
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
        }

        .user-profile-email {
            font-size: 10px;
            color: var(--text-dim);
            font-family: 'JetBrains Mono', monospace;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 7px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.55);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Primary View Switcher: Studio Wizard vs Ongoing Projects */
        .view-switcher {
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 4px;
            gap: 4px;
        }

        .view-switch-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-switch-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .view-switch-btn.active {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.25) 0%, rgba(190, 18, 60, 0.25) 100%);
            border: 1px solid var(--accent-brand);
            color: #ffffff;
            box-shadow: 0 0 14px var(--accent-glow);
        }

        .count-pill {
            font-size: 11px;
            font-family: var(--font-mono);
            background: rgba(225, 29, 72, 0.3);
            border: 1px solid var(--accent-brand);
            color: #ffffff;
            padding: 1px 7px;
            border-radius: 999px;
            font-weight: 700;
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

        /* Views Container */
        .view-section {
            display: none;
            animation: viewFade 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .view-section.active {
            display: block;
        }

        @keyframes viewFade {
            from { opacity: 0; transform: translateY(12px); filter: blur(4px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        /* Generator Center Card */
        .studio-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.55);
            position: relative;
            overflow: hidden;
        }

        /* Stepper Navigation Bar */
        .stepper-container {
            margin-bottom: 28px;
            position: relative;
        }

        .stepper-progress-track {
            height: 4px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 999px;
            position: relative;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .stepper-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #e11d48, #f43f5e, #38bdf8);
            border-radius: 999px;
            transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stepper-tabs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        @media (max-width: 1024px) {
            .stepper-tabs {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .step-tab {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: left;
            position: relative;
            color: var(--text-muted);
        }

        .step-tab:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .step-tab.active {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.15) 0%, rgba(15, 23, 42, 0.9) 100%);
            border-color: var(--accent-brand);
            color: #ffffff;
            box-shadow: 0 0 16px rgba(225, 29, 72, 0.25);
        }

        .step-tab.completed {
            border-color: rgba(16, 185, 129, 0.4);
            color: #e2e8f0;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .step-tab.active .step-num {
            background: var(--accent-brand);
            box-shadow: 0 0 10px var(--accent-glow);
        }

        .step-tab.completed .step-num {
            background: var(--accent-green);
        }

        .step-text {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .step-tag {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-dim);
            font-weight: 700;
        }

        .step-name {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        /* Wizard Panes */
        .wizard-pane {
            display: none;
            animation: paneEnter 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .wizard-pane.active {
            display: block;
        }

        @keyframes paneEnter {
            from { opacity: 0; transform: translateY(14px) scale(0.99); filter: blur(4px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        .pane-header {
            margin-bottom: 20px;
        }

        .pane-title {
            font-size: 19px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.2px;
        }

        .pane-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Step 1: Prompt Input */
        .brief-textarea {
            width: 100%;
            height: 110px;
            background: var(--bg-card-inner);
            border: 1.5px solid var(--border-subtle);
            border-radius: 16px;
            padding: 16px 18px;
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            line-height: 1.55;
            resize: none;
            outline: none;
            transition: all 0.25s ease;
        }

        .brief-textarea:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 24px var(--accent-glow);
        }

        .brief-presets {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .preset-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            padding: 6px 12px;
            border-radius: 999px;
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

        /* Step 2 & 3: Selection Cards */
        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 14px;
            margin-top: 12px;
        }

        .select-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1.5px solid var(--border-subtle);
            border-radius: 16px;
            padding: 18px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .select-card:hover {
            border-color: rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
        }

        .select-card.active {
            border-color: var(--accent-brand);
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.18) 0%, rgba(15, 23, 42, 0.9) 100%);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .select-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .select-card-title {
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .select-card-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .preferred-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-group {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .date-input-wrap {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .text-input-field {
            flex: 1;
            background: var(--bg-card-inner);
            border: 1.5px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 16px;
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .text-input-field:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 16px var(--accent-glow);
        }

        .date-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .date-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .date-chip:hover {
            border-color: var(--accent-cyan);
            color: #ffffff;
            background: rgba(56, 189, 248, 0.1);
        }

        .tone-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }

        .mode-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 14px;
            margin-top: 12px;
        }

        /* Step 4: Stars */
        .stars-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 12px;
            align-items: center;
        }

        .star-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid var(--border-subtle);
            border-radius: 999px;
            padding: 8px 16px 8px 10px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            color: var(--text-muted);
        }

        .star-item:hover {
            border-color: var(--accent-cyan);
            background: rgba(56, 189, 248, 0.1);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .star-item.active {
            border-color: var(--accent-brand);
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.28) 0%, rgba(190, 18, 60, 0.15) 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 0 18px var(--accent-glow);
        }

        .star-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            background: #1e293b;
            flex-shrink: 0;
        }

        /* Wizard Bottom Actions */
        .wizard-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-wizard-prev {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-wizard-prev:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .btn-wizard-next {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 12px 26px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px var(--accent-glow);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .btn-wizard-next:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(225, 29, 72, 0.6);
        }

        .btn-launch-final {
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 50%, #38bdf8 100%);
            background-size: 200% 200%;
            border: none;
            color: #ffffff;
            padding: 14px 34px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 0 25px var(--accent-glow);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            transition: all 0.3s ease;
            animation: pulseGlow 3s infinite;
        }

        .btn-launch-final:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 0 35px rgba(225, 29, 72, 0.8);
        }

        .btn-launch-final:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            animation: none;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 20px rgba(225, 29, 72, 0.4); }
            50% { box-shadow: 0 0 32px rgba(225, 29, 72, 0.7), 0 0 20px rgba(56, 189, 248, 0.4); }
            100% { box-shadow: 0 0 20px rgba(225, 29, 72, 0.4); }
        }

        .summary-bar {
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 12px 18px;
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .summary-pill {
            font-size: 11px;
            font-family: var(--font-mono);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-subtle);
            padding: 4px 10px;
            border-radius: 6px;
            color: #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Progress Modal */
        .progress-box {
            display: none;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-focus);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 32px;
            text-align: center;
            box-shadow: 0 0 40px var(--accent-glow);
            animation: paneEnter 0.3s ease;
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
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .progress-subtext {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Studio Empty State (Clean view before campaign generation) */
        .studio-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 42px 28px;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(16px);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .studio-empty-state:hover {
            border-color: rgba(225, 29, 72, 0.3);
            background: rgba(15, 23, 42, 0.55);
        }

        .empty-sparkle-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent-brand);
            background: rgba(225, 29, 72, 0.12);
            border: 1px solid rgba(225, 29, 72, 0.3);
            padding: 5px 14px;
            border-radius: 9999px;
            margin-bottom: 14px;
        }

        .empty-state-headline {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .empty-state-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            max-width: 580px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .empty-state-sub strong {
            color: var(--text-main);
        }

        .btn-empty-browse {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 9px 18px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-empty-browse:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Active Campaign Toolbar */
        .active-campaign-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 12px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .active-toolbar-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
        }

        .active-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 10px var(--accent-green);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .btn-toolbar-clear {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 6px 12px;
            color: #fca5a5;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-toolbar-clear:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ffffff;
            border-color: rgba(239, 68, 68, 0.5);
        }

        .btn-toolbar-studio {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #e50914 0%, #b20710 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 7px 14px;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 0 16px rgba(229, 9, 20, 0.4);
        }

        .btn-toolbar-studio:hover {
            transform: translateY(-1px);
            box-shadow: 0 0 24px rgba(229, 9, 20, 0.6);
            color: #ffffff;
        }

        .btn-toolbar-projects {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 7px 14px;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-toolbar-projects:hover {
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.4);
            color: #ffffff;
        }

        .cluster-card.highlight-new {
            animation: highlightNewCard 3s ease forwards;
            border-color: rgba(16, 185, 129, 0.8) !important;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.3) !important;
        }

        @keyframes highlightNewCard {
            0% { transform: scale(0.96); opacity: 0; box-shadow: 0 0 40px rgba(16, 185, 129, 0.6); }
            50% { transform: scale(1.01); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .triad-sched-pill {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            backdrop-filter: blur(8px);
            z-index: 2;
            letter-spacing: -0.2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        .triad-sched-pill.published {
            background: rgba(16, 185, 129, 0.88);
            color: #ffffff;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.5);
        }

        .triad-sched-pill.scheduled {
            background: rgba(14, 165, 233, 0.88);
            color: #ffffff;
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.5);
        }

        .triad-sched-pill.unscheduled {
            background: rgba(15, 23, 42, 0.8);
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .cluster-meta-chip.publish-chip.published {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.5);
            color: #34d399;
            font-weight: 700;
        }

        .cluster-meta-chip.publish-chip.scheduled {
            background: rgba(56, 189, 248, 0.2);
            border-color: rgba(56, 189, 248, 0.5);
            color: #38bdf8;
            font-weight: 700;
        }

        .schedule-pill-mini {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .schedule-pill-mini.published {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.5);
            color: #34d399;
        }

        .schedule-pill-mini.scheduled {
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.5);
            color: #38bdf8;
        }

        .schedule-pill-mini.unscheduled {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--text-muted);
        }

        /* 3-Platform Output Grid */
        .campaign-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 48px;
        }

        @media (max-width: 1024px) {
            .campaign-grid {
                grid-template-columns: 1fr;
            }
        }

        .platform-card {
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

        .platform-card:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6);
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
            color: var(--accent-cyan);
            font-size: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
        }

        .btn-copy:hover {
            text-decoration: underline;
        }

        .text-box {
            background: var(--bg-card-inner);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            line-height: 1.6;
            color: #e2e8f0;
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 220px;
            overflow-y: auto;
        }

        .hashtags-box {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .hashtag-item {
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            color: #38bdf8;
            font-size: 11px;
            font-family: var(--font-mono);
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* ONGOING PROJECTS CLUSTER VIEW STYLES */
        .projects-dashboard {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .cluster-filter-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 22px 26px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .filter-row-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-input-wrap {
            flex: 1;
            min-width: 280px;
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--text-dim);
            pointer-events: none;
        }

        .search-input-field {
            width: 100%;
            background: var(--bg-card-inner);
            border: 1.5px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 16px 12px 42px;
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .search-input-field:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 16px var(--accent-glow);
        }

        .filter-tags-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-tag-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .filter-tag-chip:hover {
            border-color: var(--accent-cyan);
            color: #ffffff;
            background: rgba(56, 189, 248, 0.08);
        }

        .filter-tag-chip.active {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.25) 0%, rgba(190, 18, 60, 0.15) 100%);
            border-color: var(--accent-brand);
            color: #ffffff;
            font-weight: 700;
        }

        /* Cluster Grid Cards */
        .clusters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
            gap: 24px;
        }

        @media (max-width: 768px) {
            .clusters-grid {
                grid-template-columns: 1fr;
            }
        }

        .cluster-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1.5px solid var(--border-subtle);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .cluster-card:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.6);
        }

        .cluster-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .cluster-title {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.4;
        }

        .cluster-meta-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px;
        }

        .cluster-meta-chip {
            font-size: 10px;
            font-family: var(--font-mono);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            padding: 2px 7px;
            border-radius: 5px;
            color: var(--text-muted);
        }

        .cluster-meta-chip.highlight {
            color: #38bdf8;
            border-color: rgba(56, 189, 248, 0.3);
            background: rgba(56, 189, 248, 0.08);
        }

        /* 3-Image Triad in Cluster Card */
        .cluster-triad {
            display: grid;
            grid-template-columns: 1fr 1.6fr;
            grid-template-rows: 1fr 1fr;
            gap: 8px;
            background: #020617;
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            overflow: hidden;
            padding: 8px;
            height: 190px;
        }

        .triad-ig {
            grid-row: span 2;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            background: #0f172a;
        }

        .triad-yt, .triad-x {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            background: #0f172a;
        }

        .triad-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .cluster-card:hover .triad-img {
            transform: scale(1.05);
        }

        .triad-tag {
            position: absolute;
            bottom: 4px;
            left: 4px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            font-size: 9px;
            font-family: var(--font-mono);
            color: #ffffff;
            padding: 1px 5px;
            border-radius: 4px;
        }

        .cluster-brief-text {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
            background: rgba(0, 0, 0, 0.25);
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            max-height: 70px;
            overflow-y: auto;
        }

        .cluster-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            gap: 8px;
        }

        .btn-cluster-open {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.2) 0%, rgba(190, 18, 60, 0.2) 100%);
            border: 1px solid var(--accent-brand);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-cluster-open:hover {
            background: var(--accent-brand);
            box-shadow: 0 0 14px var(--accent-glow);
            transform: translateY(-1px);
        }

        .btn-cluster-delete {
            background: transparent;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-cluster-delete:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
        }

        /* Empty state */
        .empty-cluster-box {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-card);
            border: 1.5px dashed var(--border-subtle);
            border-radius: 20px;
            color: var(--text-muted);
        }

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
                <a href="{{ route('campaign.index') }}" class="brand-link" title="Hoichoi Social Studio">
                    <img src="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}" alt="Hoichoi" class="brand-hoichoi-svg">
                </a>
                <div class="brand-divider"></div>
                <div class="brand-text">
                    <h1>
                        <span>Social Studio</span>
                        <span class="brand-pill-pro">Creative Engine</span>
                    </h1>
                    <p>One Brief → Multi-Platform Campaign Package</p>
                </div>
            </div>

            <!-- View Switcher (Studio Wizard vs Ongoing Projects) -->
            <div class="view-switcher">
                <button type="button" class="view-switch-btn active" id="btnViewStudio" onclick="switchView('studio')">
                    <span>⚡</span>
                    <span>Studio Wizard</span>
                </button>
                <button type="button" class="view-switch-btn" id="btnViewProjects" onclick="switchView('projects')">
                    <span>📂</span>
                    <span>Ongoing Projects</span>
                    <span class="count-pill" id="ongoingBadge">{{ count($campaigns) }}</span>
                </button>
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

                <div class="user-profile-badge">
                    <div class="user-avatar-circle">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-profile-info">
                        <span class="user-profile-name">{{ auth()->user()->name }}</span>
                        <span class="user-profile-email">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <span>🚪</span>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- ========================================== -->
        <!-- VIEW 1: STUDIO WIZARD                      -->
        <!-- ========================================== -->
        <div class="view-section active" id="viewStudioSection">

            <!-- Social Generator Center Wizard Card -->
            <section class="studio-card">

                <!-- Stepper Progress & Tab Bar -->
                <div class="stepper-container">
                    <div class="stepper-progress-track">
                        <div class="stepper-progress-fill" id="stepperFill" style="width: 25%;"></div>
                    </div>

                    <div class="stepper-tabs">
                        <button type="button" class="step-tab active" id="tabStep1" onclick="goToStep(1)">
                            <span class="step-num" id="numStep1">1</span>
                            <div class="step-text">
                                <span class="step-tag">Step 1</span>
                                <span class="step-name">Campaign Brief</span>
                            </div>
                        </button>
                        <button type="button" class="step-tab" id="tabStep2" onclick="goToStep(2)">
                            <span class="step-num" id="numStep2">2</span>
                            <div class="step-text">
                                <span class="step-tag">Step 2</span>
                                <span class="step-name">Language & Date</span>
                            </div>
                        </button>
                        <button type="button" class="step-tab" id="tabStep3" onclick="goToStep(3)">
                            <span class="step-num" id="numStep3">3</span>
                            <div class="step-text">
                                <span class="step-tag">Step 3</span>
                                <span class="step-name">Tone & Framing</span>
                            </div>
                        </button>
                        <button type="button" class="step-tab" id="tabStep4" onclick="goToStep(4)">
                            <span class="step-num" id="numStep4">4</span>
                            <div class="step-text">
                                <span class="step-tag">Step 4</span>
                                <span class="step-name">Star Persona</span>
                            </div>
                        </button>
                    </div>
                </div>

                <form id="campaignForm" onsubmit="generateCampaign(event)">
                    <!-- Hidden state inputs -->
                    <input type="hidden" id="selectedLanguage" value="english">
                    <input type="hidden" id="selectedTone" value="Dark & Mysterious (Thriller)">
                    <input type="hidden" id="selectedImageMode" value="unified">
                    <input type="hidden" id="selectedActor" value="">

                    <!-- STEP 1: Campaign Brief / Prompt -->
                    <div class="wizard-pane active" id="paneStep1">
                        <div class="pane-header">
                            <div class="pane-title">
                                <span>📝</span>
                                <span>Enter Campaign Brief</span>
                            </div>
                            <div class="pane-subtitle">Enter your show premise, raw idea, key message, or promo announcement.</div>
                        </div>

                        <textarea
                            id="briefInput"
                            name="brief"
                            class="brief-textarea"
                            placeholder="Enter show premise, raw idea, key message, or promo announcement..."
                            required
                        ></textarea>

                        <div class="brief-presets">
                            <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Sample Briefs:</span>
                            <button type="button" class="preset-chip" onclick="setBrief('Womans dance on 25 oct in kolkata')">
                                💃 Woman's Dance on 25 Oct
                            </button>
                            <button type="button" class="preset-chip" onclick="setBrief('Byomkesh S9, dark & mysterious, from 10 Oct')">
                                🔍 Byomkesh S9 (Dark Thriller)
                            </button>
                            <button type="button" class="preset-chip" onclick="setBrief('Feludar Goyendagiri Season 3, snowy mountains adventure in Darjeeling, releasing 25th Dec')">
                                🏔️ Feludar Goyendagiri (Winter Thriller)
                            </button>
                            <button type="button" class="preset-chip" onclick="setBrief('Mandaar Season 2, intense crime drama and betrayal by the sea, streaming now on Hoichoi')">
                                🌊 Mandaar S2 (Crime Drama)
                            </button>
                        </div>

                        <div class="wizard-actions">
                            <span style="font-size: 12px; color: var(--text-dim);">Press Ctrl + Enter to continue</span>
                            <button type="button" class="btn-wizard-next" onclick="goToStep(2)">
                                <span>Continue to Language & Date</span>
                                <span>→</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Language Style & Publish Date -->
                    <div class="wizard-pane" id="paneStep2">
                        <div class="pane-header">
                            <div class="pane-title">
                                <span>🌐</span>
                                <span>Choose Language & Release Timing</span>
                            </div>
                            <div class="pane-subtitle">Tailor the voice for your audience, with English set as preferred.</div>
                        </div>

                        <label class="input-label">Select Copywriting Language Style</label>
                        <div class="grid-cards">
                            <!-- English (Preferred) -->
                            <div class="select-card active" id="langCardEnglish" onclick="selectLanguage('english', this)">
                                <div class="select-card-header">
                                    <div class="select-card-title">
                                        <span>🇬🇧</span>
                                        <span>English</span>
                                    </div>
                                    <span class="preferred-badge">Preferred</span>
                                </div>
                                <div class="select-card-desc">High-impact, crisp international copy for Indian metros & global diaspora.</div>
                            </div>

                            <!-- Bilingual -->
                            <div class="select-card" id="langCardBilingual" onclick="selectLanguage('bilingual', this)">
                                <div class="select-card-header">
                                    <div class="select-card-title">
                                        <span>🗣️</span>
                                        <span>Bilingual (বাংলিশ)</span>
                                    </div>
                                </div>
                                <div class="select-card-desc">High engagement mix of catchy Bengali & English hook copy.</div>
                            </div>

                            <!-- Pure Bengali -->
                            <div class="select-card" id="langCardBengali" onclick="selectLanguage('bengali', this)">
                                <div class="select-card-header">
                                    <div class="select-card-title">
                                        <span>Pure Bengali (খাঁটি বাংলা)</span>
                                    </div>
                                </div>
                                <div class="select-card-desc">Authentic cultural expressions & Bengali storytelling.</div>
                            </div>
                        </div>

                        <!-- Publish / Release Date -->
                        <div class="input-group">
                            <label class="input-label" for="publishDateInput">
                                <span>📅</span>
                                <span>Publish / Premiere Date (Optional)</span>
                            </label>
                            <div class="date-input-wrap">
                                <input
                                    type="text"
                                    id="publishDateInput"
                                    class="text-input-field"
                                    placeholder="e.g. 25 Oct, Streaming Now, Coming Soon..."
                                    value=""
                                    oninput="updateSummary()"
                                >
                            </div>
                            <div class="date-chips">
                                <span style="font-size: 11px; color: var(--text-dim); align-self: center;">Quick Picks:</span>
                                <button type="button" class="date-chip" onclick="setPublishDate('25 Oct')">🗓️ 25 Oct</button>
                                <button type="button" class="date-chip" onclick="setPublishDate('Streaming Now')">🚀 Streaming Now</button>
                                <button type="button" class="date-chip" onclick="setPublishDate('This Friday')">🔥 This Friday</button>
                                <button type="button" class="date-chip" onclick="setPublishDate('Kali Puja Premiere')">🏮 Kali Puja Premiere</button>
                                <button type="button" class="date-chip" onclick="setPublishDate('Coming Soon')">✨ Coming Soon</button>
                            </div>
                        </div>

                        <!-- Schedule Auto-Publish Time -->
                        <div class="input-group">
                            <label class="input-label" for="wizardScheduledAtInput">
                                <span>⏰</span>
                                <span>Schedule Auto-Publish Time (Optional)</span>
                            </label>
                            <div class="date-input-wrap">
                                <input
                                    type="datetime-local"
                                    id="wizardScheduledAtInput"
                                    class="text-input-field"
                                    style="color-scheme: dark;"
                                    oninput="updateSummary()"
                                >
                            </div>
                            <div class="date-chips">
                                <span style="font-size: 11px; color: var(--text-dim); align-self: center;">Quick Presets:</span>
                                <button type="button" class="date-chip" onclick="setWizardSchedule('now')">⚡ Publish Immediately</button>
                                <button type="button" class="date-chip" onclick="setWizardSchedule('+1hour')">⏳ In 1 Hour</button>
                                <button type="button" class="date-chip" onclick="setWizardSchedule('+3hours')">⏳ In 3 Hours</button>
                                <button type="button" class="date-chip" onclick="setWizardSchedule('tomorrow_9am')">🌅 Tomorrow 9 AM</button>
                                <button type="button" class="date-chip" onclick="setWizardSchedule('clear')">✕ Clear</button>
                            </div>
                        </div>

                        <div class="wizard-actions">
                            <button type="button" class="btn-wizard-prev" onclick="goToStep(1)">
                                <span>←</span>
                                <span>Back</span>
                            </button>
                            <button type="button" class="btn-wizard-next" onclick="goToStep(3)">
                                <span>Continue to Tone & Framing</span>
                                <span>→</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Tone & Visual Composition Mode -->
                    <div class="wizard-pane" id="paneStep3">
                        <div class="pane-header">
                            <div class="pane-title">
                                <span>🎨</span>
                                <span>Creative Tone & Visual Composition</span>
                            </div>
                            <div class="pane-subtitle">Choose the mood and decide whether to unify the visual across all 3 platforms.</div>
                        </div>

                        <label class="input-label">Campaign Creative Tone</label>
                        <div class="tone-grid">
                            <div class="select-card active" onclick="selectTone('Dark & Mysterious (Thriller)', this)">
                                <div class="select-card-title"><span>🕵️</span> <span>Dark & Mysterious</span></div>
                                <div class="select-card-desc">Suspense, atmospheric shadows & investigative tension.</div>
                            </div>

                            <div class="select-card" onclick="selectTone('Grand Festival Premiere', this)">
                                <div class="select-card-title"><span>🏮</span> <span>Grand Festival</span></div>
                                <div class="select-card-desc">Festive celebrations, high glamour & premiere energy.</div>
                            </div>

                            <div class="select-card" onclick="selectTone('High-Octane Action', this)">
                                <div class="select-card-title"><span>💥</span> <span>High-Octane Action</span></div>
                                <div class="select-card-desc">Fast adrenaline, crime-thriller intensity & impact.</div>
                            </div>

                            <div class="select-card" onclick="selectTone('Emotional & Nostalgic', this)">
                                <div class="select-card-title"><span>💔</span> <span>Emotional & Drama</span></div>
                                <div class="select-card-desc">Deep character drama, romantic longing & classic nostalgia.</div>
                            </div>
                        </div>

                        <div class="input-group" style="margin-top: 24px;">
                            <label class="input-label">Visual Composition Mode</label>
                            <div class="mode-grid">
                                <!-- Unified Mode -->
                                <div class="select-card active" id="modeCardUnified" onclick="selectImageMode('unified', this)">
                                    <div class="select-card-header">
                                        <div class="select-card-title">
                                            <span>🎯</span>
                                            <span>Same Picture in 3 Ratios</span>
                                        </div>
                                        <span class="preferred-badge">Uniform Branding</span>
                                    </div>
                                    <div class="select-card-desc">
                                        Generates 1 master cinematic poster and auto-formats it to <strong>1:1 Square (Instagram)</strong> and <strong>16:9 Landscape (YouTube & X)</strong>. Identical actor, lighting & styling!
                                    </div>
                                </div>

                                <!-- Distinct Mode — Disabled (token quota) -->
                                <div class="select-card select-card-disabled" id="modeCardDistinct" title="Unavailable — token quota reached" style="opacity:0.45;cursor:not-allowed;pointer-events:none;position:relative;">
                                    <div class="select-card-header">
                                        <div class="select-card-title">
                                            <span>🎭</span>
                                            <span>3 Distinct Scene Shots</span>
                                        </div>
                                        <span style="font-size:10px;font-weight:700;background:rgba(251,191,36,0.15);color:#fbbf24;border:1px solid rgba(251,191,36,0.35);border-radius:6px;padding:3px 8px;letter-spacing:0.5px;white-space:nowrap;">⚠️ TOKEN LIMIT</span>
                                    </div>
                                    <div class="select-card-desc">
                                        Renders 3 totally separate AI visuals for each platform (different camera angles, lighting & compositions).
                                    </div>
                                    <div style="margin-top:10px;font-size:11px;color:#fbbf24;background:rgba(251,191,36,0.08);border:1px dashed rgba(251,191,36,0.3);border-radius:8px;padding:7px 10px;line-height:1.5;">
                                        🔒 <strong>Temporarily disabled</strong> — available token quota has been reached. This feature will automatically re-enable once tokens are replenished.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-actions">
                            <button type="button" class="btn-wizard-prev" onclick="goToStep(2)">
                                <span>←</span>
                                <span>Back</span>
                            </button>
                            <button type="button" class="btn-wizard-next" onclick="goToStep(4)">
                                <span>Continue to Star Persona</span>
                                <span>→</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: Star / Face Persona & Launch -->
                    <div class="wizard-pane" id="paneStep4">
                        <div class="pane-header">
                            <div class="pane-title">
                                <span>🌟</span>
                                <span>Select Star / Face Persona</span>
                            </div>
                            <div class="pane-subtitle">Pick from your uploaded cast in <code>public/cast/</code> to condition character likeness.</div>
                        </div>

                        <div class="stars-container">
                            <div class="star-item active" onclick="selectStar('', this)">
                                <div class="star-avatar" style="display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.1);font-size:16px;">✨</div>
                                <span>Auto Character</span>
                            </div>

                            @if(!empty($castMembers))
                                @foreach($castMembers as $actor)
                                    <div class="star-item" onclick="selectStar('{{ $actor['name'] }}', this)">
                                        <img src="{{ $actor['image_url'] }}" alt="{{ $actor['name'] }}" class="star-avatar" onerror="this.style.display='none'">
                                        <span>{{ $actor['name'] }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="star-item" onclick="selectStar('Byomkesh Bakshi (Anirban Bhattacharya)', this)">
                                    <div class="star-avatar" style="display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.1);font-size:16px;">🕵️</div>
                                    <span>Byomkesh (Anirban)</span>
                                </div>
                                <div class="star-item" onclick="selectStar('Feluda / Pradosh Mitter (Tota Roy Chowdhury)', this)">
                                    <div class="star-avatar" style="display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.1);font-size:16px;">🔍</div>
                                    <span>Feluda (Tota)</span>
                                </div>
                            @endif
                        </div>

                        <div style="margin-top: 12px; font-size: 11px; color: #38bdf8;">
                            📁 <strong>Tip:</strong> Drop any actor face photo (.jpg, .png) into <code>public/cast/</code> to add more stars automatically!
                        </div>

                        <!-- Live Configuration Summary Bar -->
                        <div class="summary-bar">
                            <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; font-weight: 700;">Package Spec:</span>
                            <span class="summary-pill" id="sumBrief">📝 "Womans dance on 25 oct..."</span>
                            <span class="summary-pill" id="sumLang">🇬🇧 English</span>
                            <span class="summary-pill" id="sumDate">📅 25 Oct</span>
                            <span class="summary-pill" id="sumTone">🕵️ Dark & Mysterious</span>
                            <span class="summary-pill" id="sumMode">🎯 Same Picture (3 Ratios)</span>
                            <span class="summary-pill" id="sumStar">🌟 Auto Character</span>
                            <span class="summary-pill" id="sumSchedule">⏰ Publish: Immediate</span>
                        </div>

                        <div class="wizard-actions">
                            <button type="button" class="btn-wizard-prev" onclick="goToStep(3)">
                                <span>←</span>
                                <span>Back to Tone</span>
                            </button>
                            <button type="submit" id="submitBtn" class="btn-launch-final">
                                <span>✨</span>
                                <span id="submitBtnText">Generate 3-Platform Campaign</span>
                            </button>
                        </div>
                    </div>

                </form>
            </section>

            <!-- Generation Progress Box -->
            <div id="progressBox" class="progress-box">
                <div class="progress-spinner"></div>
                <div id="progressStep" class="progress-step-text">Generating campaign package...</div>
                <div id="progressSub" class="progress-subtext">Creating platform copy & rendering AI visual assets</div>
            </div>

            <!-- Clean Studio Ready State (Displayed when no campaign is actively loaded) -->
            <div id="studioEmptyState" class="studio-empty-state" style="{{ $latestCampaign ? 'display: none;' : '' }}">
                <img src="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}" alt="Hoichoi" class="empty-state-hoichoi-logo">
                <div class="empty-sparkle-pill">✨ STUDIO WORKSPACE</div>
                <h3 class="empty-state-headline">No Active Campaign Generated Yet</h3>
                <p class="empty-state-sub">Complete the 4-step wizard above and click <strong>Generate 3-Platform Campaign</strong> to create Instagram, YouTube, and X creative assets with customized copy and images.</p>
                <button type="button" class="btn-empty-browse" id="btnEmptyBrowse" onclick="switchView('projects')" style="{{ $campaigns->count() > 0 ? '' : 'display: none;' }}">
                    <span>📂</span>
                    <span id="btnEmptyBrowseText">Browse {{ $campaigns->count() }} Ongoing Projects from Database</span>
                </button>
            </div>

            <!-- Active Campaign Results Header (Toolbar when a campaign is generated or loaded) -->
            <div id="activeCampaignToolbar" class="active-campaign-toolbar" style="{{ $latestCampaign ? '' : 'display: none;' }}">
                <div class="active-toolbar-title">
                    <span class="active-dot"></span>
                    <span id="activeCampaignName">{{ $latestCampaign?->title ?? 'Generated Campaign Package' }}</span>
                </div>
                <div class="active-toolbar-actions">
                    <a id="btnActiveOpenStudio" href="{{ $latestCampaign ? route('campaign.show', $latestCampaign->id) : '#' }}" target="_blank" class="btn-toolbar-studio">
                        <span>⚡</span>
                        <span>Open in Studio</span>
                    </a>
                    <button type="button" class="btn-toolbar-projects" onclick="switchView('projects')">
                        <span>📂</span>
                        <span>View in Ongoing Projects</span>
                    </button>
                    <button type="button" class="btn-toolbar-clear" onclick="clearStudioWorkspace()">
                        <span>✕</span>
                        <span>Clear</span>
                    </button>
                </div>
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
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="schedule-pill-mini {{ $latestCampaign?->instagram_status['status'] ?? 'unscheduled' }}" id="igSchedBadge">
                                {{ ($latestCampaign?->instagram_status['status'] ?? '') === 'published' ? '✅ Published' : (($latestCampaign?->instagram_status['status'] ?? '') === 'scheduled' ? '⏳ Scheduled' : '⏱️ Draft') }}
                            </span>
                            <span class="ratio-tag">1:1 Square</span>
                        </div>
                    </div>

                    <div class="platform-image-wrap ratio-1-1">
                        <img id="igImage" src="{{ $latestCampaign?->instagram_image_url ?? '' }}" alt="Instagram Image" class="platform-image">
                        <div class="image-overlay-actions">
                            <a id="igDownload" href="{{ $latestCampaign?->instagram_image_url ?? '#' }}" download="instagram-post.jpg" class="btn-overlay">
                                <span>⬇️</span>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>

                    <div class="platform-body">
                        <div class="content-block">
                            <div class="content-label">
                                <span>Post Caption</span>
                                <button type="button" class="btn-copy" onclick="copyText('igCaptionText')">📋 Copy</button>
                            </div>
                            <div id="igCaptionText" class="text-box" style="min-height: 140px;">{{ $latestCampaign?->instagram_caption }}</div>
                        </div>

                        <div class="content-block">
                            <div class="content-label">
                                <span>Hashtags</span>
                                <button type="button" class="btn-copy" onclick="copyText('igHashtagsText')">📋 Copy</button>
                            </div>
                            <div id="igHashtagsText" class="hashtags-box">
                                @if ($latestCampaign && is_array($latestCampaign->instagram_hashtags))
                                    @foreach ($latestCampaign->instagram_hashtags as $h)
                                        <span class="hashtag-item">{{ $h }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: YouTube Video (16:9 Thumbnail & Title) -->
                <div class="platform-card">
                    <div class="platform-card-header">
                        <div class="platform-badge yt">
                            <span>▶️</span>
                            <span>YouTube Video</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="schedule-pill-mini {{ $latestCampaign?->youtube_status['status'] ?? 'unscheduled' }}" id="ytSchedBadge">
                                {{ ($latestCampaign?->youtube_status['status'] ?? '') === 'published' ? '✅ Published' : (($latestCampaign?->youtube_status['status'] ?? '') === 'scheduled' ? '⏳ Scheduled' : '⏱️ Draft') }}
                            </span>
                            <span class="ratio-tag">16:9 Thumbnail</span>
                        </div>
                    </div>

                    <div class="platform-image-wrap ratio-16-9">
                        <img id="ytImage" src="{{ $latestCampaign?->youtube_image_url ?? '' }}" alt="YouTube Thumbnail" class="platform-image">
                        <div class="image-overlay-actions">
                            <a id="ytDownload" href="{{ $latestCampaign?->youtube_image_url ?? '#' }}" download="youtube-thumbnail.jpg" class="btn-overlay">
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
                            <div id="ytTitleText" class="text-box" style="font-weight: 700; min-height: 52px;">{{ $latestCampaign?->youtube_title }}</div>
                        </div>

                        <div class="content-block">
                            <div class="content-label">
                                <span>Description</span>
                                <button type="button" class="btn-copy" onclick="copyText('ytDescText')">📋 Copy</button>
                            </div>
                            <div id="ytDescText" class="text-box" style="min-height: 100px;">{{ $latestCampaign?->youtube_description }}</div>
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
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="schedule-pill-mini {{ $latestCampaign?->x_status['status'] ?? 'unscheduled' }}" id="xSchedBadge">
                                {{ ($latestCampaign?->x_status['status'] ?? '') === 'published' ? '✅ Published' : (($latestCampaign?->x_status['status'] ?? '') === 'scheduled' ? '⏳ Scheduled' : '⏱️ Draft') }}
                            </span>
                            <span class="ratio-tag">16:9 Banner</span>
                        </div>
                    </div>

                    <div class="platform-image-wrap ratio-16-9">
                        <img id="xImage" src="{{ $latestCampaign?->x_image_url ?? '' }}" alt="X Feed Image" class="platform-image">
                        <div class="image-overlay-actions">
                            <a id="xDownload" href="{{ $latestCampaign?->x_image_url ?? '#' }}" download="x-post.jpg" class="btn-overlay">
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

        <!-- ========================================== -->
        <!-- VIEW 2: ONGOING PROJECTS CLUSTER VIEW     -->
        <!-- ========================================== -->
        <div class="view-section" id="viewProjectsSection">
            <div class="projects-dashboard">

                <!-- Search & Filter Controls -->
                <div class="cluster-filter-card">
                    <div class="filter-row-top">
                        <div class="search-input-wrap">
                            <span class="search-icon">🔍</span>
                            <input
                                type="text"
                                id="clusterSearchInput"
                                class="search-input-field"
                                placeholder="Search ongoing projects by show title, star, or story keywords..."
                                oninput="filterClusters()"
                            >
                        </div>
                        <button type="button" class="btn-wizard-next" onclick="switchView('studio')" style="margin-left: 0;">
                            <span>+</span>
                            <span>Create New Campaign</span>
                        </button>
                    </div>

                    <!-- Actor & Filter Chips -->
                    <div class="filter-tags-row">
                        <span style="font-size: 11px; color: var(--text-dim); text-transform: uppercase; font-weight: 700;">Filter:</span>
                        <button type="button" class="filter-tag-chip active" id="filterAllProjectsChip" onclick="setClusterFilter('all', this)">All Projects ({{ count($campaigns) }})</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Dev', this)">Dev</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Ishaa', this)">Ishaa</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Jeet', this)">Jeet</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Anirban', this)">Anirban</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Mandar', this)">Mandar</button>
                        <button type="button" class="filter-tag-chip" onclick="setClusterFilter('Byomkesh', this)">Byomkesh</button>
                    </div>
                </div>

                <!-- Clusters Grid -->
                <div class="clusters-grid" id="clustersGrid">
                    @forelse($campaigns as $project)
                        <div class="cluster-card" id="clusterCard{{ $project->id }}" 
                             data-title="{{ strtolower($project->title ?? '') }}"
                             data-brief="{{ strtolower($project->brief ?? '') }}"
                             data-actor="{{ strtolower($project->actor ?? '') }}"
                             data-tone="{{ strtolower($project->tone ?? '') }}">

                            <div class="cluster-header">
                                <div>
                                    <div class="cluster-title">{{ $project->title ?: 'Campaign #' . $project->id }}</div>
                                    <div class="cluster-meta-chips">
                                        @php
                                            $igStatus = $project->instagram_status['status'] ?? 'unscheduled';
                                            $ytStatus = $project->youtube_status['status'] ?? 'unscheduled';
                                            $xStatus = $project->x_status['status'] ?? 'unscheduled';
                                            $publishedCount = ($igStatus === 'published' ? 1 : 0) + ($ytStatus === 'published' ? 1 : 0) + ($xStatus === 'published' ? 1 : 0);
                                            $scheduledCount = ($igStatus === 'scheduled' ? 1 : 0) + ($ytStatus === 'scheduled' ? 1 : 0) + ($xStatus === 'scheduled' ? 1 : 0);
                                        @endphp
                                        @if($publishedCount === 3)
                                            <span class="cluster-meta-chip publish-chip published">✅ All 3 Published</span>
                                        @elseif($publishedCount > 0)
                                            <span class="cluster-meta-chip publish-chip published">✅ {{ $publishedCount }}/3 Published</span>
                                        @elseif($scheduledCount > 0)
                                            <span class="cluster-meta-chip publish-chip scheduled">⏳ {{ $scheduledCount }} Scheduled</span>
                                        @else
                                            <span class="cluster-meta-chip publish-chip unscheduled">📝 Draft</span>
                                        @endif
                                        @if($project->publish_date)
                                            <span class="cluster-meta-chip highlight">📅 {{ $project->publish_date }}</span>
                                        @endif
                                        @if($project->actor)
                                            <span class="cluster-meta-chip">🌟 {{ Str::limit($project->actor, 18) }}</span>
                                        @endif
                                        @if($project->tone)
                                            <span class="cluster-meta-chip">🎨 {{ Str::limit(explode('(', $project->tone)[0], 18) }}</span>
                                        @endif
                                        <span class="cluster-meta-chip">⏱️ {{ $project->created_at?->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3-Image Triad Showcase (Cluster) -->
                            <div class="cluster-triad">
                                <!-- Instagram 1:1 -->
                                <div class="triad-ig">
                                    <img src="{{ $project->instagram_image_url }}" alt="Instagram" class="triad-img" loading="lazy">
                                    <span class="triad-tag">1:1 Square</span>
                                    <span class="triad-sched-pill {{ $igStatus }}">
                                        {{ $igStatus === 'published' ? '✅ Published' : ($igStatus === 'scheduled' ? '⏳ Scheduled' : 'Draft') }}
                                    </span>
                                </div>
                                <!-- YouTube 16:9 -->
                                <div class="triad-yt">
                                    <img src="{{ $project->youtube_image_url }}" alt="YouTube" class="triad-img" loading="lazy">
                                    <span class="triad-tag">16:9 YouTube</span>
                                    <span class="triad-sched-pill {{ $ytStatus }}">
                                        {{ $ytStatus === 'published' ? '✅ Published' : ($ytStatus === 'scheduled' ? '⏳ Scheduled' : 'Draft') }}
                                    </span>
                                </div>
                                <!-- X 16:9 -->
                                <div class="triad-x">
                                    <img src="{{ $project->x_image_url }}" alt="X Twitter" class="triad-img" loading="lazy">
                                    <span class="triad-tag">16:9 X</span>
                                    <span class="triad-sched-pill {{ $xStatus }}">
                                        {{ $xStatus === 'published' ? '✅ Published' : ($xStatus === 'scheduled' ? '⏳ Scheduled' : 'Draft') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Brief & Copy Snippet -->
                            <div class="cluster-brief-text">
                                {{ Str::limit($project->brief, 140) }}
                            </div>

                            <div class="cluster-footer">
                                <a href="{{ route('campaign.show', $project->id) }}" target="_blank" class="btn-cluster-open">
                                    <span>⚡</span>
                                    <span>Open in Studio</span>
                                </a>
                                <button type="button" class="btn-cluster-delete" onclick="deleteProject({{ $project->id }})">
                                    <span>🗑️</span>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-cluster-box" style="grid-column: 1 / -1;">
                            <div style="font-size: 36px; margin-bottom: 12px;">📁</div>
                            <div style="font-size: 16px; font-weight: 700; color: #ffffff;">No Ongoing Projects Found</div>
                            <p style="font-size: 13px; margin-top: 6px;">Create your first campaign in the Studio Wizard above to see it clustered here.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <span>✅</span>
        <span id="toastMsg">Copied to clipboard!</span>
    </div>

    <script>
        let currentStep = 1;
        let activeFilter = 'all';

        // View Switching (Studio vs Ongoing Projects)
        function switchView(viewName) {
            const btnStudio = document.getElementById('btnViewStudio');
            const btnProjects = document.getElementById('btnViewProjects');
            const sectionStudio = document.getElementById('viewStudioSection');
            const sectionProjects = document.getElementById('viewProjectsSection');

            if (viewName === 'projects') {
                btnStudio.classList.remove('active');
                btnProjects.classList.add('active');
                sectionStudio.classList.remove('active');
                sectionProjects.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });

                // Ensure latest projects are synchronized with database
                fetchLatestProjects();
            } else {
                btnProjects.classList.remove('active');
                btnStudio.classList.add('active');
                sectionProjects.classList.remove('active');
                sectionStudio.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Wizard Step Navigation
        function goToStep(step) {
            if (step < 1 || step > 4) return;

            if (currentStep === 1 && step > 1) {
                const brief = document.getElementById('briefInput').value.trim();
                if (!brief) {
                    document.getElementById('briefInput').focus();
                    showToast('Please enter a brief to proceed!');
                    return;
                }
            }

            for (let i = 1; i <= 4; i++) {
                const pane = document.getElementById('paneStep' + i);
                const tab = document.getElementById('tabStep' + i);
                if (pane) pane.classList.remove('active');
                if (tab) {
                    tab.classList.remove('active');
                    if (i < step) tab.classList.add('completed');
                    else tab.classList.remove('completed');
                }
            }

            const targetPane = document.getElementById('paneStep' + step);
            const targetTab = document.getElementById('tabStep' + step);
            if (targetPane) targetPane.classList.add('active');
            if (targetTab) targetTab.classList.add('active');

            const pct = (step / 4) * 100;
            document.getElementById('stepperFill').style.width = pct + '%';

            currentStep = step;
            updateSummary();
        }

        function setBrief(text) {
            document.getElementById('briefInput').value = text;
            updateSummary();
        }

        function selectLanguage(lang, el) {
            document.getElementById('selectedLanguage').value = lang;
            document.querySelectorAll('#paneStep2 .select-card').forEach(c => c.classList.remove('active'));
            if (el) el.classList.add('active');
            updateSummary();
        }

        function setPublishDate(date) {
            document.getElementById('publishDateInput').value = date;
            updateSummary();
        }

        function selectTone(tone, el) {
            document.getElementById('selectedTone').value = tone;
            document.querySelectorAll('#paneStep3 .tone-grid .select-card').forEach(c => c.classList.remove('active'));
            if (el) el.classList.add('active');
            updateSummary();
        }

        function selectImageMode(mode, el) {
            document.getElementById('selectedImageMode').value = mode;
            document.querySelectorAll('#paneStep3 .mode-grid .select-card').forEach(c => c.classList.remove('active'));
            if (el) el.classList.add('active');
            updateSummary();
        }

        function selectStar(starName, el) {
            document.getElementById('selectedActor').value = starName;
            document.querySelectorAll('.star-item').forEach(c => c.classList.remove('active'));
            if (el) el.classList.add('active');
            updateSummary();
        }

        function setWizardSchedule(preset) {
            const input = document.getElementById('wizardScheduledAtInput');
            if (!input) return;
            const now = new Date();

            if (preset === 'clear') {
                input.value = '';
            } else if (preset === 'now') {
                // 1 minute in the past so it triggers "Published"
                const past = new Date(now.getTime() - 60000);
                const yyyy = past.getFullYear();
                const mm = String(past.getMonth() + 1).padStart(2, '0');
                const dd = String(past.getDate()).padStart(2, '0');
                const hh = String(past.getHours()).padStart(2, '0');
                const min = String(past.getMinutes()).padStart(2, '0');
                input.value = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
            } else if (preset === '+1hour') {
                const target = new Date(now.getTime() + 3600000);
                const yyyy = target.getFullYear();
                const mm = String(target.getMonth() + 1).padStart(2, '0');
                const dd = String(target.getDate()).padStart(2, '0');
                const hh = String(target.getHours()).padStart(2, '0');
                const min = String(target.getMinutes()).padStart(2, '0');
                input.value = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
            } else if (preset === '+3hours') {
                const target = new Date(now.getTime() + (3 * 3600000));
                const yyyy = target.getFullYear();
                const mm = String(target.getMonth() + 1).padStart(2, '0');
                const dd = String(target.getDate()).padStart(2, '0');
                const hh = String(target.getHours()).padStart(2, '0');
                const min = String(target.getMinutes()).padStart(2, '0');
                input.value = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
            } else if (preset === 'tomorrow_9am') {
                const target = new Date(now.getTime() + 86400000);
                target.setHours(9, 0, 0, 0);
                const yyyy = target.getFullYear();
                const mm = String(target.getMonth() + 1).padStart(2, '0');
                const dd = String(target.getDate()).padStart(2, '0');
                input.value = `${yyyy}-${mm}-${dd}T09:00`;
            }
            updateSummary();
        }

        function updateSummary() {
            const brief = document.getElementById('briefInput').value.trim() || 'No brief yet';
            const lang = document.getElementById('selectedLanguage').value;
            const date = document.getElementById('publishDateInput').value.trim() || 'Not set';
            const tone = document.getElementById('selectedTone').value;
            const mode = document.getElementById('selectedImageMode').value;
            const star = document.getElementById('selectedActor').value || 'Auto Character';
            const schedVal = document.getElementById('wizardScheduledAtInput')?.value;

            const sumBriefEl = document.getElementById('sumBrief');
            if (sumBriefEl) sumBriefEl.textContent = '📝 "' + brief.substring(0, 24) + (brief.length > 24 ? '...' : '') + '"';

            const sumLangEl = document.getElementById('sumLang');
            if (sumLangEl) sumLangEl.textContent = lang === 'english' ? '🇬🇧 English' : (lang === 'bengali' ? '🇧🇩 Bengali' : '🗣️ Bilingual');

            const sumDateEl = document.getElementById('sumDate');
            if (sumDateEl) sumDateEl.textContent = '📅 ' + date;

            const sumToneEl = document.getElementById('sumTone');
            if (sumToneEl) sumToneEl.textContent = '🎨 ' + tone.split('(')[0].trim();

            const sumModeEl = document.getElementById('sumMode');
            if (sumModeEl) sumModeEl.textContent = mode === 'unified' ? '🎯 Same Picture (3 Ratios)' : '🎭 3 Distinct Shots';

            const sumStarEl = document.getElementById('sumStar');
            if (sumStarEl) sumStarEl.textContent = '🌟 ' + (star ? star.split('(')[0].trim() : 'Auto Character');

            const sumScheduleEl = document.getElementById('sumSchedule');
            if (sumScheduleEl) {
                if (!schedVal) {
                    sumScheduleEl.textContent = '⏰ Publish: Unscheduled';
                } else {
                    const schedTime = new Date(schedVal).getTime();
                    if (Date.now() >= schedTime) {
                        sumScheduleEl.textContent = '✅ Publish: Immediately';
                    } else {
                        const dt = new Date(schedVal);
                        sumScheduleEl.textContent = '⏳ Schedule: ' + dt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ', ' + dt.toLocaleDateString([], { month: 'short', day: 'numeric' });
                    }
                }
            }
        }

        // Keyboard shortcuts
        document.getElementById('briefInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                goToStep(2);
            }
        });

        // Generate Campaign API Call
        async function generateCampaign(e) {
            e.preventDefault();

            const brief = document.getElementById('briefInput').value.trim();
            if (!brief) {
                goToStep(1);
                showToast('Please provide a campaign brief!');
                return;
            }

            const language = document.getElementById('selectedLanguage').value;
            const tone = document.getElementById('selectedTone').value;
            const imageMode = document.getElementById('selectedImageMode').value;
            const actor = document.getElementById('selectedActor').value;
            const publishDate = document.getElementById('publishDateInput').value.trim();
            const scheduledAt = document.getElementById('wizardScheduledAtInput')?.value || null;

            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const progressBox = document.getElementById('progressBox');
            const campaignGrid = document.getElementById('campaignGrid');
            const emptyState = document.getElementById('studioEmptyState');
            const toolbar = document.getElementById('activeCampaignToolbar');

            submitBtn.disabled = true;
            submitBtnText.textContent = 'Creating Campaign...';
            if (emptyState) emptyState.style.display = 'none';
            if (toolbar) toolbar.style.display = 'none';
            progressBox.style.display = 'block';

            const steps = imageMode === 'unified' ? [
                '🧠 Gemini 3 Flash crafting campaign copy in ' + language + '...',
                '📸 Cloudflare FLUX rendering master cinematic poster...',
                '📐 Formatting 1:1 Instagram post & 16:9 YouTube/X thumbnails...',
                '📦 Finalizing unified social media package...'
            ] : [
                '🧠 Gemini 3 Flash crafting platform copy & prompts...',
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
                        actor: actor,
                        publish_date: publishDate,
                        scheduled_at: scheduledAt
                    })
                });

                const res = await response.json();

                if (response.ok && res.success && res.data) {
                    renderCampaign(res.data);
                    if (emptyState) emptyState.style.display = 'none';
                    if (toolbar) {
                        toolbar.style.display = 'flex';
                        const nameEl = document.getElementById('activeCampaignName');
                        if (nameEl) nameEl.textContent = res.data.title || 'Generated Campaign Package';
                    }
                    const btnActiveOpenStudio = document.getElementById('btnActiveOpenStudio');
                    if (btnActiveOpenStudio) {
                        btnActiveOpenStudio.href = '/campaign/' + res.data.id;
                    }
                    campaignGrid.style.display = 'grid';
                    showToast('🎉 Complete Campaign Package Generated!');
                    campaignGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    // Instantly insert into Ongoing Projects cluster grid
                    prependCampaignToClusterGrid(res.data);
                } else {
                    if (emptyState) emptyState.style.display = 'flex';
                    alert(res.message || 'Failed to generate campaign. Please try again.');
                }
            } catch (err) {
                console.error(err);
                if (emptyState) emptyState.style.display = 'flex';
                alert('A network or server error occurred. Please check execution timeout.');
            } finally {
                clearInterval(progressInterval);
                progressBox.style.display = 'none';
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Generate 3-Platform Campaign';
            }
        }

        function clearStudioWorkspace() {
            document.getElementById('campaignGrid').style.display = 'none';
            const tb = document.getElementById('activeCampaignToolbar');
            if (tb) tb.style.display = 'none';
            const empty = document.getElementById('studioEmptyState');
            if (empty) empty.style.display = 'flex';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            showToast('Studio workspace cleared');
        }

        function updateMiniScheduleBadge(badgeEl, statusObj) {
            if (!badgeEl) return;
            badgeEl.className = 'schedule-pill-mini';
            const status = statusObj?.status || 'unscheduled';
            badgeEl.classList.add(status);
            if (status === 'published') {
                badgeEl.textContent = '✅ Published';
            } else if (status === 'scheduled') {
                badgeEl.textContent = '⏳ Scheduled';
            } else {
                badgeEl.textContent = '⏱️ Draft';
            }
        }

        function renderCampaign(data) {
            // Instagram
            if (data.instagram) {
                updateMiniScheduleBadge(document.getElementById('igSchedBadge'), data.instagram.publish_status);
                document.getElementById('igImage').src = data.instagram.image_url || '';
                document.getElementById('igDownload').href = data.instagram.image_url || '#';
                document.getElementById('igCaptionText').textContent = data.instagram.caption || '';
                const igTagsEl = document.getElementById('igHashtagsText');
                igTagsEl.innerHTML = (data.instagram.hashtags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }

            // YouTube
            if (data.youtube) {
                updateMiniScheduleBadge(document.getElementById('ytSchedBadge'), data.youtube.publish_status);
                document.getElementById('ytImage').src = data.youtube.image_url || '';
                document.getElementById('ytDownload').href = data.youtube.image_url || '#';
                document.getElementById('ytTitleText').textContent = data.youtube.title || '';
                document.getElementById('ytDescText').textContent = data.youtube.description || '';
                const ytTagsEl = document.getElementById('ytTagsText');
                ytTagsEl.innerHTML = (data.youtube.tags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }

            // X (Twitter)
            if (data.x) {
                updateMiniScheduleBadge(document.getElementById('xSchedBadge'), data.x.publish_status);
                document.getElementById('xImage').src = data.x.image_url || '';
                document.getElementById('xDownload').href = data.x.image_url || '#';
                document.getElementById('xHookText').textContent = data.x.hook || '';
                const xTagsEl = document.getElementById('xHashtagsText');
                xTagsEl.innerHTML = (data.x.hashtags || []).map(t => `<span class="hashtag-item">${t}</span>`).join(' ');
            }
        }

        // Load an existing Project Cluster into the active studio workspace
        async function loadProjectIntoStudio(id) {
            try {
                const response = await fetch(`/campaign/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const res = await response.json();
                if (res.success && res.data) {
                    renderCampaign(res.data);
                    document.getElementById('briefInput').value = res.data.brief || '';
                    if (res.data.publish_date) {
                        document.getElementById('publishDateInput').value = res.data.publish_date;
                    }

                    // Switch back to Studio view and scroll to results
                    switchView('studio');
                    const emptyState = document.getElementById('studioEmptyState');
                    if (emptyState) emptyState.style.display = 'none';
                    const toolbar = document.getElementById('activeCampaignToolbar');
                    if (toolbar) {
                        toolbar.style.display = 'flex';
                        const nameEl = document.getElementById('activeCampaignName');
                        if (nameEl) nameEl.textContent = res.data.title || 'Loaded Campaign Package';
                    }
                    document.getElementById('campaignGrid').style.display = 'grid';
                    document.getElementById('campaignGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    showToast('Loaded project into Studio!');
                }
            } catch (err) {
                console.error(err);
                showToast('Failed to load project');
            }
        }

        // HTML Escape Helper
        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Build HTML for a Cluster Card
        function buildClusterCardHtml(p, isNewlyCreated = false) {
            const rawTitle = p.title || ('Campaign #' + p.id);
            const safeTitle = escapeHtml(rawTitle);
            const rawBrief = p.brief || '';
            const truncatedBrief = rawBrief.length > 140 ? rawBrief.substring(0, 140) + '...' : rawBrief;
            const safeBrief = escapeHtml(truncatedBrief);

            const safeActor = p.actor ? escapeHtml(p.actor.length > 18 ? p.actor.substring(0, 18) + '...' : p.actor) : '';
            const rawTone = p.tone ? p.tone.split('(')[0].trim() : '';
            const safeTone = rawTone ? escapeHtml(rawTone.length > 18 ? rawTone.substring(0, 18) + '...' : rawTone) : '';

            const getStatus = (item, schedField) => {
                if (item && item.publish_status && item.publish_status.status) {
                    return item.publish_status.status;
                }
                const sched = item?.scheduled_at || schedField;
                if (!sched) return 'unscheduled';
                return Date.now() >= new Date(sched).getTime() ? 'published' : 'scheduled';
            };

            const igStatus = getStatus(p.instagram, p.instagram_scheduled_at);
            const ytStatus = getStatus(p.youtube, p.youtube_scheduled_at);
            const xStatus = getStatus(p.x, p.x_scheduled_at);

            const pubCount = (igStatus === 'published' ? 1 : 0) + (ytStatus === 'published' ? 1 : 0) + (xStatus === 'published' ? 1 : 0);
            const schedCount = (igStatus === 'scheduled' ? 1 : 0) + (ytStatus === 'scheduled' ? 1 : 0) + (xStatus === 'scheduled' ? 1 : 0);

            let publishChip = '';
            if (pubCount === 3) {
                publishChip = `<span class="cluster-meta-chip publish-chip published">✅ All 3 Published</span>`;
            } else if (pubCount > 0) {
                publishChip = `<span class="cluster-meta-chip publish-chip published">✅ ${pubCount}/3 Published</span>`;
            } else if (schedCount > 0) {
                publishChip = `<span class="cluster-meta-chip publish-chip scheduled">⏳ ${schedCount} Scheduled</span>`;
            } else {
                publishChip = `<span class="cluster-meta-chip publish-chip unscheduled">📝 Draft</span>`;
            }

            const getPillLabel = (s) => {
                if (s === 'published') return '✅ Published';
                if (s === 'scheduled') return '⏳ Scheduled';
                return 'Draft';
            };

            const dateChip = p.publish_date ? `<span class="cluster-meta-chip highlight">📅 ${escapeHtml(p.publish_date)}</span>` : '';
            const actorChip = safeActor ? `<span class="cluster-meta-chip">🌟 ${safeActor}</span>` : '';
            const toneChip = safeTone ? `<span class="cluster-meta-chip">🎨 ${safeTone}</span>` : '';
            const timeChip = `<span class="cluster-meta-chip">⏱️ ${escapeHtml(p.created_at_human || 'Just now')}</span>`;
            const newBadge = isNewlyCreated ? `<span class="cluster-meta-chip" style="background: rgba(16, 185, 129, 0.25); border-color: rgba(16, 185, 129, 0.6); color: #34d399; font-weight: 700;">✨ Just Generated</span>` : '';

            const igImg = (p.instagram && p.instagram.image_url) ? p.instagram.image_url : (p.instagram_image_url || '');
            const ytImg = (p.youtube && p.youtube.image_url) ? p.youtube.image_url : (p.youtube_image_url || '');
            const xImg = (p.x && p.x.image_url) ? p.x.image_url : (p.x_image_url || '');

            return `
                <div class="cluster-card ${isNewlyCreated ? 'highlight-new' : ''}" id="clusterCard${p.id}" 
                     data-title="${escapeHtml((p.title || '').toLowerCase())}"
                     data-brief="${escapeHtml((p.brief || '').toLowerCase())}"
                     data-actor="${escapeHtml((p.actor || '').toLowerCase())}"
                     data-tone="${escapeHtml((p.tone || '').toLowerCase())}">

                    <div class="cluster-header">
                        <div>
                            <div class="cluster-title">${safeTitle}</div>
                            <div class="cluster-meta-chips">
                                ${newBadge}
                                ${publishChip}
                                ${dateChip}
                                ${actorChip}
                                ${toneChip}
                                ${timeChip}
                            </div>
                        </div>
                    </div>

                    <!-- 3-Image Triad Showcase (Cluster) -->
                    <div class="cluster-triad">
                        <div class="triad-ig">
                            <img src="${igImg}" alt="Instagram" class="triad-img" loading="lazy">
                            <span class="triad-tag">1:1 Square</span>
                            <span class="triad-sched-pill ${igStatus}">${getPillLabel(igStatus)}</span>
                        </div>
                        <div class="triad-yt">
                            <img src="${ytImg}" alt="YouTube" class="triad-img" loading="lazy">
                            <span class="triad-tag">16:9 YouTube</span>
                            <span class="triad-sched-pill ${ytStatus}">${getPillLabel(ytStatus)}</span>
                        </div>
                        <div class="triad-x">
                            <img src="${xImg}" alt="X Twitter" class="triad-img" loading="lazy">
                            <span class="triad-tag">16:9 X</span>
                            <span class="triad-sched-pill ${xStatus}">${getPillLabel(xStatus)}</span>
                        </div>
                    </div>

                    <div class="cluster-brief-text">
                        ${safeBrief}
                    </div>

                    <div class="cluster-footer">
                        <a href="/campaign/${p.id}" target="_blank" class="btn-cluster-open">
                            <span>⚡</span>
                            <span>Open in Studio</span>
                        </a>
                        <button type="button" class="btn-cluster-delete" onclick="deleteProject(${p.id})">
                            <span>🗑️</span>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            `;
        }

        // Update Project Badges and Counters across the page
        function updateProjectCounts() {
            const cards = document.querySelectorAll('#clustersGrid .cluster-card');
            const totalCount = cards.length;

            const badge = document.getElementById('ongoingBadge');
            if (badge) badge.textContent = totalCount;

            const filterAllBtn = document.getElementById('filterAllProjectsChip');
            if (filterAllBtn) filterAllBtn.textContent = `All Projects (${totalCount})`;

            const emptyBrowseBtn = document.getElementById('btnEmptyBrowse');
            if (emptyBrowseBtn) {
                const textSpan = document.getElementById('btnEmptyBrowseText');
                if (textSpan) {
                    textSpan.textContent = `Browse ${totalCount} Ongoing Projects from Database`;
                }
                emptyBrowseBtn.style.display = totalCount > 0 ? 'inline-flex' : 'none';
            }
        }

        // Instantly prepend freshly generated campaign directly into grid
        function prependCampaignToClusterGrid(project) {
            const grid = document.getElementById('clustersGrid');
            if (!grid) return;

            // Remove empty cluster placeholder if present
            const emptyBox = grid.querySelector('.empty-cluster-box');
            if (emptyBox) {
                emptyBox.remove();
            }

            // Remove existing card if already in DOM
            const existing = document.getElementById('clusterCard' + project.id);
            if (existing) {
                existing.remove();
            }

            const cardHtml = buildClusterCardHtml(project, true);
            grid.insertAdjacentHTML('afterbegin', cardHtml);

            updateProjectCounts();
            filterClusters();
        }

        // Fetch latest projects from database in background
        let isFetchingProjects = false;
        async function fetchLatestProjects() {
            if (isFetchingProjects) return;
            isFetchingProjects = true;
            try {
                const response = await fetch('/?format=json', {
                    headers: { 'Accept': 'application/json' }
                });
                const res = await response.json();
                if (res.success && Array.isArray(res.data)) {
                    syncClusterGridWithData(res.data);
                }
            } catch (e) {
                console.warn('Could not sync latest projects in background', e);
            } finally {
                isFetchingProjects = false;
            }
        }

        // Sync cluster grid with project array without jarring flicker
        function syncClusterGridWithData(projects) {
            const grid = document.getElementById('clustersGrid');
            if (!grid) return;

            if (projects.length === 0) {
                grid.innerHTML = `
                    <div class="empty-cluster-box" style="grid-column: 1 / -1;">
                        <div style="font-size: 36px; margin-bottom: 12px;">📁</div>
                        <div style="font-size: 16px; font-weight: 700; color: #ffffff;">No Ongoing Projects Found</div>
                        <p style="font-size: 13px; margin-top: 6px;">Create your first campaign in the Studio Wizard above to see it clustered here.</p>
                    </div>
                `;
                updateProjectCounts();
                return;
            }

            const existingCards = Array.from(grid.querySelectorAll('.cluster-card'));
            const existingIds = existingCards.map(c => parseInt(c.id.replace('clusterCard', ''))).filter(n => !isNaN(n));
            const newIds = projects.map(p => p.id);

            // If existing cards in order already match the new project IDs, do not rewrite DOM
            if (existingIds.length === newIds.length && existingIds.every((id, idx) => id === newIds[idx])) {
                updateProjectCounts();
                return;
            }

            grid.innerHTML = projects.map(p => {
                const wasHighlighted = document.getElementById('clusterCard' + p.id)?.classList.contains('highlight-new');
                return buildClusterCardHtml(p, wasHighlighted);
            }).join('');

            updateProjectCounts();
            filterClusters();
        }

        // Delete an existing project cluster
        async function deleteProject(id) {
            if (!confirm('Are you sure you want to delete this campaign project?')) return;

            try {
                const response = await fetch(`/campaign/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const res = await response.json();
                if (res.success) {
                    const el = document.getElementById('clusterCard' + id);
                    if (el) {
                        el.style.opacity = '0';
                        el.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            el.remove();
                            updateProjectCounts();
                            const remaining = document.querySelectorAll('#clustersGrid .cluster-card');
                            if (remaining.length === 0) {
                                document.getElementById('clustersGrid').innerHTML = `
                                    <div class="empty-cluster-box" style="grid-column: 1 / -1;">
                                        <div style="font-size: 36px; margin-bottom: 12px;">📁</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #ffffff;">No Ongoing Projects Found</div>
                                        <p style="font-size: 13px; margin-top: 6px;">Create your first campaign in the Studio Wizard above to see it clustered here.</p>
                                    </div>
                                `;
                            }
                        }, 250);
                    }
                    showToast('Project deleted successfully.');
                }
            } catch (err) {
                console.error(err);
                alert('Could not delete project');
            }
        }

        // Filter & Search in Ongoing Projects
        function filterClusters() {
            const query = (document.getElementById('clusterSearchInput').value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('#clustersGrid .cluster-card');

            cards.forEach(card => {
                const title = card.getAttribute('data-title') || '';
                const brief = card.getAttribute('data-brief') || '';
                const actor = card.getAttribute('data-actor') || '';
                const tone = card.getAttribute('data-tone') || '';

                const matchesQuery = !query || title.includes(query) || brief.includes(query) || actor.includes(query) || tone.includes(query);
                const matchesFilter = activeFilter === 'all' || 
                                      actor.includes(activeFilter.toLowerCase()) || 
                                      title.includes(activeFilter.toLowerCase()) || 
                                      brief.includes(activeFilter.toLowerCase());

                if (matchesQuery && matchesFilter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function setClusterFilter(filterKey, el) {
            activeFilter = filterKey;
            document.querySelectorAll('.filter-tag-chip').forEach(c => c.classList.remove('active'));
            if (el) el.classList.add('active');
            filterClusters();
        }

        function copyText(elemId) {
            const el = document.getElementById(elemId);
            if (!el) return;
            const text = el.innerText || el.textContent;
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copied to clipboard!');
            }).catch(() => {
                showToast('Failed to copy');
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            updateSummary();
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('view') === 'projects') {
                switchView('projects');
            }
        });
    </script>
</body>
</html>
