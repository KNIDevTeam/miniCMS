/* Fix menu when scrolled down */

$(window).on("scroll", function() {
    $("nav").removeClass("fixed-nav");
    if($("nav")[0].getBoundingClientRect().top < 50) $("nav").addClass("fixed-nav");
});

