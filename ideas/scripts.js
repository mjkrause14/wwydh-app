var voting = false;

jQuery(document).ready(function($) {
    $(".op-1").click(function() {
        var hasDown = $(this).parents(".btn-group").siblings(".add-to-plan").hasClass("down");
        $(".add-to-plan").removeClass("down");
        $(".add-to-plan .plan-title").removeClass("active");
        add_to_plan = false;
        if (!hasDown) {
            $(this).parents(".btn-group").siblings(".add-to-plan").addClass("down");
            add_to_plan = true;
        }
    });

    $(".add-to-plan li.create span").click(function() {
        $(this).siblings(".plan-title").toggleClass("active");
    })

    $(".upvote").on("click", function() {
        if (!voting && !$(this).parents(".idea").hasClass("mine")) {
            var elem = $(this);
            $(this).siblings(".fa-spinner").addClass("open");
            voting = true;
            if ($(this).hasClass("me")) {

                $.post("../helpers/ideas/remove_upvote.php", {idea: $(this).parents(".idea").data("idea")}, function(response) {
                    if (response > 0) {
                        $(elem).removeClass("me");
                        $(".vote_count", elem).html(parseInt($(".vote_count", elem).html()) - 1);
                    }
                    $(elem).siblings(".fa-spinner").removeClass("open");
                    voting = false;
                });
            } else {
                $.post("../helpers/ideas/upvote.php", {idea: $(this).parents(".idea").data("idea")}, function(response) {
                    if (response > 0) {
                        var up_count = $(".idea[data-idea=" + response + "] .vote  .vote_count").html();
                        $(".idea[data-idea=" + response + "] .vote .upvote .vote_count").html(parseInt(up_count) + 1);

                        var down_count = $(".idea[data-idea=" + response + "] .vote .downvote .vote_count").html();
                        if ($(".idea[data-idea=" + response + "] .vote .downvote").hasClass("me"))
                            $(".idea[data-idea=" + response + "] .vote .downvote .vote_count").html(parseInt(down_count) - 1);

                        $(".idea[data-idea=" + response + "] .vote div").removeClass("me");
                        $(".idea[data-idea=" + response + "] .vote .upvote").addClass("me");
                    }
                    voting = false;
                    $(elem).siblings(".fa-spinner").removeClass("open");
                });
            }
        }
    });

    // not being used currently
    $(".downvote").on("click", function() {
        if (!voting) {
            var elem = $(this);
            $(this).siblings(".fa-spinner").addClass("open");
            voting = true;
            if ($(this).hasClass("me")) {

                $.post("../helpers/ideas/remove_downvote.php", {idea: $(this).parents(".idea").data("idea")}, function(response) {
                    if (response > 0) {
                        $(elem).removeClass("me");
                        $(".vote_count", elem).html(parseInt($(".vote_count", elem).html()) - 1);
                    }
                    $(elem).siblings(".fa-spinner").removeClass("open");
                    voting = false;
                });
            } else if ($(this).parents(".idea").hasClass("mine")) {
                alert("You can't downvote your own posts!");
                $(elem).siblings(".fa-spinner").removeClass("open");
                voting = false;
            } else {
                $.post("../helpers/ideas/downvote.php", {idea: $(this).parents(".idea").data("idea")}, function(response) {
                    if (response > 0) {
                        var up_count = $(".idea[data-idea=" + response + "] .vote .upvote .vote_count").html();
                        if (up_count > 0 && $(".idea[data-idea=" + response + "] .vote .upvote").hasClass("me"))
                            $(".idea[data-idea=" + response + "] .vote .upvote .vote_count").html(parseInt(up_count) - 1);

                        var down_count = $(".idea[data-idea=" + response + "] .vote .downvote .vote_count").html();
                        $(".idea[data-idea=" + response + "] .vote .downvote .vote_count").html(parseInt(down_count) + 1);

                        $(".idea[data-idea=" + response + "] .vote div").removeClass("me");
                        $(".idea[data-idea=" + response + "] .vote .downvote").addClass("me");
                    }
                    voting = false;
                    $(elem).siblings(".fa-spinner").removeClass("open");
                });
            }
        }
    });
})
