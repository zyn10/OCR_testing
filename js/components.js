/**
 * Component Loader for Header and Footer
 * This file loads reusable header and footer components immediately
 */

// Load Header Component
async function loadHeader() {
  try {
    const response = await fetch("./components/header.html");
    if (response.ok) {
      const headerHTML = await response.text();
      const headerPlaceholder = document.getElementById("header-placeholder");
      if (headerPlaceholder) {
        headerPlaceholder.innerHTML = headerHTML;
      }
    }
  } catch (error) {
    console.error("Error loading header component:", error);
  }
}

// Load Footer Component
async function loadFooter() {
  try {
    const response = await fetch("./components/footer.html");
    if (response.ok) {
      const footerHTML = await response.text();
      const footerPlaceholder = document.getElementById("footer-placeholder");
      if (footerPlaceholder) {
        footerPlaceholder.innerHTML = footerHTML;
        updateCurrentYear();
      }
    }
  } catch (error) {
    console.error("Error loading footer component:", error);
  }
}

// Initialize Mobile Menu Toggle
function initMobileMenu() {
  const navToggle = document.querySelector(".nav-toggle");
  const navbarNav = document.querySelector(".navbar-nav");

  if (navToggle && navbarNav) {
    navToggle.addEventListener("click", () => {
      navbarNav.classList.toggle("active");
    });

    // Close menu when link is clicked
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        navbarNav.classList.remove("active");
      });
    });
  }
}

// Update Current Year in Footer
function updateCurrentYear() {
  const yearSpan = document.getElementById("currentYear");
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }
}

// Load components as soon as script loads (before DOMContentLoaded)
// This ensures header/footer are the first things to load
if (document.readyState === "loading") {
  // DOM is still loading
  document.addEventListener("DOMContentLoaded", async () => {
    await loadHeader();
    await loadFooter();
    initMobileMenu();
    setupEventListeners();
  });
} else {
  // DOM is already loaded (if this script loads after HTML)
  (async () => {
    await loadHeader();
    await loadFooter();
    initMobileMenu();
    setupEventListeners();
  })();
}
