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

  const galleryImages = document.querySelectorAll(".gallery-grid img");
  const modal = document.getElementById("imageModal");
  const modalImage = document.getElementById("modalImage");
  const modalCaption = document.getElementById("modalCaption");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  let currentIndex = 0;

  if (galleryImages.length && modal && modalImage && modalCaption && prevButton && nextButton) {
    galleryImages.forEach((img, index) => {
      img.addEventListener("click", () => {
        modal.classList.add("active");
        currentIndex = index;
        updateModal();
      });
    });

    modal.addEventListener("click", e => {
      if (e.target === modal) {
        modal.classList.remove("active");
      }
    });

    const updateModal = () => {
      const currentImage = galleryImages[currentIndex];
      modalImage.src = currentImage.src;
      modalCaption.textContent = currentImage.alt;
    };

    prevButton.addEventListener("click", () => {
      currentIndex = currentIndex > 0 ? currentIndex - 1 : galleryImages.length - 1;
      updateModal();
    });

    nextButton.addEventListener("click", () => {
      currentIndex = currentIndex < galleryImages.length - 1 ? currentIndex + 1 : 0;
      updateModal();
    });

    document.addEventListener("keydown", e => {
      if (modal.classList.contains("active")) {
        if (e.key === "ArrowLeft") prevButton.click();
        else if (e.key === "ArrowRight") nextButton.click();
        else if (e.key === "Escape") modal.classList.remove("active");
      }
    });
  }

  const bookingForm = document.getElementById("bookingForm");
  const bookingFeedback = document.getElementById("bookingFeedback");

  if (bookingForm && bookingFeedback) {
    const setFeedback = (message, isError = false) => {
      bookingFeedback.textContent = message;
      bookingFeedback.classList.remove("visually-hidden", "feedback--error", "feedback--success");
      bookingFeedback.classList.add(isError ? "feedback--error" : "feedback--success");
    };

    bookingForm.addEventListener("submit", async event => {
      event.preventDefault();
      const formData = new FormData(bookingForm);
      const name = formData.get("name").trim();
      const phone = formData.get("phone").trim();
      const email = formData.get("email").trim();
      const message = formData.get("message").trim();

      if (!name || !phone || !email || !message) {
        setFeedback("Please fill in all required fields.", true);
        return;
      }

      try {
        const response = await fetch(bookingForm.action, {
          method: "POST",
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          setFeedback(result.message);
          bookingForm.reset();
        } else {
          setFeedback(result.message || "Something went wrong.", true);
        }
      } catch (error) {
        setFeedback("Unable to submit your request right now.", true);
      }
    });
  }
});
