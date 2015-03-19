<div id="loading-indicator" style="display:none">
    <img src="./public/img/ajax-loader.gif"  />
</div>
<div class="container">
    <div>
        <div class="row alert alert-success col-md-offset-6" id="message-box">
            <!--
            <button type="button" class="close" data-dismiss="alert">x</button>
            -->
            MESSAGES APPEAR HERE
        </div>
        <div class="row">Welcome <?php echo $user->getName(); ?>!
            <a href="index.php?logout">logout</a>
        </div>
    </div>
    
    <div class="col-md-8 col-md-offset-2" id="rss-table">
        <?php include_once("rss_table.php"); ?>
    </div>

    <?php include("read_feed.php"); ?>
    
    <?php
    if ($user->isAdmin() == 1) {
    ?>
    <div class="col-md-8 col-md-offset-2">
        <table class="table table-hover">
            <caption>User Management</caption>
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>Delete</th>
                </tr>
            </tbody>
        </table>
    </div>
    <?php }; ?>
    
</div>

