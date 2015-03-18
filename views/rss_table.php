<table class="table table-hover">
    <caption>Your RSS Feeds</caption>
    <tbody>
        <tr>
            <th class="hidden">Id</th>
            <th>Url</th>
            <th>Name</th>
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
                <td><?php echo $feed[1] ?></td>
                <td><?php echo $feed[2] ?></td>
                <td><button class="btn-delete btn-danger" feed-id="<?php echo $feed[0]; ?>">delete</button></td>
                <td><button class="btn-primary">edit</button></td>
                <td><button class="btn-success">activate</button></td>
            </tr>
        <?php
        }
        ?>            
    </tbody>
</table>