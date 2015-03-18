$(document).ready(function() {
   
    $(".btn-delete").click(function(e) {
        var feed_id = $.trim($(this).attr("feed-id"));
        
        $.post(
            'ajax_handler.php',
            {
                feed: feed_id,
                target: "feed",
                method: "delete"
            },
            function(data) {
                console.log(data);
            }
        );
    })
});