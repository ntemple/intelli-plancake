(function($){
 $.fn.simpleTooltip = function(options) {
    var xOffset = 10;
    var yOffset = 20;

    return this.each(function() {
        var obj = $(this);

	obj.hover(
            function(e){
		var title = $(this).attr('title');
                $(this).data("hover-title", title);
		$(this).attr('title', '');
		$("body").append("<p id='simpleTooltip'>"+ title +"</p>");
                var tooltipBox = $("#simpleTooltip");
                var tooltipBoxWidth = tooltipBox.width();
		tooltipBox
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX - tooltipBoxWidth - yOffset) + "px")
                        .fadeIn("fast");
            },
            function(){
                $(this).attr('title', $(this).data("hover-title"));
                $("#simpleTooltip").remove();
        });
/*
	obj.mousemove(function(e){
		$("#simpleTooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX - tooltipBoxWidth - yOffset) + "px");
	});
        */
  });
 };
})(jQuery);
