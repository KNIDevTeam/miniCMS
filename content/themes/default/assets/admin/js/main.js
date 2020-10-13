
/* Add buttons to expandable menus */

$(".expand").each(function() {
    $(this).append(`<div class="expand-button expand-button-inactive ${this.id}"><</div>`);
});

/* Expand submenumenu on click */

$(".expand").click(function() {
    let id = this.id;
    $(".submenu").each(function() {
        if($(this).hasClass(id)) $(this).slideToggle();
    });
    $(".expand-button").each(function() {
        if($(this).hasClass(id)) {
            if($(this).hasClass("expand-button-inactive")) {
                $(this).html("⌄");
                $(this).css("top", "-0.1em")
                $(this).removeClass("expand-button-inactive");
                $(this).addClass("expand-button-active");
            } else {
                $(this).html("<");
                $(this).css("top", "0.3em")
                $(this).removeClass("expand-button-active");
                $(this).addClass("expand-button-inactive");
            }
        }
    });
});

/* Fix menu when scrolled down */

$(window).on("scroll", function() {
    $("nav").removeClass("fixed-nav");
    if($("nav")[0].getBoundingClientRect().top < 50) $("nav").addClass("fixed-nav");
});

