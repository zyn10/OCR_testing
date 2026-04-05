/**
 * UI Module
 * Handles DOM state, visibility, and user interface interactions
 */

// UI State
const UIState = {
  currentImage: null,
  currentFile: null,

  setCurrentImage(image) {
    this.currentImage = image;
  },

  setCurrentFile(file) {
    this.currentFile = file;
  },

  getCurrentImage() {
    return this.currentImage;
  },

  getCurrentFile() {
    return this.currentFile;
  },

  reset() {
    this.currentImage = null;
    this.currentFile = null;
  },
};

// Display Image Functions
function displayImage(file) {
  const imagePreview = document.getElementById("imagePreview");
  const previewSection = document.getElementById("previewSection");
  const submitBtn = document.getElementById("submitBtn");
  const fileInfo = document.getElementById("fileInfo");

  const reader = new FileReader();
  reader.onload = function (e) {
    UIState.setCurrentImage(e.target.result);
    imagePreview.src = UIState.getCurrentImage();
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
  const imagePreview = document.getElementById("imagePreview");
  const previewSection = document.getElementById("previewSection");
  const submitBtn = document.getElementById("submitBtn");
  const fileInfo = document.getElementById("fileInfo");

  UIState.setCurrentImage(null);
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
  const imagePreview = document.getElementById("imagePreview");
  const previewSection = document.getElementById("previewSection");
  const submitBtn = document.getElementById("submitBtn");
  const fileInfo = document.getElementById("fileInfo");

  UIState.setCurrentImage(url);
  imagePreview.src = UIState.getCurrentImage();
  previewSection.classList.remove("hidden");
  submitBtn.disabled = true;

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
      "Failed to load image from URL. Please check the URL and try again.",
    );
    resetForm();
  };

  img.src = url;
}

// Show File Information
function showFileInfo(file) {
  const fileName = document.getElementById("fileName");
  const fileSize = document.getElementById("fileSize");
  const fileDimensions = document.getElementById("fileDimensions");
  const optimizationInfo = document.getElementById("optimizationInfo");
  const fileInfo = document.getElementById("fileInfo");

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

// Reset Form
function resetForm() {
  const fileInput = document.getElementById("fileInput");
  const urlInput = document.getElementById("urlInput");
  const previewSection = document.getElementById("previewSection");
  const loaderSection = document.getElementById("loaderSection");
  const resultsSection = document.getElementById("resultsSection");
  const fileInfo = document.getElementById("fileInfo");
  const submitBtn = document.getElementById("submitBtn");

  fileInput.value = "";
  urlInput.value = "";
  UIState.reset();
  previewSection.classList.add("hidden");
  loaderSection.classList.add("hidden");
  resultsSection.classList.add("hidden");
  fileInfo.classList.add("hidden");
  submitBtn.disabled = true;
  updateProgress(0);
}

// Show/Hide Loader
function showLoader() {
  const previewSection = document.getElementById("previewSection");
  const loaderSection = document.getElementById("loaderSection");
  previewSection.classList.add("hidden");
  loaderSection.classList.remove("hidden");
}

function hideLoader() {
  const loaderSection = document.getElementById("loaderSection");
  loaderSection.classList.add("hidden");
}

// Show Results
function showResults(extractedText) {
  const resultsText = document.getElementById("resultsText");
  const resultsSection = document.getElementById("resultsSection");

  resultsText.value = extractedText;
  resultsSection.classList.remove("hidden");

  // Animate the results section
  resultsSection.style.animation = "none";
  setTimeout(() => {
    resultsSection.style.animation = "bounce 0.6s";
  }, 10);
}
