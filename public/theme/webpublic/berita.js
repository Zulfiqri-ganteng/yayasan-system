document.addEventListener("DOMContentLoaded", function () {

  const slider = document.querySelector(".news-slider");
  const items = document.querySelectorAll(".news-item");

  if (!slider || items.length <= 3) return;

  let index = 0;

  setInterval(() => {
    index++;

    if (index > items.length - 3) {
      index = 0;
    }

    slider.style.transform = `translateX(-${index * (items[0].offsetWidth + 30)}px)`;

  }, 4000);

});
