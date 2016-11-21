var paddingOffset = 60;
var plan = false;
var planCount = 1;

jQuery(document).ready(function($) {

    if (plan) $("#new-plan").addClass("open");

    $(".plan-wrapper").width()

    $("#sidebar li").on("click", function() {
        $(".pane, #sidebar li").removeClass("active");
        $("#" + $(this).data("target")).addClass("active");
        $(this).addClass("active");
    });

    $("#overview-plans #plan-categories select").on("input", function() {
        $(".plan-table").removeClass("active");
        $(".plan-table." + $(this).val()).addClass("active");
    })

    $("#create-plan").on("click", function() {
        var title = $("#new-plan input").val();

        if (title.length == 0) {
            $("#new-plan input").addClass("empty");
        } else {
            $("#new-plan input").removeClass("empty");
            var location = $(this).data("location");
            var idea = $(this).data("idea");

            var data = {
                title: title,
            };

            if (location != undefined) data.location = location;
            if (idea != undefined) data.idea = idea;

            $.post("../helpers/plans/new.php", data, function(response) {
                if (response == "1") {
                    alert("Plan added successfully!");
                    $(".overlay").removeClass("open");
                }
            })
        }
    });

    $("#cancel-create-plan").click(function() {
        $(this).parents(".overlay-inner").children("input").val("");
        $(".overlay").removeClass("open");
    });
});

$(window).on("load", function() {
    $("#content").width($(window).width() - $("#sidebar").width() - paddingOffset);
});

$(window).on("resize", function() {
    $("#content").width($(window).width() - $("#sidebar").width() - paddingOffset);
});
