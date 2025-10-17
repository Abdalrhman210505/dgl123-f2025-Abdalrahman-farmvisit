"use strict";

if (window.location.pathname.endsWith("index.html") || window.location.pathname === "/") {
  window.onload = function () {
    alert("Welcome to our website!");
  };
}

document.addEventListener("DOMContentLoaded", function () {
  // Smooth Scroll for navigation links
  const navLinks = document.querySelectorAll("nav ul li a");
  navLinks.forEach(link => {
    link.addEventListener("click", function (event) {
      if (this.getAttribute("href").startsWith("#")) {
        event.preventDefault();
        const targetId = this.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 50,
            behavior: "smooth"
          });
        }
      }
    });
  });

  // Image hover effect
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

  // Back to top button
  const backToTop = document.createElement("button");
  backToTop.textContent = "↑";
  backToTop.id = "backToTop";
  document.body.appendChild(backToTop);

  backToTop.style.position = "fixed";
  backToTop.style.bottom = "20px";
  backToTop.style.right = "20px";
  backToTop.style.padding = "10px 15px";
  backToTop.style.fontSize = "20px";
  backToTop.style.display = "none";
  backToTop.style.cursor = "pointer";

  window.addEventListener("scroll", function () {
    if (window.scrollY > 200) {
      backToTop.style.display = "block";
    } else {
      backToTop.style.display = "none";
    }
  });

  backToTop.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });
});


    // JavaScript for Interactive Gallery
    const images = document.querySelectorAll('.gallery-grid img');
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalCaption = document.getElementById('modalCaption');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
  
    let currentIndex = 0;
  
    // Open modal when an image is clicked (I took all this code from the internet )
    images.forEach((img, index) => {
      img.addEventListener('click', () => {
        modal.classList.add('active');
        currentIndex = index;
        updateModal();
      });
    });
  
    // Close modal when clicking outside the image
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('active');
      }
    });
  
    // Update modal content
    function updateModal() {
      const currentImage = images[currentIndex];
      modalImage.src = currentImage.src;
      modalCaption.textContent = currentImage.alt;
    }
  
    // Navigate to previous image
    prevButton.addEventListener('click', () => {
      currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
      updateModal();
    });
  
    // Navigate to next image
    nextButton.addEventListener('click', () => {
      currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
      updateModal();
    });
  
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (modal.classList.contains('active')) {
        if (e.key === 'ArrowLeft') {
          prevButton.click();
        } else if (e.key === 'ArrowRight') {
          nextButton.click();
        } else if (e.key === 'Escape') {
          modal.classList.remove('active');
        }
      }
    });



    //contact webpage

    /*  script for ensuring that all the fields are filled before pressing submit */
    function validateForm() {
        // Get form fields
        const name = document.getElementById("name").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const email = document.getElementById("email").value.trim();
        const message = document.getElementById("message").value.trim();
  
        // Check if any field is empty
        if (!name || !phone || !email || !message) {
            alert("Please fill in all fields.");
            return;
        }
  
        // If all fields are filled
        else{ alert("Thank you for your submission!");}
        
        // Optionally, submit the form programmatically
        // document.getElementById("contactForm").submit();
      }
  