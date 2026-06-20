<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Meta tags updated with writer's content -->
    <title>Image to Text Converter | Extract Text from Images with OCR</title>
    <meta
      name="description"
      content="Our free image to text converter helps you quickly extract text from your images, scanned documents and PDF files with just a click."
    />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./kk.png" />
    <meta
      name="google-site-verification"
      content="IvYP6t4cF6sKC_bG49PvvYrKZv6NapfyjliCuR_XEJ4"
    />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome Icons -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jsPDF for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
      :root {
        --primary-color: #4361ee;
        --primary-light: #4895ef;
        --secondary-color: #3f37c9;
        --accent-color: #4cc9f0;
        --text-color: #333;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --success-color: #4bb543;
        --warning-color: #ffcc00;
        --error-color: #ff3333;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      html {
        scroll-behavior: smooth;
      }

      body {
        font-family: "Manrope", sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        background-color: #fff;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      /* Navbar */
      .navbar {
        padding: 1rem 0;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
        z-index: 100;
      }

      .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .navbar-brand {
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--primary-color);
        text-decoration: none;
        display: flex;
        align-items: center;
      }

      .navbar-logo {
        height: 40px;
        width: auto;
        margin-right: 10px;
        object-fit: contain;
      }

      .navbar-nav {
        display: flex;
        list-style: none;
      }

      .nav-link {
        font-weight: 500;
        color: var(--text-color);
        margin: 0 0.5rem;
        text-decoration: none;
        transition: var(--transition);
        padding: 0.5rem 1rem;
        border-radius: 6px;
      }

      .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(67, 97, 238, 0.05);
      }

      .nav-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--text-color);
        cursor: pointer;
      }

      /* Hero Section */
      .hero-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #f5f7ff 0%, #e9edff 100%);
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .hero-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 100%;
      }

      .hero-title {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--text-color);
      }

      .hero-subtitle {
        font-size: 1.2rem;
        color: var(--dark-gray);
        margin-bottom: 2rem;
        max-width: 600px;
      }

      /* Card */
      .card-modification {
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
      }

      .card-modification:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
      }

      .card-body {
        padding: 2rem;
      }

      /* Upload Area */
      .upload-area {
        border: 2px dashed var(--medium-gray);
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: white;
        position: relative;
        overflow: hidden;
      }

      .upload-area:hover,
      .upload-area.drag-over {
        border-color: var(--primary-color);
        background-color: rgba(67, 97, 238, 0.03);
      }

      .upload-icon {
        font-size: 3.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
        transition: var(--transition);
      }

      .upload-area:hover .upload-icon {
        transform: scale(1.1);
      }

      .upload-text {
        color: var(--dark-gray);
        margin-bottom: 1.5rem;
        font-weight: 600;
      }

      .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
      }

      .url-field {
        display: flex;
        margin-top: 1.5rem;
        border: 1px solid var(--medium-gray);
        border-radius: 8px;
        overflow: hidden;
      }

      .url-icon {
        padding: 0.75rem 1rem;
        background-color: var(--light-gray);
        color: var(--dark-gray);
      }

      .url-input {
        flex: 1;
        border: none;
        padding: 0.75rem;
        font-family: "Manrope", sans-serif;
      }

      .url-input:focus {
        outline: none;
      }

      /* Buttons */
      .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        color: white;
        cursor: pointer;
        font-family: "Manrope", sans-serif;
      }

      .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
      }

      .btn-primary:disabled {
        background-color: var(--medium-gray);
        box-shadow: none;
        transform: none;
        cursor: not-allowed;
      }

      .btn-outline {
        background-color: transparent;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        font-family: "Manrope", sans-serif;
      }

      .btn-outline:hover {
        background-color: rgba(67, 97, 238, 0.1);
        transform: translateY(-2px);
      }

      .btn-secondary {
        background-color: var(--dark-gray);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        color: white;
        cursor: pointer;
        font-family: "Manrope", sans-serif;
      }

      .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
      }

      /* Preview Section */
      .preview-container {
        text-align: center;
        margin: 2rem 0;
        animation: fadeIn 0.5s ease;
      }

      .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
      }

      /* Results Section */
      .results-container {
        animation: slideUp 0.5s ease;
      }

      .results-textarea {
        width: 100%;
        min-height: 200px;
        border: 1px solid var(--medium-gray);
        border-radius: 8px;
        padding: 1rem;
        font-family: "Manrope", sans-serif;
        resize: vertical;
        margin-bottom: 1.5rem;
        transition: var(--transition);
      }

      .results-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
      }

      .download-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
      }

      /* Loader */
      .loader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
      }

      .loader-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(67, 97, 238, 0.2);
        border-radius: 50%;
        border-top-color: var(--primary-color);
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
      }

      .loader-text {
        color: var(--dark-gray);
        font-weight: 500;
        margin-bottom: 1rem;
      }

      /* Progress Bar */
      .progress-bar {
        width: 100%;
        height: 6px;
        background-color: var(--medium-gray);
        border-radius: 3px;
        margin-top: 1rem;
        overflow: hidden;
        max-width: 300px;
      }

      .progress-fill {
        height: 100%;
        background-color: var(--primary-color);
        width: 0%;
        transition: width 0.3s ease;
      }

      /* File Info */
      .file-info {
        background-color: var(--light-gray);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        text-align: left;
      }

      .file-info p {
        margin: 0.25rem 0;
        font-size: 0.9rem;
        color: var(--dark-gray);
      }

      .file-info .warning {
        color: var(--warning-color);
        font-weight: 600;
      }

      /* Features Section */
      .features-section {
        padding: 5rem 0;
        background-color: var(--light-gray);
      }

      .section-title {
        font-weight: 700;
        font-size: 2rem;
        text-align: center;
        margin-bottom: 3rem;
        color: var(--text-color);
      }

      .section-subtitle {
        text-align: center;
        color: var(--dark-gray);
        margin-bottom: 3rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
      }

      .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
      }

      .feature-card {
        text-align: center;
        padding: 2rem 1rem;
        border-radius: 12px;
        transition: var(--transition);
        background-color: white;
        box-shadow: var(--shadow);
      }

      .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      }

      .feature-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
      }

      .feature-title {
        font-weight: 600;
        margin-bottom: 1rem;
      }

      /* How-to Section */
      .howto-section {
        padding: 5rem 0;
      }

      .howto-steps {
        max-width: 800px;
        margin: 0 auto;
        counter-reset: step-counter;
      }

      .howto-step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--shadow);
      }

      .step-number {
        width: 40px;
        height: 40px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 1.5rem;
        flex-shrink: 0;
      }

      .step-content h4 {
        margin-bottom: 0.5rem;
        color: var(--text-color);
      }

      /* Uses Section */
      .uses-section {
        padding: 5rem 0;
        background-color: var(--light-gray);
      }

      .uses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
      }

      .use-card {
        padding: 2rem;
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--shadow);
      }

      .use-card h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
      }

      .use-card ul {
        list-style-position: inside;
        color: var(--dark-gray);
      }

      .use-card li {
        margin-bottom: 0.5rem;
      }

      /* FAQ Section */
      .faq-section {
        padding: 5rem 0;
      }

      .faq-container {
        max-width: 800px;
        margin: 0 auto;
      }

      .faq-item {
        margin-bottom: 1rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
      }

      .faq-item:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      }

      .faq-question {
        background-color: white;
        padding: 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        transition: var(--transition);
      }

      .faq-question:hover {
        background-color: rgba(67, 97, 238, 0.03);
      }

      .faq-question i {
        transition: var(--transition);
      }

      .faq-answer {
        background-color: white;
        padding: 0 1.5rem;
        max-height: 0;
        overflow: hidden;
        transition: var(--transition);
      }

      .faq-item.active .faq-answer {
        padding: 0 1.5rem 1.5rem;
        max-height: 500px;
      }

      .faq-item.active .faq-question i {
        transform: rotate(180deg);
      }

      /* Footer */
      footer {
        background-color: #1a1d29;
        color: white;
        padding: 4rem 0 0;
      }

      .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
      }

      .footer-heading {
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
      }

      .footer-links {
        list-style: none;
      }

      .footer-links li {
        margin-bottom: 0.75rem;
      }

      .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: var(--transition);
      }

      .footer-links a:hover {
        color: white;
      }

      .social-links {
        display: flex;
        gap: 1rem;
      }

      .social-links a {
        color: white;
        font-size: 1.2rem;
        transition: var(--transition);
      }

      .social-links a:hover {
        color: var(--accent-color);
        transform: translateY(-3px);
      }

      /* Footer Bottom */
      .footer-bottom {
        background-color: #151722;
        padding: 1.5rem 0;
        margin-top: 3rem;
        width: 100%;
      }

      .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: rgba(255, 255, 255, 0.7);
      }

      .footer-bottom-content a {
        color: var(--accent-color);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
      }

      .footer-bottom-content a:hover {
        color: white;
        text-decoration: underline;
      }

      /* Animations */
      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }

      @keyframes slideUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      @keyframes bounce {
        0%,
        20%,
        50%,
        80%,
        100% {
          transform: translateY(0);
        }
        40% {
          transform: translateY(-10px);
        }
        60% {
          transform: translateY(-5px);
        }
      }

      /* Utility Classes */
      .hidden {
        display: none !important;
      }

      .text-center {
        text-align: center;
      }

      .mt-4 {
        margin-top: 2rem;
      }

      .mb-4 {
        margin-bottom: 2rem;
      }

      .d-flex {
        display: flex;
      }

      .justify-center {
        justify-content: center;
      }

      .align-center {
        align-items: center;
      }

      .gap-3 {
        gap: 1rem;
      }

      /* Responsive */
      @media (max-width: 768px) {
        .navbar-nav {
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: white;
          flex-direction: column;
          padding: 1rem;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav.active {
          display: flex;
        }

        .nav-link {
          margin: 0.5rem 0;
          display: block;
        }

        .nav-toggle {
          display: block;
        }

        .hero-title {
          font-size: 2rem;
        }

        .hero-subtitle {
          font-size: 1rem;
        }

        .upload-area {
          padding: 2rem 1rem;
        }

        .section-title {
          font-size: 1.75rem;
        }

        .card-body {
          padding: 1.5rem;
        }

        .download-buttons {
          flex-direction: column;
          align-items: center;
        }

        .download-buttons button {
          width: 100%;
          max-width: 250px;
        }

        .footer-bottom-content {
          flex-direction: column;
          gap: 1rem;
          text-align: center;
        }
      }

      @media (max-width: 480px) {
        .hero-title {
          font-size: 1.75rem;
        }

        .card-body {
          padding: 1rem;
        }

        .btn-primary,
        .btn-outline,
        .btn-secondary {
          padding: 0.6rem 1.2rem;
          font-size: 0.9rem;
        }

        .howto-step {
          flex-direction: column;
          text-align: center;
        }

        .step-number {
          margin-right: 0;
          margin-bottom: 1rem;
        }
      }
    </style>
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="container">
        <div class="navbar-container">
          <a class="navbar-brand" href="#">
            <img src="./Imagetotext.png" alt="" class="navbar-logo" />
          </a>
          <ul class="navbar-nav">
            <li><a class="nav-link" href="#">Home</a></li>
            <li><a class="nav-link" href="#features">Features</a></li>
            <li><a class="nav-link" href="#howto">How to Use</a></li>
            <li><a class="nav-link" href="#uses">Uses</a></li>
            <li><a class="nav-link" href="#faq">FAQ</a></li>
          </ul>
          <button class="nav-toggle">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <div class="hero-container">
          <h1 class="hero-title">
            Image to Text Converter<br />Extract Text from Images with OCR
          </h1>
          <p class="hero-subtitle">
            Extract text from images with just a click using our free tool.
          </p>
          <div class="card-modification">
            <div class="card-body">
              <!-- Upload Area -->
              <div id="uploadArea" class="upload-area">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <h3 class="upload-text">Drag & Drop your image here</h3>
                <p class="text-muted">or click to browse files</p>
                <input
                  type="file"
                  id="fileInput"
                  class="file-input"
                  accept="image/png,image/jpg,image/jpeg,image/*,.pdf"
                />
              </div>

              <!-- File Info -->
              <div id="fileInfo" class="file-info hidden">
                <p><strong>File Information:</strong></p>
                <p id="fileName">Name:</p>
                <p id="fileSize">Size:</p>
                <p id="fileDimensions">Dimensions:</p>
                <p id="optimizationInfo" class="warning"></p>
              </div>

              <!-- URL Input -->
              <div class="url-field">
                <div class="url-icon">
                  <i class="fas fa-link"></i>
                </div>
                <input
                  type="url"
                  id="urlInput"
                  class="url-input"
                  placeholder="Or paste image URL here"
                />
              </div>

              <!-- Action Buttons -->
              <div class="d-flex justify-center gap-3 mt-4">
                <button id="submitBtn" class="btn-primary" disabled>
                  <i class="fas fa-magic"></i> Extract Text
                </button>
                <button id="resetBtn" class="btn-outline">
                  <i class="fas fa-redo"></i> Reset
                </button>
              </div>

              <!-- Preview Section -->
              <div id="previewSection" class="preview-container hidden">
                <img
                  id="imagePreview"
                  class="image-preview"
                  src=""
                  alt="Preview"
                />
                <p>Ready to extract text from this image?</p>
              </div>

              <!-- Loader -->
              <div id="loaderSection" class="loader-container hidden">
                <div class="loader-spinner"></div>
                <p class="loader-text" id="loaderText">
                  Processing your image...
                </p>
                <div class="progress-bar">
                  <div class="progress-fill" id="progressFill"></div>
                </div>
              </div>

              <!-- Results Section -->
              <div id="resultsSection" class="results-container hidden">
                <textarea
                  id="resultsText"
                  class="results-textarea"
                  placeholder="Extracted text will appear here..."
                ></textarea>

                <!-- Download Buttons -->
                <div class="download-buttons">
                  <button id="downloadPdfBtn" class="btn-secondary">
                    <i class="fas fa-file-pdf"></i> Download as PDF
                  </button>
                  <button id="downloadWordBtn" class="btn-secondary">
                    <i class="fas fa-file-word"></i> Download as Word
                  </button>
                  <button id="downloadTxtBtn" class="btn-secondary">
                    <i class="fas fa-file-alt"></i> Download as TXT
                  </button>
                </div>

                <div class="d-flex justify-center gap-3">
                  <button id="copyBtn" class="btn-primary">
                    <i class="fas fa-copy"></i> Copy Text
                  </button>
                  <button id="newExtractionBtn" class="btn-outline">
                    <i class="fas fa-plus"></i> New Extraction
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
      <div class="container">
        <h2 class="section-title">Our Features</h2>
        <p class="section-subtitle">
          Experience powerful OCR technology with these amazing features
        </p>

        <div class="features-grid">
          <div class="feature-card">
            <i class="fas fa-dollar-sign feature-icon"></i>
            <h4 class="feature-title">Free to use</h4>
            <p>
              Our OCR image to text extractor is completely free to use. There
              are no costs associated with signing up and using our tool.
            </p>
          </div>

          <div class="feature-card">
            <i class="fas fa-brain feature-icon"></i>
            <h4 class="feature-title">Smart OCR engine</h4>
            <p>
              The OCR engine used by our tool is smart and intelligent. It can
              accurately extract text from the provided images while making
              little to no errors.
            </p>
          </div>

          <div class="feature-card">
            <i class="fas fa-upload feature-icon"></i>
            <h4 class="feature-title">Multiple input methods</h4>
            <p>
              There are three different ways in which you can input your files
              into our tool. You can either upload the file from your local
              storage, drag and drop it from a source, or use the URL feature to
              fetch the file directly from the internet.
            </p>
          </div>

          <div class="feature-card">
            <i class="fas fa-bolt feature-icon"></i>
            <h4 class="feature-title">Quick results</h4>
            <p>
              Our tool provides a quick functionality. You can get your images
              converted to text in a matter of seconds. You don't have to go
              through long waits and delays with our tool.
            </p>
          </div>

          <div class="feature-card">
            <i class="fas fa-desktop feature-icon"></i>
            <h4 class="feature-title">Easy-to-use interface</h4>
            <p>
              The interface of our tool is very simple and straightforward.
              Everyone can use it without any difficulty.
            </p>
          </div>

          <div class="feature-card">
            <i class="fas fa-mobile-alt feature-icon"></i>
            <h4 class="feature-title">Compatible on all platforms</h4>
            <p>
              You can use our online OCR image to text converter on all platforms,
              whether it is your mobile, computer, tablet, etc. Since our tool
              is browser-based, all you require is a working internet browser
              and a working internet connection.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- How-to Section -->
    <section id="howto" class="howto-section">
      <div class="container">
        <h2 class="section-title">How to Use Our Free Online OCR Converter?</h2>
        <p class="section-subtitle">
          Here is how you can use our online OCR tool to convert your images to
          digital text. The required steps are listed below:
        </p>

        <div class="howto-steps">



           <div class="howto-step">
            <div class="step-number">1</div>
            <div class="step-content">
              <h4>
                Simply go to <a href="https://www.imagetotext.us/">imagetotext.us</a>
              </h4>
              <p>
                Search image to text converter and simply click on our tool for quick conversion.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">1</div>
            <div class="step-content">
              <h4>
                Drag and drop your required image or PDF document on the tool
              </h4>
              <p>
                Simply drag your file and drop it onto the upload area to get
                started.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">2</div>
            <div class="step-content">
              <h4>Click on the input box to upload a file from your device</h4>
              <p>
                Alternatively, click the upload area to browse and select files
                from your computer or mobile device.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">3</div>
            <div class="step-content">
              <h4>Enter a URL to get the file directly from the web</h4>
              <p>
                If your image is already online, simply paste the URL in the
                input field.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">4</div>
            <div class="step-content">
              <h4>Click on the "<b>Submit</b>" button to start the process</h4>
              <p>
                Once you've selected your file, click the Extract Text button to
                begin OCR processing.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">5</div>
            <div class="step-content">
              <h4>Copy the extracted text using the quick "<b>Copy</b>" button</h4>
              <p>
                After processing, copy the extracted text with one click or
                download it in your preferred format.
              </p>
            </div>
          </div>

          <div class="howto-step">
            <div class="step-number">6</div>
            <div class="step-content">
              <h4>Click on "<b>Reload</b>" to refresh the tool and start again</h4>
              <p>Reset the tool to process more images or documents.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- What is OCR Section -->
    <section class="features-section">
      <div class="container">
        <h2 class="section-title">
          What is an Online OCR Translator and How Does it Work?
        </h2>
        <div class="feature-card" style="max-width: 800px; margin: 0 auto">
          <p>
            An <a href="https://www.imagetotext.us/"> online OCR </a> image to text translator is an online tool that helps
            you extract text from an image or a PDF file. The text extracted
            from the image or PDF is presented in the form of digital
            copyable/editable text.
          </p>
          <p style="margin-top: 1rem">
            The technology behind an image-to-text tool is called OCR. It stands
            for Optical Character Recognition, and it essentially analyzes the
            text present inside the images before comparing them to Unicode
            characters stored in a database. By analyzing and comparing the text
            inside the image/PDF file with Unicode characters, OCR is able to
            convert it to digital text.
          </p>
        </div>
      </div>
    </section>

    <!-- Uses Section -->
    <section id="uses" class="uses-section">
      <div class="container">
        <h2 class="section-title">Uses of Our OCR Image to Text Tool</h2>
        <p class="section-subtitle">
          Here are some purposes for which you can use our tool:
        </p>

        <div class="uses-grid">
          <div class="use-card">
            <h4>For students & teachers</h4>
            <p>
              Students and teachers can use our tool for many different
              purposes, such as:
            </p>
            <ul>
              <li>Saving their physical notes in the form of digital files</li>
              <li>Converting their lecture notes to text for easy sharing</li>
              <li>
                Making their study material more accessible and easy to consume
              </li>
            </ul>
            <p style="margin-top: 1rem; font-style: italic">
              Since our tool is completely free, it is especially suitable for
              students.
            </p>
          </div>

          <div class="use-card">
            <h4>For office workers & data entry experts</h4>
            <p>
              Office workers and data entry experts have to deal with large
              amounts of data (much of which is present in the form of images or
              physical documents). Using an image to text converter can help
              them easily organize, compile, and store the data by changing it
              all into digital text. If there are physical documents involved,
              you can simply take a picture of all the required data and then
              put it through our tool.
            </p>
          </div>

          <div class="use-card">
            <h4>For content creators & marketers</h4>
            <p>
              Content creators and marketers can use OCR tools to make their
              tasks easier. As a content creator, you can convert images of
              content to digital text so that you can peruse and edit the data
              easily. As a marketer, image-to-text tools can help you share
              content in more than one format. You can create images for your
              marketing campaign and then convert them to text so that you can
              share both on your marketing channels.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section id="faq" class="faq-section" style="padding: 30px 0">
      <div class="container" style="max-width: 1100px; margin: 0 auto">
        <h2
          class="section-title"
          style="text-align: center; margin-bottom: 30px"
        >
          Frequently Asked Questions
        </h2>

        <!-- Two Column Layout -->
        <div
          style="
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: stretch;
          "
        >
          <!-- LEFT COLUMN: Your existing FAQ content -->
          <div class="faq-container">
            <div class="faq-item">
              <div class="faq-question">
                <span>How does image to text work?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  Image to text conversion works by using a model known as OCR.
                  OCR recognizes the markings and shapes of the text written
                  inside images and then it matches them all with a database of
                  Unicode characters.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span>Which image formats are supported by your tool?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  You can enter image formats, including JPG, PNG, WebP, etc.,
                  into our tool. We also support PDF files.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span>Is OCR accurate?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  Yes, OCR is accurate 95% of the time. However, if you are
                  converting an image containing handwriting, it is advisable to
                  carefully read the output to find and remove typos.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span>Can I use the tool on mobile devices?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  Yes, our tool is fully responsive and works perfectly on all
                  mobile devices, tablets, and desktop computers.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span>Is there a limit to how many images I can process?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  No, there are no limits. You can process as many images as you
                  need completely free of charge.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span>Do you store my images after processing?</span>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <p>
                  No, we do not store your images or extracted text. All
                  processing happens in real-time and files are deleted
                  immediately after processing.
                </p>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN: Image -->
          <div style="width: 90%; height: 100%">
            <img
              src="./ee.png"
              alt="FAQ Illustration"
              style="
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px;
              "
            />
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <!--<section id="faq" class="faq-section">-->
    <!--  <div class="container">-->
    <!--    <h2 class="section-title">Frequently Asked Questions</h2>-->

    <!--    <div class="faq-container">-->
    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>How does image-to-text work?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            Image-to-text conversion works by using a model known as OCR. OCR recognizes the markings and shapes of the text written inside images and then it matches them all with a database of Unicode characters.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>Which image formats are supported by your tool?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            You can enter image formats, including JPG, PNG, WebP, etc., into our tool. We also support PDF files.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>Is OCR accurate?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            Yes, OCR is accurate 95% of the time. However, if you are converting an image containing handwriting, it is advisable to carefully read the output to find and remove typos.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>Can I use the tool on mobile devices?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            Yes, our tool is fully responsive and works perfectly on all mobile devices, tablets, and desktop computers.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>Is there a limit to how many images I can process?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            No, there are no limits. You can process as many images as you need completely free of charge.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="faq-item">-->
    <!--        <div class="faq-question">-->
    <!--          <span>Do you store my images after processing?</span>-->
    <!--          <i class="fas fa-chevron-down"></i>-->
    <!--        </div>-->
    <!--        <div class="faq-answer">-->
    <!--          <p>-->
    <!--            No, we do not store your images or extracted text. All processing happens in real-time and files are deleted immediately after processing.-->
    <!--          </p>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="footer-container">
          <div>
            <img src="./jj.png" alt="" class="navbar-logo" />
            <p>
              Our free image to text converter helps you quickly extract text
              from your images, scanned documents and PDF files with just a
              click.
            </p>
          </div>

          <div>
            <h4 class="footer-heading">Quick Links</h4>
            <ul class="footer-links">
              <li><a href="#">Home</a></li>
              <li><a href="#features">Features</a></li>
              <li><a href="#howto">How to Use</a></li>
              <li><a href="#uses">Uses</a></li>
              <li><a href="#faq">FAQ</a></li>
            </ul>
          </div>

          <div>
            <h4 class="footer-heading">Connect With Us</h4>
            <div class="social-links">
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-github"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div class="container">
          <div class="footer-bottom-content">
            <p>
              &copy; <span id="currentYear">2025</span> ImageToText.us. All
              rights reserved.
            </p>
            <p>
              Made with <i class="fas fa-heart" style="color: #e25555"></i> by
              <a
                href="https://www.linkedin.com/in/muhammad-zain-ahsan/"
                target="_blank"
                rel="noopener"
                >Zain</a
              >
              for Horbax IT Solutions
            </p>
          </div>
        </div>
      </div>
    </footer>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Elements
        const fileInput = document.getElementById("fileInput");
        const urlInput = document.getElementById("urlInput");
        const uploadArea = document.getElementById("uploadArea");
        const previewSection = document.getElementById("previewSection");
        const imagePreview = document.getElementById("imagePreview");
        const loaderSection = document.getElementById("loaderSection");
        const loaderText = document.getElementById("loaderText");
        const progressFill = document.getElementById("progressFill");
        const resultsSection = document.getElementById("resultsSection");
        const resultsText = document.getElementById("resultsText");
        const submitBtn = document.getElementById("submitBtn");
        const resetBtn = document.getElementById("resetBtn");
        const copyBtn = document.getElementById("copyBtn");
        const newExtractionBtn = document.getElementById("newExtractionBtn");
        const downloadPdfBtn = document.getElementById("downloadPdfBtn");
        const downloadWordBtn = document.getElementById("downloadWordBtn");
        const downloadTxtBtn = document.getElementById("downloadTxtBtn");
        const navToggle = document.querySelector(".nav-toggle");
        const navbarNav = document.querySelector(".navbar-nav");
        const faqItems = document.querySelectorAll(".faq-item");
        const currentYearElement = document.getElementById("currentYear");
        const fileInfo = document.getElementById("fileInfo");
        const fileName = document.getElementById("fileName");
        const fileSize = document.getElementById("fileSize");
        const fileDimensions = document.getElementById("fileDimensions");
        const optimizationInfo = document.getElementById("optimizationInfo");

        // Update year automatically
        if (currentYearElement) {
          currentYearElement.textContent = new Date().getFullYear();
        }

        // State
        let currentImage = null;
        let currentFile = null;

        // Event Listeners
        fileInput.addEventListener("change", handleFileSelect);
        urlInput.addEventListener("input", handleUrlInput);
        uploadArea.addEventListener("dragover", handleDragOver);
        uploadArea.addEventListener("dragleave", handleDragLeave);
        uploadArea.addEventListener("drop", handleDrop);
        submitBtn.addEventListener("click", processImage);
        resetBtn.addEventListener("click", resetForm);
        copyBtn.addEventListener("click", copyText);
        newExtractionBtn.addEventListener("click", resetForm);
        downloadPdfBtn.addEventListener("click", downloadAsPDF);
        downloadWordBtn.addEventListener("click", downloadAsWord);
        downloadTxtBtn.addEventListener("click", downloadAsTxt);
        navToggle.addEventListener("click", toggleNav);

        // Listen for paste event
        document.addEventListener("paste", function (e) {
          const clipboardData = e.clipboardData;
          if (clipboardData.items) {
            for (let i = 0; i < clipboardData.items.length; i++) {
              const item = clipboardData.items[i];
              if (item.type.indexOf("image") !== -1) {
                const pastedImage = item.getAsFile();
                handlePastedImage(pastedImage);
              }
            }
          }
        });

        // FAQ functionality
        faqItems.forEach((item) => {
          const question = item.querySelector(".faq-question");
          question.addEventListener("click", () => {
            // Close all other FAQ items
            faqItems.forEach((otherItem) => {
              if (otherItem !== item) {
                otherItem.classList.remove("active");
              }
            });

            // Toggle current item
            item.classList.toggle("active");
          });
        });

        // Functions
        function handleFileSelect(e) {
          const file = e.target.files[0];
          if (
            file &&
            (file.type.match("image.*") || file.type === "application/pdf")
          ) {
            if (validateFile(file)) {
              currentFile = file;
              if (file.type.match("image.*")) {
                displayImage(file);
              } else if (file.type === "application/pdf") {
                displayPDF(file);
              }
            } else {
              fileInput.value = ""; // Clear the invalid file
            }
          }
        }

        function handleUrlInput() {
          const url = urlInput.value.trim();
          if (url) {
            displayImageFromUrl(url);
          }
        }

        function handleDragOver(e) {
          e.preventDefault();
          uploadArea.classList.add("drag-over");
        }

        function handleDragLeave(e) {
          e.preventDefault();
          uploadArea.classList.remove("drag-over");
        }

        function handleDrop(e) {
          e.preventDefault();
          uploadArea.classList.remove("drag-over");
          const files = e.dataTransfer.files;
          if (
            files.length > 0 &&
            (files[0].type.match("image.*") ||
              files[0].type === "application/pdf")
          ) {
            if (validateFile(files[0])) {
              currentFile = files[0];
              if (files[0].type.match("image.*")) {
                displayImage(files[0]);
              } else if (files[0].type === "application/pdf") {
                displayPDF(files[0]);
              }
            }
          }
        }

        function handlePastedImage(pastedImage) {
          if (validateFile(pastedImage)) {
            currentFile = pastedImage;
            displayImage(pastedImage);
          }
        }

        function validateFile(file) {
          const maxSize = 10 * 1024 * 1024; // 10MB
          const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/gif",
            "image/bmp",
            "image/webp",
            "application/pdf",
          ];

          if (file.size > maxSize) {
            showError(
              "File size too large. Please use files smaller than 10MB."
            );
            return false;
          }

          if (!allowedTypes.includes(file.type)) {
            showError(
              "Invalid file type. Please use JPG, PNG, GIF, BMP, WebP images or PDF files."
            );
            return false;
          }

          return true;
        }

        function displayImage(file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            currentImage = e.target.result;
            imagePreview.src = currentImage;
            previewSection.classList.remove("hidden");
            submitBtn.disabled = false;

            // Show file info
            showFileInfo(file);

            // Animate the preview section
            previewSection.style.animation = "none";
            setTimeout(() => {
              previewSection.style.animation = "bounce 0.6s";
            }, 10);
          };
          reader.readAsDataURL(file);
        }

        function displayPDF(file) {
          // For PDF files, show a placeholder image
          currentImage = null;
          imagePreview.src =
            "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 24 24'%3E%3Cpath fill='%234361ee' d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-2 16h-2v-2h2v2zm0-4h-2v-4h2v4zm1-9V3.5L18.5 9H13z'/%3E%3C/svg%3E";
          previewSection.classList.remove("hidden");
          submitBtn.disabled = false;

          // Show file info
          showFileInfo(file);

          // Animate the preview section
          previewSection.style.animation = "none";
          setTimeout(() => {
            previewSection.style.animation = "bounce 0.6s";
          }, 10);
        }

        function displayImageFromUrl(url) {
          currentImage = url;
          imagePreview.src = currentImage;
          previewSection.classList.remove("hidden");
          submitBtn.disabled = true; // Disable until we verify the image loads

          // Hide file info for URLs
          fileInfo.classList.add("hidden");

          // Try to load the image to verify it's valid
          const img = new Image();
          img.onload = function () {
            submitBtn.disabled = false;

            // Animate the preview section
            previewSection.style.animation = "none";
            setTimeout(() => {
              previewSection.style.animation = "bounce 0.6s";
            }, 10);
          };

          img.onerror = function () {
            showError(
              "Failed to load image from URL. Please check the URL and try again."
            );
            resetForm();
          };

          img.src = url;
        }

        function showFileInfo(file) {
          fileName.textContent = `Name: ${file.name}`;
          fileSize.textContent = `Size: ${formatFileSize(file.size)}`;

          if (file.type.match("image.*")) {
            // Get image dimensions
            const img = new Image();
            img.onload = function () {
              fileDimensions.textContent = `Dimensions: ${img.width} × ${img.height}px`;

              // Show optimization info if needed
              if (file.size > 1024 * 1024 || img.width > 2000) {
                optimizationInfo.textContent =
                  "This image will be optimized for better processing.";
              } else {
                optimizationInfo.textContent = "";
              }

              fileInfo.classList.remove("hidden");
            };
            img.src = URL.createObjectURL(file);
          } else {
            fileDimensions.textContent = `Type: PDF Document`;
            optimizationInfo.textContent =
              "PDF files are supported for text extraction.";
            fileInfo.classList.remove("hidden");
          }
        }

        function formatFileSize(bytes) {
          if (bytes === 0) return "0 Bytes";
          const k = 1024;
          const sizes = ["Bytes", "KB", "MB", "GB"];
          const i = Math.floor(Math.log(bytes) / Math.log(k));
          return (
            parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i]
          );
        }

        async function processImage() {
          if (!currentImage && !currentFile) {
            showError("Please select an image or PDF file first.");
            return;
          }

          // Show loader
          previewSection.classList.add("hidden");
          loaderSection.classList.remove("hidden");
          updateProgress(10);

          try {
            let imageToProcess = currentImage;

            // If it's a file (not URL), optimize it first if it's an image
            if (currentFile && currentFile.type.match("image.*")) {
              updateProgress(30);
              loaderText.textContent = "Optimizing image for processing...";

              // Only optimize if file is larger than 1MB or dimensions are too large
              if (currentFile.size > 1024 * 1024) {
                try {
                  imageToProcess = await optimizeImage(currentFile);
                  updateProgress(50);
                } catch (error) {
                  console.error("Image optimization error:", error);
                  // Continue with original image if optimization fails
                }
              }
            } else if (currentFile && currentFile.type === "application/pdf") {
              loaderText.textContent = "Processing PDF document...";
              updateProgress(40);
            }

            updateProgress(70);
            loaderText.textContent = "Extracting text from file...";

            // Use the actual OCR functionality - EXACT SAME AS WORKING CODE
            sendToOCR(imageToProcess);
          } catch (error) {
            console.error("File processing error:", error);
            showError(
              "Failed to process file. Please try with a smaller file."
            );
          }
        }

        function optimizeImage(file, maxWidth = 1200, quality = 0.7) {
          return new Promise((resolve) => {
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");
            const img = new Image();

            img.onload = function () {
              // Calculate new dimensions while maintaining aspect ratio
              let width = img.width;
              let height = img.height;

              if (width > maxWidth) {
                height = (height * maxWidth) / width;
                width = maxWidth;
              }

              canvas.width = width;
              canvas.height = height;

              // Draw and compress image
              ctx.drawImage(img, 0, 0, width, height);

              // Convert to compressed base64
              const optimizedBase64 = canvas.toDataURL("image/jpeg", quality);
              resolve(optimizedBase64);
            };

            img.src = URL.createObjectURL(file);
          });
        }

        function updateProgress(percent) {
          progressFill.style.width = `${percent}%`;
        }

        function sendToOCR(base64Image) {
          const urlValue = urlInput.value;

          // Get CSRF token with fallback
          let csrfToken = "";
          const csrfMeta = document.querySelector('meta[name="csrf-token"]');
          if (csrfMeta) {
            csrfToken = csrfMeta.getAttribute("content");
          }

          // Show processing status for large images
          if (base64Image && base64Image.length > 500000) {
            // ~500KB base64 string
            loaderText.textContent =
              "Processing large image with extensive text... This may take a moment.";
          }

          // Make the OCR API call - EXACT SAME AS WORKING CODE
          const xhr = new XMLHttpRequest();
          xhr.open("POST", "{{route('imagetotext_get_text')}}", true);
          xhr.setRequestHeader(
            "Content-Type",
            "application/json;charset=UTF-8"
          );

          // Add CSRF token if available
          if (csrfToken) {
            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
          }

          // Add timeout for large images
          xhr.timeout = 60000; // 60 seconds timeout

          xhr.ontimeout = function () {
            loaderSection.classList.add("hidden");
            showError(
              "Request timed out. The image might be too large or contain too much text. Please try with a smaller image."
            );
          };

          // Track upload progress
          xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
              const percentComplete = (e.loaded / e.total) * 100;
              updateProgress(70 + percentComplete * 0.3); // 70-100% for upload
            }
          };

          // Prepare data
          const data = {
            image: base64Image,
            url: urlValue,
          };

          // For PDF files, we need to send the file differently
          if (currentFile && currentFile.type === "application/pdf") {
            // We need to handle PDF files differently
            // For now, we'll send a placeholder and rely on backend to handle PDF
            data.file_type = "pdf";
            data.file_name = currentFile.name;
          }

          xhr.send(JSON.stringify(data));

          xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
              loaderSection.classList.add("hidden");

              if (xhr.status === 200) {
                try {
                  const response = JSON.parse(xhr.responseText);
                  if (
                    response.status === "200" ||
                    response.status == 200 ||
                    response.text
                  ) {
                    // Show actual extracted text from API
                    resultsText.value =
                      response.text ||
                      response.extracted_text ||
                      response.result ||
                      "";
                    resultsSection.classList.remove("hidden");

                    // Animate the results section
                    resultsSection.style.animation = "none";
                    setTimeout(() => {
                      resultsSection.style.animation = "bounce 0.6s";
                    }, 10);
                  } else {
                    showError(
                      "OCR processing failed. Please try again with a clearer image."
                    );
                  }
                } catch (error) {
                  console.error("Parse error:", error, xhr.responseText);
                  showError(
                    "Failed to process the response. The extracted text might be too large."
                  );
                }
              } else if (xhr.status === 413) {
                showError(
                  "Image too large. Please use a smaller image or reduce quality."
                );
              } else if (xhr.status === 500) {
                showError(
                  "Server error. The image might be too complex. Please try again."
                );
              } else {
                showError(
                  "Request failed with status " +
                    xhr.status +
                    ". Please try again."
                );
              }
            }
          };
        }

        function showError(message) {
          Swal.fire({
            title: "Error!",
            text: message,
            icon: "error",
            confirmButtonText: "OK",
          });
          resetForm();
        }

        function resetForm() {
          fileInput.value = "";
          urlInput.value = "";
          currentImage = null;
          currentFile = null;
          previewSection.classList.add("hidden");
          loaderSection.classList.add("hidden");
          resultsSection.classList.add("hidden");
          fileInfo.classList.add("hidden");
          submitBtn.disabled = true;
          updateProgress(0);
        }

        function copyText() {
          resultsText.select();
          document.execCommand("copy");

          // Visual feedback
          const originalText = copyBtn.innerHTML;
          copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
          setTimeout(() => {
            copyBtn.innerHTML = originalText;
          }, 2000);
        }

        function downloadAsPDF() {
          const text = resultsText.value;
          if (!text.trim()) {
            showError("No text to download. Please extract text first.");
            return;
          }

          try {
            // Create a new jsPDF instance
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(16);
            doc.text("Extracted Text from Image", 10, 10);

            // Add current date
            doc.setFontSize(10);
            doc.text(
              `Generated on: ${new Date().toLocaleDateString()}`,
              10,
              20
            );

            // Add text
            doc.setFontSize(12);
            const lines = doc.splitTextToSize(text, 180);
            doc.text(lines, 10, 30);

            // Save the PDF
            doc.save("extracted-text.pdf");

            // Visual feedback
            const originalText = downloadPdfBtn.innerHTML;
            downloadPdfBtn.innerHTML =
              '<i class="fas fa-check"></i> Downloaded!';
            downloadPdfBtn.style.backgroundColor = "var(--success-color)";

            setTimeout(() => {
              downloadPdfBtn.innerHTML = originalText;
              downloadPdfBtn.style.backgroundColor = "";
            }, 2000);
          } catch (error) {
            console.error("PDF generation error:", error);
            showError("Failed to generate PDF. Please try again.");
          }
        }

        function downloadAsWord() {
          const text = resultsText.value;
          if (!text.trim()) {
            showError("No text to download. Please extract text first.");
            return;
          }

          try {
            // Create Word document content
            const content = `
              <!DOCTYPE html>
              <html>
              <head>
                <meta charset="UTF-8">
                <title>Extracted Text from Image</title>
                <style>
                  body { font-family: Arial, sans-serif; line-height: 1.5; margin: 20px; }
                  h1 { color: #4361ee; }
                  .date { color: #666; font-size: 0.9em; }
                  .content { margin-top: 20px; white-space: pre-wrap; }
                </style>
              </head>
              <body>
                <h1>Extracted Text from Image</h1>
                <p class="date">Generated on: ${new Date().toLocaleDateString()}</p>
                <hr>
                <div class="content">${text
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/\n/g, "<br>")}</div>
              </body>
              </html>
            `;

            // Create blob and download
            const blob = new Blob([content], { type: "application/msword" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "extracted-text.doc";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            // Visual feedback
            const originalText = downloadWordBtn.innerHTML;
            downloadWordBtn.innerHTML =
              '<i class="fas fa-check"></i> Downloaded!';
            downloadWordBtn.style.backgroundColor = "var(--success-color)";

            setTimeout(() => {
              downloadWordBtn.innerHTML = originalText;
              downloadWordBtn.style.backgroundColor = "";
            }, 2000);
          } catch (error) {
            console.error("Word generation error:", error);
            showError("Failed to generate Word document. Please try again.");
          }
        }

        function downloadAsTxt() {
          const text = resultsText.value;
          if (!text.trim()) {
            showError("No text to download. Please extract text first.");
            return;
          }

          try {
            // Create header with date
            const header = `Extracted Text from Image\nGenerated on: ${new Date().toLocaleDateString()}\n\n`;
            const fullText = header + text;

            // Create blob and download
            const blob = new Blob([fullText], { type: "text/plain" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "extracted-text.txt";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            // Visual feedback
            const originalText = downloadTxtBtn.innerHTML;
            downloadTxtBtn.innerHTML =
              '<i class="fas fa-check"></i> Downloaded!';
            downloadTxtBtn.style.backgroundColor = "var(--success-color)";

            setTimeout(() => {
              downloadTxtBtn.innerHTML = originalText;
              downloadTxtBtn.style.backgroundColor = "";
            }, 2000);
          } catch (error) {
            console.error("TXT generation error:", error);
            showError("Failed to generate text file. Please try again.");
          }
        }

        function toggleNav() {
          navbarNav.classList.toggle("active");
        }

        // Reload page function from original code
        window.reloadPage = function () {
          location.reload();
        };
      });
    </script>
  </body>
</html>
