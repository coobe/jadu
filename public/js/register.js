$(document).ready(function() {
    
    // hide error box initially
    $("#register-error").hide();
    
    // bind jquery dialog widget to reigster user dialog
    var registerUserDialog = $("#register-user-dialog").dialog({
        dialogClass: "no-close",
        modal: true,
        autoOpen: false,  
        resizable: false,
        draggable: false,
        width: 400,
        position: {
            my: "center",
            at: "center",
            of: ".container" 
        }
    });
    
    $(document).ajaxSend(function(event, request, settings) {
        $("body").addClass("hide-scrollbar");
    });

    $(document).ajaxComplete(function(event, request, settings) {
        $("body").removeClass("hide-scrollbar");
    });
    
    $("#register-link").unbind().click(function(e) {
        $("#register-user-dialog").dialog("open"); 
    });

    
    $("#modal-register-user").unbind().click(function(e) {
        var userName        = $("#user-name").val();
        var password        = $("#register-password").val();
        var passwordConfirm = $("#confirm-password").val();
        
        if (password !== passwordConfirm) {
            $("#register-error").html("passwords do not match");
            $("#register-error").show();
        } else {
            $.ajax({
                method: "post",
                url: "ajax_handler.php",
                data: {name: userName, pw: password, target: "user", method: "register"}
            }).done(function(response) {
                $("#user-name").val("");
                $("#register-password").val("");
                $("#confirm-password").val("");
                
                if (response == 1) { // user has been found in the DB
                    $("#register-error").html("User " + userName + " already exists");
                    $("#register-error").show();
                } else {
                    $("#register-user-dialog").dialog("close"); 
                    $("#creation-message").fadeIn(1400).fadeOut(1400);
                };
            });    
        };
    });
    
    $(window).resize(function() {
        $("#register-user-dialog").dialog("option", "position", {my: "center", at: "center", of: ".container"});
    });
});
