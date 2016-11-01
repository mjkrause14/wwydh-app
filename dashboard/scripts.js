
var paddingOffset = 60;

$(window).on("load", function() {
    $("#content").width($(window).width() - $("#sidebar").width() - paddingOffset);
});

$(window).on("resize", function() {
    $("#content").width($(window).width() - $("#sidebar").width() - paddingOffset);
});
