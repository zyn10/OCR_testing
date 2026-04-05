/**
 * Download Module
 * Handles downloading extracted text in various formats (PDF, Word, TXT)
 */

// Copy extracted text to clipboard
function copyText() {
  const resultsText = document.getElementById("resultsText");
  const copyBtn = document.getElementById("copyBtn");

  resultsText.select();
  document.execCommand("copy");

  // Visual feedback
  const originalText = copyBtn.innerHTML;
  copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
  setTimeout(() => {
    copyBtn.innerHTML = originalText;
  }, 2000);
}

// Download as PDF
function downloadAsPDF() {
  const resultsText = document.getElementById("resultsText");
  const downloadPdfBtn = document.getElementById("downloadPdfBtn");
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
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 10, 20);

    // Add text
    doc.setFontSize(12);
    const lines = doc.splitTextToSize(text, 180);
    doc.text(lines, 10, 30);

    // Save the PDF
    doc.save("extracted-text.pdf");

    // Visual feedback
    const originalText = downloadPdfBtn.innerHTML;
    downloadPdfBtn.innerHTML = '<i class="fas fa-check"></i> Downloaded!';
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

// Download as Word Document
function downloadAsWord() {
  const resultsText = document.getElementById("resultsText");
  const downloadWordBtn = document.getElementById("downloadWordBtn");
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
    downloadWordBtn.innerHTML = '<i class="fas fa-check"></i> Downloaded!';
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

// Download as Text File
function downloadAsTxt() {
  const resultsText = document.getElementById("resultsText");
  const downloadTxtBtn = document.getElementById("downloadTxtBtn");
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
    downloadTxtBtn.innerHTML = '<i class="fas fa-check"></i> Downloaded!';
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
