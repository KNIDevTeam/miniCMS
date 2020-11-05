/* Hide sub-menus */

$(".sub-menu").each(function() {
    $(this).css("display", "none");
});

/* Activate parents of active node */

$(".active").parentsUntil(".main-menu").addClass("active");

/* Show active nodes */

$(".active").children().css("display", "inherit");

/* Fix menu when scrolled down */

$(window).on("scroll", function() {
    $("nav").removeClass("fixed-nav");
    if($("nav")[0].getBoundingClientRect().top < 50) $("nav").addClass("fixed-nav");
});

/* Fix main padding according to menu width */

if(window.matchMedia('(min-width: 737px)').matches) {
    // 40px - nav left property
    // 2em = 1em(nav padding left and right) + 2em separation

    $("main").css("padding-left", "calc(" + $("nav")[0].getBoundingClientRect().width + "px + 40px + 3em)");
    $("footer").css("margin-left", "calc(" + $("nav")[0].getBoundingClientRect().width + "px + 40px + 3em)");
}
