<div class="container">
    <div class="col-md-6">
        <div class="row">Welcome <?php echo $user->getName(); ?>!
            <a href="index.php?logout">logout</a>
        </div>
    </div>
    
    <div class="col-md-8 col-md-offset-2" id="rss-table">
        <?php include_once("rss_table.php"); ?>
    </div>
    
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