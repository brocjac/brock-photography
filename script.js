let controller = new ScrollMagic.Controller();
let timeline = new TimelineMax();

timeline
    .from(".mainImg", 3, {y: -50}, {y: 0, duration: 3})
    .to('.content', 3, {top: '110%'}, "-=3")
    .to('.columnHeight', 3, {top: '110%'}, "-=3");

let scene = new ScrollMagic.Scene({
    triggerElement: "section",
    duration: "100%",
    triggerHook: 0,
})
    .setTween(timeline)
    .setPin("section")
    .addTo(controller);
