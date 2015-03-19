$(document).ready(function() {
    
    // hide message box initially
    $("#message-box").hide();
    
    // rss row click event handler
    $(".rss-row").unbind().click(function(e) {  
        // prevent delete buttons from firing this event
        if (e.target.nodeName === "BUTTON") {
            return;
        }
        
        var feedId = $(this).attr("feed-id");
        console.log("Clicked feed id: " + feedId);
    });
    
    // event handler for the delete feed button
    $(".btn-delete-feed").unbind().click(function(e) {
        // confirmation check
        var popupChoice = confirm("Do you really want to delete this feed ?");
        
        // make ajax call and delete the feed
        if (popupChoice) {
            var feed_id = $.trim($(this).attr("feed-id"));
        
            $.ajax({
                method: "post",
                url: "ajax_handler.php",
                data: {feed: feed_id, target: "feed", method: "delete"}
            }).done(function(response) {
               afterAjaxTasks("#add-feed-dialog", "deleted RSS Feed", "#rss-table", response);
            });
        }
    });
    
    // bind jquery dialog widget to div
    var addFeedDialog = $("#add-feed-dialog").dialog({
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
    
    // event handler for the add feed button
    $(".btn-add-feed" ).unbind().click(function(e) {
        $("#add-feed-dialog").dialog( "open" );
    });
    
    // confirmation to add a feed
    $("#modal-add-feed").unbind().click(function(e) {
        var feedName    = $("#feed-name").val();
        var feedUrl     = $("#feed-url").val();
        
        // only make ajax call when we have data
        if (feedName && feedUrl) {
            $.ajax({
                method: "post",
                url: "ajax_handler.php",
                data: {feed_name: feedName, feed_url: feedUrl, target: "feed", method: "add"}
            }).done(function(response) {
                $("#feed-name").val("");
                $("#feed-url").val("");
                afterAjaxTasks("#add-feed-dialog", "added new RSS Feed", "#rss-table", response);
            });     
        }        
    });
    
    // confirmation to add a feed
    $("#modal-add-feed-cancel").unbind().click(function(e) {
            e.preventDefault(); // prevent notification
            $("#feed-name").val("");
            $("#feed-url").val("");
            $("#add-feed-dialog").dialog("close")
    });
    
    // center dialogs after resizing window
    $(window).resize(function() {
        $("#add-feed-dialog").dialog("option", "position", {my: "center", at: "center", of: ".container"});
    });
    
    // center dialogs after resizing window
    $(window).resize(function() {
        $("#add-feed-dialog").dialog("option", "position", {my: "center", at: "center", of: ".container"});
    });
    
    // helper functions to avoid redundant code
    
    /*
    * cleanse input fields, show message, render response
    */
    function afterAjaxTasks(dialogSelector, message, responseSelector, response) {
        $(dialogSelector).dialog("close");
        if (response) {
            $(responseSelector).html(response); // update the dynamic content
        };
        $("#message-box").html(message);
        $("#message-box").fadeIn(1400).fadeOut(1400);
    }
});