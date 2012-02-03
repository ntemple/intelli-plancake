$('.btn').each(function(){
    var b = $(this);
    var tt = b.text() || b.val();
    /*
     * This code was in the original example (http://monc.se/kitchen/59/scalable-css-buttons-using-png-and-background-colors/)
     * but it wasn't making the button work on click
    if ($(':submit,:button',this)) {
        b = $('<a>').insertAfter(this).addClass(this.className).attr('id',this.id);
        $(this).remove();
    }
    */
    b.text('').css({cursor:'pointer'}).prepend('<i></i>').append($('<span>').text(tt).append('<i></i><span></span>'));
});