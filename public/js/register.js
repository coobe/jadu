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
        width: 430,
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
        $("#register-error").hide();
        $("#user-name").val("");
        $("#register-password").val("");
        $("#confirm-password").val("");
        $("#register-user-dialog").removeClass("hidden");
        $("#register-user-dialog").dialog("open"); 
    });

    
    $("#modal-register-user").unbind().click(function(e) {
        var userName        = $("#user-name").val();
        var password        = $("#register-password").val();
        var passwordConfirm = $("#confirm-password").val();
        
        // check for whitespaces
        if ((userName.indexOf(" ") >= 0) || (password.indexOf(" ") >= 0)) {
            $("#register-error").html("you cannot have whitespaces in your Username or Password");
            $("#register-error").fadeIn(1).fadeOut(2400);
            return;
        }
        
        // check for minimum string sizes
        if ((userName.length < 4) || (password.length < 4)) {
            $("#register-error").html("Username and passwords must be at least 4 characters long");
            $("#register-error").fadeIn(1).fadeOut(2400);
            return;
        }
        
        // check for maximum string sizes
        if ((userName.length > 9) || (password.length >= 9)) {
            $("#register-error").html("username and password cannot be longer than 9 characters");
            $("#register-error").fadeIn(1).fadeOut(2400);
            return;
        }
        
        if (password != passwordConfirm) {
            $("#register-error").html("passwords do not match");
            $("#register-error").fadeIn(1).fadeOut(2400);
        } else if ((userName != "") && (password != "") && (passwordConfirm != "")) {
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
                    $("#register-error").fadeIn(1).fadeOut(2400);
                } else {
                    $("#register-user-dialog").dialog("close"); 
                    $("#creation-message").fadeIn(1).fadeOut(2400);
                };
            });    
        };
    });
    
    $(window).resize(function() {
        $("#register-user-dialog").dialog("option", "position", {my: "center", at: "center", of: ".container"});
    });
});
