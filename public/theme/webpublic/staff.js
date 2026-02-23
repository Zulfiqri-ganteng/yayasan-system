/* ==========================================
   STAFF SECTION JS - PROFESSIONAL VERSION
========================================== */

/* ===============================
   SHOW ALL BUTTON
=============================== */
document.getElementById("btnShowStaff")?.addEventListener("click", function () {
  document.querySelectorAll(".staff-hidden").forEach((el) => {
    el.classList.remove("d-none");
  });
  this.remove();
});

/* ===============================
   LIGHTBOX SYSTEM
=============================== */
document.addEventListener("DOMContentLoaded", function () {
  const cards = document.querySelectorAll(".staff-image");
  const lightbox = document.getElementById("staffLightbox");

  if (!cards.length || !lightbox) return;

  const img = document.querySelector(".staff-lightbox-img");
  const btnClose = document.querySelector(".staff-close");
  const btnPrev = document.querySelector(".staff-prev");
  const btnNext = document.querySelector(".staff-next");

  const nameEl = document.getElementById("lightboxName");
  const roleEl = document.getElementById("lightboxRole");
  const counterEl = document.getElementById("lightboxCounter");

  let current = 0;
  let touchStartX = 0;
  let touchEndX = 0;

  const data = [];

  /* ===============================
     COLLECT DATA
  =============================== */
  cards.forEach((card, index) => {
    const image = card.querySelector("img")?.src ?? "";
    const cardWrap = card.closest(".staff-card");

    const name = cardWrap?.querySelector("h5")?.innerText ?? "";
    const role = cardWrap?.querySelector(".staff-badge")?.innerText ?? "";

    const waliEl = cardWrap?.querySelector(".staff-meta");
    const wali = waliEl ? waliEl.innerText : "";

    data.push({ image, name, role, wali });

    card.addEventListener("click", () => {
      current = index;
      openLightbox();
    });
  });

  if (!data.length) return;

  /* ===============================
     OPEN LIGHTBOX
  =============================== */
  function openLightbox() {
    updateImage();
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
  }

  /* ===============================
     UPDATE IMAGE
  =============================== */
  function updateImage() {
    const item = data[current];

    img.src = item.image;
    nameEl.innerText = item.name;

    roleEl.innerHTML = item.role + (item.wali ? `<br><small style="color:#ccc;font-size:14px;">${item.wali}</small>` : "");

    counterEl.innerText = current + 1 + " / " + data.length;
  }

  /* ===============================
     NEXT / PREV
  =============================== */
  function nextSlide() {
    current = (current + 1) % data.length;
    updateImage();
  }

  function prevSlide() {
    current = (current - 1 + data.length) % data.length;
    updateImage();
  }

  btnNext?.addEventListener("click", nextSlide);
  btnPrev?.addEventListener("click", prevSlide);

  /* ===============================
     CLOSE
  =============================== */
  function closeLightbox() {
    lightbox.classList.remove("active");
    document.body.style.overflow = "auto";
  }

  btnClose?.addEventListener("click", closeLightbox);

  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  /* ===============================
     KEYBOARD SUPPORT
  =============================== */
  document.addEventListener("keydown", (e) => {
    if (!lightbox.classList.contains("active")) return;

    if (e.key === "Escape") closeLightbox();
    if (e.key === "ArrowRight") nextSlide();
    if (e.key === "ArrowLeft") prevSlide();
  });

  /* ===============================
     SWIPE SUPPORT (MOBILE)
  =============================== */
  img.addEventListener("touchstart", (e) => {
    touchStartX = e.changedTouches[0].screenX;
  });

  img.addEventListener("touchend", (e) => {
    touchEndX = e.changedTouches[0].screenX;

    if (touchEndX < touchStartX - 50) nextSlide();
    if (touchEndX > touchStartX + 50) prevSlide();
  });
});
