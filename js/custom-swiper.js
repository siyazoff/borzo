const toCatalog = new Swiper(".swiper-small-cards", {
  direction: "horizontal",
  loop: false,

  spaceBetween: 16,
  slidesPerView: 4,
  grabCursor: true,
  // freeMode: true,

  navigation: {
    nextEl: ".to_catalog_next",
    prevEl: ".to_catalog_prev",
  },

  breakpoints: {
    320: {
      slidesPerView: 2,
      spaceBetween: 16,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 16,
    },
    1400: {
      slidesPerView: 4,
      spaceBetween: 16,
    },
  },
});
