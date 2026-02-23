document.addEventListener("DOMContentLoaded", () => {
  /* ================= LIGHTBOX ================= */
  const lightbox = document.getElementById("galeri-lightbox");
  const lightboxImg = lightbox?.querySelector("img");
  const caption = lightbox?.querySelector(".gl-caption");
  const closeBtn = lightbox?.querySelector(".gl-close");

  document.querySelectorAll(".galeri-img").forEach((img) => {
    img.addEventListener("click", () => {
      lightbox.style.display = "flex";
      lightboxImg.src = img.src;
      caption.innerText = img.dataset.title || "";
    });
  });

  closeBtn?.addEventListener("click", () => {
    lightbox.style.display = "none";
  });

  lightbox?.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      lightbox.style.display = "none";
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      lightbox.style.display = "none";
    }
  });

  /* ================= SCROLL ANIMATION ================= */
  const animated = document.querySelectorAll("[data-animate]");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
        }
      });
    },
    { threshold: 0.15 },
  );

  animated.forEach((el) => observer.observe(el));
});
