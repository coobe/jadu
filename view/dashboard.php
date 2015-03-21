<div id="loading-indicator" style="display:none">
    <img src="./public/img/ajax-loader.gif"  />
</div>
<div class="container">
    <div>
        <div class="row alert alert-success col-md-offset-6" id="message-box">
            <!-- messages appear here -->
        </div>
        <div class="row">Welcome <?php echo $user->getName(); ?>!
            <a href="index.php?logout">logout</a>
        </div>
    </div>
    
    <div class="col-md-8 col-md-offset-2" id="rss-table">
        <?php include_once("rss_table.php"); ?>
    </div>

    <?php include("read_feed.php"); ?>    
</div>

