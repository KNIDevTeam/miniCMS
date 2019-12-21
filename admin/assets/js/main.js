$('.expand').each(function() {
    $(this).append(`<div class="expand-button expand-button-inactive ${this.id}"><</div>`);
});

$('.expand').click(function() {
    let id = this.id;
    $('.submenu').each(function() {
        if($(this).hasClass(id)) $(this).slideToggle();
    });
    $('.expand-button').each(function() {
        if($(this).hasClass(id)) {
            if($(this).hasClass('expand-button-inactive')) {
                $(this).html('v');
                $(this).removeClass('expand-button-inactive');
                $(this).addClass('expand-button-active');
            } else {
                $(this).html('<');
                $(this).removeClass('expand-button-active');
                $(this).addClass('expand-button-inactive');
            }
        }
    });
});