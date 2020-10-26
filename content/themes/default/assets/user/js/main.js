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

if($(window).width() > 736)
    $("main").css("padding-left", `${$("nav")[0].getBoundingClientRect().width+125}px`),
    $("footer").css({"margin-left": `${$("nav")[0].getBoundingClientRect().width+125}px`,
    "margin-right": `${$("nav")[0].getBoundingClientRect().width}px`});