/* =========================================
   ULTRA SMOOTH REVEAL
========================================= */
function reveal() {
  document.querySelectorAll("[data-animate]").forEach((el) => {
    const rect = el.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      el.classList.add("active");
    }
  });
}
window.addEventListener("scroll", reveal);
reveal();

/* =========================================
   HERO PARALLAX SMOOTH
========================================= */
window.addEventListener("scroll", function () {
  const scroll = window.pageYOffset;
  const hero = document.querySelector(".about-hero");
  if (hero) {
    hero.style.backgroundPositionY = scroll * 0.4 + "px";
  }
});
