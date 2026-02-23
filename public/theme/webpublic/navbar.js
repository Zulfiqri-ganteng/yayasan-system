document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.querySelector(".navbar-custom");
  const toggler = document.querySelector(".custom-toggler");
  const collapse = document.querySelector("#mainNavbar");

  /* =========================
     SHRINK ON SCROLL
  ========================= */

  window.addEventListener("scroll", function () {
    if (window.scrollY > 60) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  /* =========================
     HAMBURGER SMOOTH CONTROL
  ========================= */

  collapse.addEventListener("show.bs.collapse", function () {
    toggler.classList.add("active");
  });

  collapse.addEventListener("hide.bs.collapse", function () {
    toggler.classList.remove("active");
  });
});
