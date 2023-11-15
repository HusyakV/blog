var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
  loopedslides: 1,
  autoplay: {
    delay: 6000,
  },

  breakpoints: {
    500: {
      slidesPerView: 1,
    },
    900: {
      slidesPerView: 2,
    },
  },
});
