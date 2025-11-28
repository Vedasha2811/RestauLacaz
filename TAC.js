document.addEventListener("DOMContentLoaded", function () {
  // Add smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Add hover effects to terms sections
  const termsSections = document.querySelectorAll(".terms-section");
  termsSections.forEach((section) => {
    section.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-5px)";
      this.style.boxShadow = "0 10px 30px rgba(0, 0, 0, 0.15)";
    });

    section.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
      this.style.boxShadow = "none";
    });
  });

  // Update copyright year automatically
  const copyrightElement = document.querySelector(".footer-bottom");
  if (copyrightElement) {
    const currentYear = new Date().getFullYear();
    copyrightElement.innerHTML = `©${currentYear} RestauLakaz. All Rights Reserved.`;
  }

  // Add loading animation
  window.addEventListener("load", function () {
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 0.5s ease-in";

    setTimeout(() => {
      document.body.style.opacity = "1";
    }, 100);
  });
});

function toggleMobileMenu() {
  const nav = document.querySelector(".mobile-nav");
  if (nav) {
    nav.classList.toggle("active");
  }
}

// Additional utility functions
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function toggleSection(sectionId) {
  const section = document.getElementById(sectionId);
  if (section) {
    section.classList.toggle("expanded");
  }
}
