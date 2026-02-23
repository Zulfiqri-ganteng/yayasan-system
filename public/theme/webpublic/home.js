document.addEventListener("DOMContentLoaded", function() {

  const counters = document.querySelectorAll('.counter');

  const animateCounter = (counter) => {
    const target = +counter.getAttribute('data-target');
    const duration = 1500;
    const step = target / (duration / 16);

    let current = 0;

    const update = () => {
      current += step;
      if (current < target) {
        counter.innerText = Math.floor(current);
        requestAnimationFrame(update);
      } else {
        counter.innerText = target;
      }
    };

    update();
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.6 });

  counters.forEach(counter => {
    observer.observe(counter);
  });

});
// scroll on top
const scrollBtn = document.getElementById("scrollTopBtn");

window.addEventListener("scroll", function () {
    if (window.scrollY > 300) {
        scrollBtn.classList.add("show");
    } else {
        scrollBtn.classList.remove("show");
    }
});

scrollBtn.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
