/**
 * Utility Functions
 * Helper functions for conversions, formatting, and common tasks
 */

// Format file size in bytes to human-readable format
function formatFileSize(bytes) {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}

// Show error using SweetAlert
function showError(message) {
  Swal.fire({
    title: "Error!",
    text: message,
    icon: "error",
    confirmButtonText: "OK",
  });
}

// Validate file type and size
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
    showError("File size too large. Please use files smaller than 10MB.");
    return false;
  }

  if (!allowedTypes.includes(file.type)) {
    showError(
      "Invalid file type. Please use JPG, PNG, GIF, BMP, WebP images or PDF files.",
    );
    return false;
  }

  return true;
}

// Update progress bar
function updateProgress(percent) {
  const progressFill = document.getElementById("progressFill");
  if (progressFill) {
    progressFill.style.width = `${percent}%`;
  }
}

// Get CSRF token from meta tag
function getCSRFToken() {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  return csrfMeta ? csrfMeta.getAttribute("content") : "";
}

// Get OCR API URL from meta tag
function getOCRApiUrl() {
  const apiMeta = document.querySelector('meta[name="ocr-api-url"]');
  return apiMeta ? apiMeta.getAttribute("content") : "/api/ocr";
}

// Get Gemini API Key from meta tag
function getGeminiApiKey() {
  const keyMeta = document.querySelector('meta[name="gemini-api-key"]');
  return keyMeta ? keyMeta.getAttribute("content") : "";
}

// Call Google Gemini Vision API
async function callGeminiAPI(base64Image) {
  try {
    const apiKey = getGeminiApiKey();
    if (!apiKey) {
      throw new Error("Gemini API key not configured");
    }

    const response = await fetch(
      `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          contents: [
            {
              parts: [
                {
                  inlineData: {
                    mimeType: "image/jpeg",
                    data: base64Image.split(",")[1] || base64Image,
                  },
                },
                {
                  text: "Please extract all text visible in this image. Return only the extracted text without any additional commentary.",
                },
              ],
            },
          ],
        }),
      },
    );

    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.error?.message || "Gemini API error");
    }

    const data = await response.json();
    const extractedText = data.candidates?.[0]?.content?.parts?.[0]?.text || "";

    if (!extractedText) {
      throw new Error("No text extracted from image");
    }

    return extractedText;
  } catch (error) {
    console.error("Gemini API Error:", error);
    throw error;
  }
}

// Reload page
window.reloadPage = function () {
  location.reload();
};
