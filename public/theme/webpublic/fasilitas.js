document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".facility-item");
  const lightbox = document.getElementById("facilityLightbox");

  if (!items.length || !lightbox) return;

  const lightboxImg = lightbox.querySelector("img");
  const lightboxTitle = lightbox.querySelector("h4");
  const lightboxDesc = lightbox.querySelector("p");
  const btnClose = lightbox.querySelector(".facility-lightbox-close");

  items.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();

      const img = this.dataset.image;
      const title = this.dataset.title;
      const desc = this.dataset.desc;

      lightboxImg.src = img;
      lightboxTitle.innerText = title;
      lightboxDesc.innerText = desc;

      lightbox.classList.add("show");
      document.body.style.overflow = "hidden";
    });
  });

  btnClose.addEventListener("click", closeLightbox);
  lightbox.addEventListener("click", function (e) {
    if (e.target === this) closeLightbox();
  });

  function closeLightbox() {
    lightbox.classList.remove("show");
    document.body.style.overflow = "";
  }
});
