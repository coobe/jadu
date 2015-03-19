<script type="text/javascript">
    $("#feed-accordion").accordion({heightStyle: "content"});
    $("#read-feed-dialog").scrollTop(0);
</script>


<div id="read-feed-dialog" class="modal-dialog no-title">
    <h3>Feeds from <?php echo (!isset($feedName) ? "null" : $feedName); ?></h3>    
<?php 
if (!isset($feedArray)) {
    exit();
}; ?>
    <div id="feed-accordion">
<?php 
foreach($feedArray as $currentFeed) { ?>
        <h3><?php echo $currentFeed['title']; ?></h3>
        <div>
            <p>
                <?php echo $currentFeed['date']; ?>
            </p>
            <p>
                <?php echo $currentFeed['desc']; ?>
            </p>
            <p>
                <a class="label" target="_blank" href="<?php echo $currentFeed['link']; ?>">Read more...</a>
            </p>
        </div>
<?php
};
?>
    </div>
</div>

/*

$storyArray = array (
                                  'title' => $story->title,
                                  'desc' => $story->description,
                                  'link' => $story->link,
                                  'date' => $story->date
            );
            
            */



