<script src="public/js/dashboard.js"></script> 

<table class="table table-hover">
    <caption>
        Your RSS Feeds
        <button class="btn-add-feed btn-primary">add</button>
    </caption>
    <tbody>
        <tr>
            <th class="hidden">Id</th>
            <th>Name</th>
            <th>Url</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        // get the user object
        require_once("./classes/User.php");
        $user = $_SESSION["user"];

        // iterate over feeds of the user
        foreach ($user->getRssFeeds() as $feed) { ?>
            <tr>
                <td class="hidden"><?php echo $feed[0] ?></td>
                <td><?php echo $feed[2] ?></td>
                <td><?php echo $feed[1] ?></td>
                <td><button class="btn-delete-feed btn-danger" feed-id="<?php echo $feed[0]; ?>">delete</button></td>
                <td><button class="btn-success">read</button></td>
            </tr>
        <?php
        }
        ?>            
    </tbody>
</table>

<?php include("add_feed.php"); ?>
      