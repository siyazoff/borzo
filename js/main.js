$(document).ready(function () {
  let prevScrollPos = window.scrollY;
  const $header = $("#header");

  $(window).on("scroll", function () {
    const currentScrollPos = window.scrollY;
    $header.css(
      "top",
      prevScrollPos > currentScrollPos || currentScrollPos === 0
        ? "0px"
        : "-205px"
    );
    navbar.classList.remove("open");
    popup.classList.remove("open");
    hamb.classList.remove("active");
    prevScrollPos = currentScrollPos;
  });

  $("#search-btn").click(function () {
    $(".search-phone").toggleClass("active");
    $("header .logo-menu .menu").toggleClass("non-active");
  });

  const hamb = document.querySelector("#hamb");
  const popup = document.querySelector("#popup");
  const body = document.body;
  const navbar = document.querySelector(".navbar");

  const menu = document.querySelector("#menu").cloneNode(1);

  hamb.addEventListener("click", hambHandler);

  function hambHandler(e) {
    e.preventDefault();
    popup.classList.toggle("open");
    navbar.classList.toggle("open");
    hamb.classList.toggle("active");
    renderPopup();
  }

  function renderPopup() {
    popup.appendChild(menu);
  }

  const links = Array.from(menu.children);

  links.forEach((link) => {
    link.addEventListener("click", closeOnClick);
  });

  function closeOnClick() {
    popup.classList.remove("open");
    navbar.classList.remove("open");
    hamb.classList.remove("active");
  }

  $("input[id='tel']").mask("+7 (999) 999-99-99");
  $("input[id='tel-number']").mask("+7 (999) 999-99-99");
});
