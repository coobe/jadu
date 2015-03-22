<script src="public/js/dashboard.js"></script> 

<table class="table table-hover">
    <caption>
        Your RSS Feeds - Click row to read
        <button class="btn-add-feed btn-primary">add</button>
    </caption>
    <tbody>
        <tr>
            <th>Name</th>
            <th>Url</th>
            <th></th>
        </tr>
        <?php
        require_once("./model/User.php");
        require_once("./model/Feed.php");

        $user = $_SESSION["user"];

        // iterate over feeds of the user
        foreach ($user->getRssFeeds() as $feed) { ?>
            <tr class="rss-row" feed-id="<?php echo $feed->getId(); ?>" feed-name="<?php echo $feed->getName(); ?>">
                <td><?php echo $feed->getName(); ?></td>
                <td><?php echo $feed->getUrl(); ?></td>
                <td><button class="btn-delete-feed btn-danger" feed-id="<?php echo $feed->getId(); ?>">delete</button></td>
            </tr>
        <?php
        }
        ?>            
    </tbody>
</table>

<?php include("add_feed.php"); ?>
      