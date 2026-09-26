<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login • Hoichoi Social Studio</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #060913;
            --bg-card: rgba(15, 23, 42, 0.78);
            --border-subtle: rgba(255, 255, 255, 0.1);
            --border-focus: rgba(225, 29, 72, 0.75);
            --accent-brand: #e11d48;
            --accent-hover: #f43f5e;
            --accent-glow: rgba(225, 29, 72, 0.4);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        .ambient-glow-1 {
            position: fixed;
            top: -15%;
            left: 20%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.18) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: fixed;
            bottom: -10%;
            right: 20%;
            width: 750px;
            height: 750px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .login-wrap {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.65), 0 0 40px rgba(225, 29, 72, 0.12);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .hoichoi-logo-img {
            height: 48px;
            width: auto;
            max-width: 200px;
            object-fit: contain;
            filter: drop-shadow(0 0 20px rgba(225, 29, 72, 0.5));
            transition: transform 0.3s ease;
        }

        .hoichoi-logo-img:hover {
            transform: scale(1.04);
        }

        .login-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Demo Credentials Helper Pill */
        .demo-credentials-box {
            background: rgba(225, 29, 72, 0.1);
            border: 1px solid rgba(225, 29, 72, 0.3);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 22px;
        }

        .demo-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .demo-label {
            font-size: 11px;
            font-weight: 800;
            color: #fb7185;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-fill-demo {
            background: rgba(225, 29, 72, 0.25);
            border: 1px solid rgba(225, 29, 72, 0.5);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-fill-demo:hover {
            background: var(--accent-brand);
            transform: translateY(-1px);
        }

        .demo-creds-list {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .demo-cred-row {
            display: flex;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.35);
            padding: 4px 8px;
            border-radius: 6px;
        }

        .demo-cred-key {
            color: var(--text-dim);
        }

        .demo-cred-val {
            color: #38bdf8;
            font-weight: 600;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 7px;
            letter-spacing: 0.2px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            font-size: 15px;
            color: var(--text-dim);
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            background: rgba(8, 14, 27, 0.9);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 12px 14px 12px 42px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.18);
            background: rgba(8, 14, 27, 1);
        }

        .form-input::placeholder {
            color: var(--text-dim);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 12px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            accent-color: var(--accent-brand);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 20px var(--accent-glow);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 26px rgba(225, 29, 72, 0.6);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-alert {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #fca5a5;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-alert {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #6ee7b7;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: var(--text-dim);
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="login-wrap">
        <div class="login-card">

            <div class="login-header">
                <div class="logo-wrap">
                    <img src="{{ asset('logo/header-hoichoi-BX4oEbwk.svg') }}" alt="Hoichoi" class="hoichoi-logo-img">
                </div>
                <h1 class="login-title">Social Studio</h1>
                <p class="login-subtitle">Multi-Platform Campaign Generator & Scheduling Workspace</p>
            </div>

            <!-- Demo Credentials Helper -->
            <div class="demo-credentials-box">
                <div class="demo-top-row">
                    <span class="demo-label">
                        <span>🔐</span>
                        <span>Demo Access Credentials</span>
                    </span>
                    <button type="button" class="btn-fill-demo" onclick="fillDemo()">⚡ Auto-Fill</button>
                </div>
                <div class="demo-creds-list">
                    <div class="demo-cred-row">
                        <span class="demo-cred-key">Email ID:</span>
                        <span class="demo-cred-val">suvo@hoichoi.tv</span>
                    </div>
                    <div class="demo-cred-row">
                        <span class="demo-cred-key">Password:</span>
                        <span class="demo-cred-val">hoichoi</span>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="status-alert">
                    <span>✅</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="error-alert">
                    <span>⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="emailInput">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input 
                            type="email" 
                            id="emailInput" 
                            name="email" 
                            class="form-input" 
                            value="{{ old('email', 'suvo@hoichoi.tv') }}" 
                            placeholder="user@hoichoi.tv"
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="passwordInput">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input 
                            type="password" 
                            id="passwordInput" 
                            name="password" 
                            class="form-input" 
                            value="hoichoi"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" class="remember-checkbox" checked>
                        <span>Stay signed in</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span>Sign In to Studio</span>
                    <span>→</span>
                </button>
            </form>

            <div class="footer-note">
                Hoichoi Social Studio &copy; {{ date('Y') }} • Secured Creative Engine
            </div>

        </div>
    </div>

    <script>
        function fillDemo() {
            document.getElementById('emailInput').value = 'suvo@hoichoi.tv';
            document.getElementById('passwordInput').value = 'hoichoi';
            const btn = document.querySelector('.btn-fill-demo');
            if (btn) {
                btn.textContent = '✓ Filled';
                setTimeout(() => { btn.textContent = '⚡ Auto-Fill'; }, 1500);
            }
        }
    </script>
</body>
</html>
