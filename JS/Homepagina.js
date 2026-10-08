// use a script tag or an external JS file
 document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(ScrollTrigger,SplitText,TextPlugin)
  // gsap code here!
 });

gsap.from(".hero_titel", {
  x: -200, opacity: 0,
  duration: 1.4, ease: "power2.out"
});


gsap.from(".hero_tekst", {
  x: -200, opacity: 0,
  duration: 1.5, ease: "power2.out"
});