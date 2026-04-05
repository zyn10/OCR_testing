/**
 * OCR Processing Module
 * Handles image optimization and OCR API communication
 */

// Optimize Image
async function optimizeImage(file, maxWidth = 1200, quality = 0.7) {
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

// Process Image for OCR
async function processImage() {
  const currentImage = UIState.getCurrentImage();
  const currentFile = UIState.getCurrentFile();

  if (!currentImage && !currentFile) {
    showError("Please select an image or PDF file first.");
    return;
  }

  // Show loader
  showLoader();
  updateProgress(10);

  try {
    let imageToProcess = currentImage;

    // If it's a file (not URL), optimize it first if it's an image
    if (currentFile && currentFile.type.match("image.*")) {
      updateProgress(30);
      updateLoaderText("Optimizing image for processing...");

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
      updateLoaderText("Processing PDF document...");
      updateProgress(40);
    }

    updateProgress(70);
    updateLoaderText("Extracting text from file...");

    // Send to OCR
    sendToOCR(imageToProcess);
  } catch (error) {
    console.error("File processing error:", error);
    showError("Failed to process file. Please try with a smaller file.");
  }
}

// Update Loader Text
function updateLoaderText(text) {
  const loaderText = document.getElementById("loaderText");
  if (loaderText) {
    loaderText.textContent = text;
  }
}

// Send Image to OCR API using Google Gemini
async function sendToOCR(base64Image) {
  // Show processing status for large images
  if (base64Image && base64Image.length > 500000) {
    updateLoaderText(
      "Processing large image with extensive text... This may take a moment.",
    );
  }

  updateProgress(80);
  updateLoaderText("Extracting text using AI...");

  try {
    const extractedText = await callGeminiAPI(base64Image);
    updateProgress(100);
    hideLoader();
    showResults(extractedText);
  } catch (error) {
    console.error("OCR Error:", error);
    hideLoader();

    if (error.message.includes("API key")) {
      showError(
        "API key not configured. Please contact support or configure Gemini API key.",
      );
    } else if (error.message.includes("BLOCKED")) {
      showError(
        "Image was blocked by safety filters. Please try with a different image.",
      );
    } else if (error.message.includes("No text extracted")) {
      showError(
        "No text found in the image. Please try with a clearer image containing visible text.",
      );
    } else {
      showError(
        "Text extraction failed: " +
          error.message +
          ". Please try again with a different image.",
      );
    }
  }
}
