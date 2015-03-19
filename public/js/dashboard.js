$(document).ready(function() {
   
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
               $("#rss-table").html(response); // update the feed table
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
                $("#add-feed-dialog").dialog("close");
                $("#rss-table").html(response); // update the feed table
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
    
});