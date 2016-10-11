jQuery(document).ready(function($) {

    $(".advance").click(function() {
        var target = $(this).data("target");

        $(this).parents(".pane").addClass("done").removeClass("active");
        $(".pane[data-index=" + target + "]").addClass("active");
    });

    $(".retreat").click(function() {
        var target = $(this).data("target");

        $(this).parents(".pane").removeClass("active");
        $(".pane[data-index=" + target + "]").removeClass("done").addClass("active");
    });

    $(".pane[data-index=1] .button").click(function() {
        $(".pane[data-index=1] .button").removeClass("active");

        if ($(this).data("leader") === 1) {
            $(".pane[data-index=1] .button[data-leader=1]").addClass("active");
            $(".pane[data-index=1] .login-warning").removeClass("active");
        } else {
            $(".pane[data-index=1] .button[data-leader=0]").addClass("active");
            $(".pane[data-index=1] .login-warning").addClass("active");
        }
    });

    $(".add-checklist-item").click(function() {
        addItem($(this));
    });

    $(".checklist").on("input", ".checklist-item input", function() {
        var check = $(this).val().match(/ x [0-9]+/gi);

        if  (check != null && check.length == 1) $(this).parent().addClass("valid");
        else $(this).parent().removeClass("valid");
    })

    $(".checklist").on("blur", ".checklist-item.valid input", function(e) {
        var elem = $(this);
        if ($(".checklist-item").not(".valid").length == 0) {
            addItem($(this));
            traverse($(this));
        } else {
            traverse($(this));
        }
    })

    function addItem(elem) {
        $(elem).parent().append('<div class="checklist-item"><input type="text" placeholder="Enter another requirement here. EG: Truck x 4" /></div>');
    }

    function traverse(element) {
        $(element).parent().next().children("input").focus();
    }
});
