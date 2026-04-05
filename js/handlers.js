/**
 * Event Handlers Module
 * All event listener setup and handler functions
 */

// File Input Handler
function handleFileSelect(e) {
  const file = e.target.files[0];
  if (file && (file.type.match("image.*") || file.type === "application/pdf")) {
    if (validateFile(file)) {
      UIState.setCurrentFile(file);
      if (file.type.match("image.*")) {
        displayImage(file);
      } else if (file.type === "application/pdf") {
        displayPDF(file);
      }
    } else {
      document.getElementById("fileInput").value = ""; // Clear the invalid file
    }
  }
}

// URL Input Handler
function handleUrlInput() {
  const urlInput = document.getElementById("urlInput");
  const url = urlInput.value.trim();
  if (url) {
    displayImageFromUrl(url);
  }
}

// Drag Over Handler
function handleDragOver(e) {
  e.preventDefault();
  const uploadArea = document.getElementById("uploadArea");
  uploadArea.classList.add("drag-over");
}

// Drag Leave Handler
function handleDragLeave(e) {
  e.preventDefault();
  const uploadArea = document.getElementById("uploadArea");
  uploadArea.classList.remove("drag-over");
}

// Drop Handler
function handleDrop(e) {
  e.preventDefault();
  const uploadArea = document.getElementById("uploadArea");
  uploadArea.classList.remove("drag-over");
  const files = e.dataTransfer.files;
  if (
    files.length > 0 &&
    (files[0].type.match("image.*") || files[0].type === "application/pdf")
  ) {
    if (validateFile(files[0])) {
      UIState.setCurrentFile(files[0]);
      if (files[0].type.match("image.*")) {
        displayImage(files[0]);
      } else if (files[0].type === "application/pdf") {
        displayPDF(files[0]);
      }
    }
  }
}

// Pasted Image Handler
function handlePastedImage(pastedImage) {
  if (validateFile(pastedImage)) {
    UIState.setCurrentFile(pastedImage);
    displayImage(pastedImage);
  }
}

// Toggle Navigation
function toggleNav() {
  const navbarNav = document.querySelector(".navbar-nav");
  navbarNav.classList.toggle("active");
}

// Setup All Event Listeners
function setupEventListeners() {
  const fileInput = document.getElementById("fileInput");
  const urlInput = document.getElementById("urlInput");
  const uploadArea = document.getElementById("uploadArea");
  const submitBtn = document.getElementById("submitBtn");
  const resetBtn = document.getElementById("resetBtn");
  const copyBtn = document.getElementById("copyBtn");
  const newExtractionBtn = document.getElementById("newExtractionBtn");
  const downloadPdfBtn = document.getElementById("downloadPdfBtn");
  const downloadWordBtn = document.getElementById("downloadWordBtn");
  const downloadTxtBtn = document.getElementById("downloadTxtBtn");
  const navToggle = document.querySelector(".nav-toggle");
  const faqItems = document.querySelectorAll(".faq-item");

  // File and URL handlers
  fileInput.addEventListener("change", handleFileSelect);
  urlInput.addEventListener("input", handleUrlInput);

  // Drag and drop handlers
  uploadArea.addEventListener("dragover", handleDragOver);
  uploadArea.addEventListener("dragleave", handleDragLeave);
  uploadArea.addEventListener("drop", handleDrop);

  // Button handlers
  submitBtn.addEventListener("click", processImage);
  resetBtn.addEventListener("click", resetForm);
  copyBtn.addEventListener("click", copyText);
  newExtractionBtn.addEventListener("click", resetForm);
  downloadPdfBtn.addEventListener("click", downloadAsPDF);
  downloadWordBtn.addEventListener("click", downloadAsWord);
  downloadTxtBtn.addEventListener("click", downloadAsTxt);

  // Navigation
  navToggle.addEventListener("click", toggleNav);

  // Paste event listener
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
}
