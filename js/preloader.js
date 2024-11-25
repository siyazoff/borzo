if (!sessionStorage.getItem("preloaderShown")) {
  //   $(".preloader").addClass("show");
  setTimeout(function () {
    $(".preloader").addClass("show");
    sessionStorage.setItem("preloaderShown", "true");
  }, 5000);
} else {
  $(".preloader").hide();
}
// if (!sessionStorage.getItem("preloaderShown")) {
//   //   showPreloader();
//   $(".preloader").toggleClass("show");
//   sessionStorage.setItem("preloaderShown", "true");
// } else {
//   $(".preloader").hide();
// }

// function showPreloader() {
//   let tl = gsap.timeline();

//   tl.to(".preloader", {
//     display: "flex",
//     opacity: 1,
//   })
//     .to("body", {
//       overflow: "hidden",
//     })
//     .to(".preloader .text-container", {
//       duration: 0,
//       opacity: 1,
//       ease: "Power3.easeOut",
//     })
//     .from(".preloader .text-container svg .item-preloader-1", {
//       duration: 1,
//       delay: 0.5,
//       y: 70,
//       skewY: 50,
//       stagger: 0.2,
//       ease: "Power3.easeOut",
//     })
//     .from(".preloader .text-container svg .item-preloader-2", {
//       duration: 1,
//       delay: 0.5,
//       x: -150,
//       stagger: 0.1,
//       ease: "Power3.easeOut",
//     })
//     .to(".preloader", {
//       duration: 1,
//       height: "0vh",
//       ease: "Power3.easeOut",
//       onComplete: function () {
//         if (sessionStorage.getItem("preloaderShown")) {
//           $(".preloader").hide(); // Скрываем только если еще не было скрыто
//         }
//       },
//     })
//     .to(
//       "body",
//       {
//         overflow: "unset",
//       },
//       "-=2"
//     );
// }
