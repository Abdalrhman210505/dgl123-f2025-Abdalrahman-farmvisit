/**
 * Frontend enhancements for navigation, interactions, and scroll handling.
 */
"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const isHome = window.location.pathname.endsWith("index.html") || window.location.pathname === "/";
  if (isHome) {
    window.onload = function () {
      alert("Welcome to our website!");
    };
  }

  const navLinks = document.querySelectorAll("nav ul li a[href^='#']");
  navLinks.forEach(link => {
    link.addEventListener("click", event => {
      const targetId = link.getAttribute("href").substring(1);
      const targetElement = document.getElementById(targetId);
      if (targetElement) {
        event.preventDefault();
        window.scrollTo({
          top: targetElement.offsetTop - 50,
          behavior: "smooth"
        });
      }
    });
  });

  const images = document.querySelectorAll("img");
  images.forEach(img => {
    img.addEventListener("mouseover", function () {
      this.style.transform = "scale(1.05)";
      this.style.transition = "transform 0.3s ease";
    });
    img.addEventListener("mouseout", function () {
      this.style.transform = "scale(1)";
    });
  });

  const backToTop = document.createElement("button");
  backToTop.textContent = "↑";
  backToTop.id = "backToTop";
  backToTop.type = "button";
  document.body.appendChild(backToTop);

  Object.assign(backToTop.style, {
    position: "fixed",
    bottom: "20px",
    right: "20px",
    padding: "10px 15px",
    fontSize: "20px",
    display: "none",
    cursor: "pointer"
  });

  window.addEventListener("scroll", () => {
    backToTop.style.display = window.scrollY > 200 ? "block" : "none";
  });

  backToTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});
