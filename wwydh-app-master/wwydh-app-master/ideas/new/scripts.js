jQuery(document).ready(function($) {

    $(".advance").click(function() {
        var target = $(this).data("target");

        $(this).parents(".pane").addClass("done").removeClass("active");
        $(".pane[data-index=" + target + "]").addClass("active");
    });

    $(".pane[data-index=1] .button").click(function() {
        $(".pane[data-index=1] .button").removeClass("active");

        if ($(this).data("leader") === 1) $(".pane[data-index=1] .button[data-leader=1]").addClass("active");
        else $(".pane[data-index=1] .button[data-leader=0]").addClass("active");
    });
});
