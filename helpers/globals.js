jQuery(document).ready(function($) {
    var submenu = false

    $("#user_nav .loggedin .click-space").click(function() {
        $("#user_nav .loggedin").toggleClass("down");
        submenu = !submenu;
    })

    $("html").click(function(e) {
        // register clicks on body and close menu if not inside .loggedin
        if (!$(e.target).parents(".loggedin").length && submenu) {
            $("#user_nav .loggedin").removeClass("down");
            submenu = false;
        }
    });
})
