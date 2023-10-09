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

const gallerySwiper = new Swiper(".gallery-swiper", {
  direction: "horizontal",
  loop: false,

  // spaceBetween: 10,
  slidesPerView: 1,
  grabCursor: true,
  freeMode: true,

  navigation: {
    nextEl: ".about_galley_next",
    prevEl: ".about_galley_prev",
  },

  breakpoints: {
    320: {
      spaceBetween: 5,
    },
    768: {
      spaceBetween: 5,
    },
    1400: {
      spaceBetween: 20,
    },
  },
});

// Function that actually builds the swiper
const buildSwiperSlider = (sliderElm) => {
  let sliderIdentifier = sliderElm.dataset.id;

  return new Swiper(`.swiper-${sliderIdentifier}`, {
    direction: "horizontal",
    loop: false,

    spaceBetween: 0,
    grabCursor: true,
    slidesPerView: 1,

    pagination: {
      el: `.swiper-pagination-${sliderIdentifier}`,
    },
  });
};

// Get all of the swipers on the page
const allSliders = document.querySelectorAll(".swiper-grid");

// Loop over all of the fetched sliders and apply Swiper on each one.
allSliders.forEach((slider) => buildSwiperSlider(slider));

const galleryLeft = new Swiper(".gallery-left", {
  spaceBetween: 16,
  slidesPerView: 4,
  loop: false,
  watchSlidesVisibility: true,
  watchSlidesProgress: true,
  direction: "vertical",
});
const galleryRight = new Swiper(".gallery-right", {
  spaceBetween: 10,
  loop: false,
  grabCursor: true,

  thumbs: {
    swiper: galleryLeft,
  },
});
