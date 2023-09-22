//!Animation

let width = window.innerWidth;

if (width <= 786) {
  console.log("hello");
} else {
  const animation = anime({
    targets: ".services .heading h1",
    translateX: 288,
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationFleetHeading = anime({
    targets: ".fleet .heading h1",
    translateX: 288,
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationAbout = anime({
    targets: "#animation-about",
    translateX: [-480, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationAbImg = anime({
    targets: "#about-img",
    width: ["0%", "100%"],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationEllipse1 = anime({
    targets: ".ellipse-cntr",
    translateX: [-288, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationEllipse2 = anime({
    targets: ".ellipse-cntr-2",
    translateX: [300, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const advantagesHeading = anime({
    targets: ".advantages .heading h1",
    translateX: [-288, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const weCanHeading = anime({
    targets: ".we-can .heading h1",
    translateX: [-288, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const weCanTitle = anime({
    targets: ".we-can .description p",
    translateX: [-340, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const orderHeading = anime({
    targets: ".order .heading h1",
    translateX: [-288, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationQuestion = anime({
    targets: "#animation-question",
    translateX: [-288, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animationNumber = anime({
    targets: "#animation-number",
    left: [-327, 0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const opacityBox1 = anime({
    targets: ".services .box-1",
    opacity: [0.0, 1.0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const opacityBox2 = anime({
    targets: ".services .box-2",
    opacity: [0.0, 1.0],
    duration: 4000,
    autoplay: false,
    easing: "linear",
  });

  const animateHeaderP = anime({
    targets: ".animate-header-p",
    left: [-295, 0],
    duration: 500,
    delay: 6500,
    autoplay: true,
    easing: "linear",
  });

  const cntrHeader = anime({
    targets: ".cntr-header",
    top: [-205, 0],
    duration: 500,
    delay: 6500,
    autoplay: true,
    easing: "linear",
  });

  //?elements for offset

  const homeTitle = document.querySelector(".home-title");
  const boxTwo = document.querySelector(".box-2");
  const aboutTitle = document.querySelector("#item-1");
  const firstP = document.querySelector(".about .description .first-p");
  const aboutImg = document.querySelector("#about-img");
  const ellipseCntr = document.querySelector(".ellipse-cntr");
  const ellipseCntr2 = document.querySelector(".ellipse-cntr-2");
  const weCanBtn = document.querySelector(".we-can-btn ");
  const orderHeadingTop = document.querySelector(".order .heading h1");

  //*Anime scroll function

  const animateOnScroll = function (div, speed = 100, offset = 0) {
    const scrollPercent = window.scrollY - div.offsetTop;
    return (scrollPercent + offset) / speed;
  };

  //fucntion on scroll
  window.onscroll = function () {
    animation.seek(animateOnScroll(homeTitle, 700, 100) * animation.duration);

    animationFleetHeading.seek(
      animateOnScroll(boxTwo, 700, 200) * animation.duration
    );

    animationAbout.seek(
      animateOnScroll(aboutTitle, 700, 0) * animation.duration
    );

    animationAbImg.seek(animateOnScroll(firstP, 700, 400) * animation.duration);

    animationEllipse1.seek(
      animateOnScroll(aboutImg, 500, -200) * animation.duration
    );

    animationEllipse2.seek(
      animateOnScroll(aboutImg, 500, -200) * animation.duration
    );

    advantagesHeading.seek(
      animateOnScroll(aboutImg, 700, -100) * animation.duration
    );

    weCanHeading.seek(
      animateOnScroll(ellipseCntr, 700, 0) * animation.duration
    );

    weCanTitle.seek(animateOnScroll(ellipseCntr2, 400, 0) * animation.duration);

    orderHeading.seek(animateOnScroll(weCanBtn, 500, 300) * animation.duration);

    animationQuestion.seek(
      animateOnScroll(orderHeadingTop, 500, 100) * animation.duration
    );

    animationNumber.seek(
      animateOnScroll(orderHeadingTop, 700, 200) * animation.duration
    );

    opacityBox1.seek(animateOnScroll(homeTitle, 700, 0) * animation.duration);

    opacityBox2.seek(animateOnScroll(homeTitle, 1000, 0) * animation.duration);
  };
}
