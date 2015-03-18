$(document).ready(function() {
   
    $(".btn-delete").click(function(e) {
        
        var popupChoice = confirm("Do you really want to delete this feed ?");
        if (popupChoice) {
            var feed_id = $.trim($(this).attr("feed-id"));
        
            $.ajax({
                method: "post",
                url: "ajax_handler.php",
                data: {feed: feed_id, target: "feed", method: "delete"}
            }).done(function(response) {
               $("#rss-table").html(response); 
            });
        }
        
    })
});