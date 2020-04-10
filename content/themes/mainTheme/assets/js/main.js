/* Hide sub-menus */

$(".sub-menu").each(function() {
    $(this).css("display", "none");
});

/* Activate parents of active node */

$(".active").parentsUntil(".main-menu").addClass("active");

/* Show active nodes */

$(".active").children().css("display", "inherit");