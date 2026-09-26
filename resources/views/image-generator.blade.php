<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gemini Nano Banana Image Generator</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0b0f19;
            color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 760px;
        }

        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .header p {
            font-size: 14px;
            color: #9ca3af;
        }

        .card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            margin-bottom: 24px;
        }

        .prompt-textarea {
            width: 100%;
            height: 110px;
            background: #0b0f19;
            border: 1px solid #374151;
            border-radius: 12px;
            padding: 14px 16px;
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            line-height: 1.5;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s;
        }

        .prompt-textarea:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 2px rgba(234, 179, 8, 0.15);
        }

        .prompt-textarea::placeholder {
            color: #6b7280;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 14px;
            gap: 12px;
        }

        .btn-generate {
            background: #eab308;
            color: #000000;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-generate:hover:not(:disabled) {
            background: #facc15;
            transform: translateY(-1px);
        }

        .btn-generate:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert-box {
            display: none;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 14px;
            font-size: 13px;
            color: #fca5a5;
        }

        .preview-card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 380px;
            position: relative;
        }

        .placeholder-text {
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }

        .loader-wrap {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            color: #e5e7eb;
            font-size: 14px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(234, 179, 8, 0.2);
            border-top-color: #eab308;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .result-wrap {
            display: none;
            width: 100%;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .result-img {
            max-width: 100%;
            max-height: 540px;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .result-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding-top: 8px;
        }

        .prompt-echo {
            font-size: 13px;
            color: #9ca3af;
            max-width: 80%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-download {
            background: #1f2937;
            color: #f3f4f6;
            border: 1px solid #374151;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-download:hover {
            background: #374151;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><span>🍌</span> Gemini Nano Banana</h1>
            <p>Write your prompt and generate an image</p>
        </div>

        <!-- Prompt Section -->
        <div class="card">
            <form id="imageForm" onsubmit="generateImage(event)">
                <textarea
                    id="prompt"
                    name="prompt"
                    class="prompt-textarea"
                    placeholder="Enter your prompt here (e.g. a boat on a river at sunset, or any language)..."
                    required
                ></textarea>

                <div class="form-footer">
                    <button type="submit" id="generateBtn" class="btn-generate">
                        <span id="btnText">Generate Image</span>
                    </button>
                </div>
            </form>

            <div id="alertBox" class="alert-box"></div>
        </div>

        <!-- Image Result Section -->
        <div class="preview-card">
            <div id="placeholder" class="placeholder-text">
                Your generated image will appear here.
            </div>

            <div id="loader" class="loader-wrap">
                <div class="spinner"></div>
                <span>Generating image with Gemini Nano Banana...</span>
            </div>

            <div id="result" class="result-wrap">
                <img id="generatedImage" src="" alt="Generated image" class="result-img">
                <div class="result-actions">
                    <div id="promptEcho" class="prompt-echo"></div>
                    <a id="downloadLink" href="#" download="generated-image.png" class="btn-download">Download</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function generateImage(e) {
            e.preventDefault();

            const promptInput = document.getElementById('prompt');
            const prompt = promptInput.value.trim();
            if (!prompt) return;

            const btn = document.getElementById('generateBtn');
            const btnText = document.getElementById('btnText');
            const placeholder = document.getElementById('placeholder');
            const loader = document.getElementById('loader');
            const result = document.getElementById('result');
            const alertBox = document.getElementById('alertBox');
            const generatedImage = document.getElementById('generatedImage');
            const promptEcho = document.getElementById('promptEcho');
            const downloadLink = document.getElementById('downloadLink');

            // Reset UI to loading
            alertBox.style.display = 'none';
            alertBox.textContent = '';
            placeholder.style.display = 'none';
            result.style.display = 'none';
            loader.style.display = 'flex';
            btn.disabled = true;
            btnText.textContent = 'Generating...';

            try {
                const response = await fetch('{{ route("image-generator.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ prompt: prompt })
                });

                const data = await response.json();

                if (response.ok && data.success && data.data) {
                    generatedImage.src = data.data.image_url;
                    downloadLink.href = data.data.image_url;
                    promptEcho.textContent = data.data.prompt;
                    result.style.display = 'flex';
                } else {
                    placeholder.style.display = 'block';
                    alertBox.textContent = data.message || 'Failed to generate image. Please check your GEMINI_API_KEY in .env.';
                    alertBox.style.display = 'block';
                }
            } catch (err) {
                console.error(err);
                placeholder.style.display = 'block';
                alertBox.textContent = 'Network or server error occurred while generating image.';
                alertBox.style.display = 'block';
            } finally {
                loader.style.display = 'none';
                btn.disabled = false;
                btnText.textContent = 'Generate Image';
            }
        }
    </script>
</body>
</html>
