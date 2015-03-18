<div class="container">
    <div class="col-md-6">
        <div class="row">Welcome <?php echo $user->getName(); ?>!
            <a href="index.php?logout">logout</a>
        </div>
    </div>
    
    <div class="col-md-6 col-md-offset-4">
        <table id="rss-table" class="table table-hover">
            <caption>Your RSS Feeds</caption>
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>