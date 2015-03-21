<script type="text/javascript">
    $("#feed-accordion").accordion({heightStyle: "content"});
    $("#read-feed-dialog").scrollTop(0);
</script>


<div id="read-feed-dialog" class="modal-dialog no-title">   
<?php 
if (!isset($feed)) {
    exit();
}; ?>
    <div id="feed-accordion">
<?php 
foreach($feed->getStories() as $currentStory) { ?>
        <h3><?php echo $currentStory->getTitle(); ?></h3>
        <div>
            <p>
                <?php echo $currentStory->getDate(); ?>
            </p>
            <p>
                <?php echo $currentStory->getDescription(); ?>
            </p>
            <p>
                <a class="label" target="_blank" href="<?php echo $currentStory->getLink(); ?>">Read more...</a>
            </p>
        </div>
<?php
};
?>
    </div>
</div>