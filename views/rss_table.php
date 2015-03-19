<table class="table table-hover">
    <caption>Your RSS Feeds</caption>
    <tbody>
        <tr>
            <th class="hidden">Id</th>
            <th>Name</th>
            <th>Url</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        // session_start();
require_once("./classes/User.php");
        $user = $_SESSION["user"];
        foreach ($user->getRssFeeds() as $feed) { ?>
            <tr>
                <td class="hidden"><?php echo $feed[0] ?></td>
                <td><?php echo $feed[2] ?></td>
                <td><?php echo $feed[1] ?></td>
                <td><button class="btn-delete-feed btn-danger" feed-id="<?php echo $feed[0]; ?>">delete</button></td>
                <td><button class="btn-add-feed btn-primary">add</button></td>
                <td><button class="btn-success">read</button></td>
            </tr>
        <?php
        }
        ?>            
    </tbody>
</table>

<div class="" id="add-feed-dialog" title="Add a new Feed">
    <div class="row">
        <label class="label label-default" for="feed_name">Name</label>
        <input id="feed-name" type="text" name="feed-name" required />
    </div>
    <div class="row">
        <label class="label label-default"  for="feed-url">Url</label>
        <input id="feed-url" type="text" name="feed-url" required />
    </div>
    <div class="row">
        <button class="btn btn-primary" type="submit" name="add">Add</button>
        <button class="btn btn-danger" type="submit" name="add">Cancel</button>
    </div>
</div>
      