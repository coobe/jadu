$(document).ready(function() {
   
    // event handler for the delete feed button
    $(".btn-delete-feed").click(function(e) {
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
    $("#add-feed-dialog").dialog({
        modal: true,
        autoOpen: false,  
        resizable: false,
        draggable: false,
        width: 400
    });
    
    // event handler for the add feed button
    $(".btn-add-feed" ).click(function(e) {
        $( "#add-feed-dialog" ).dialog( "open" );
    });
    
});