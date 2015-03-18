<div class="container">
    <div class="col-md-6">
        <div class="row">Welcome <?php echo $user->getName(); ?>!
            <a href="index.php?logout">logout</a>
        </div>
    </div>
    
    <div class="col-md-8 col-md-offset-2">
        <table id="rss-table" class="table table-hover">
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
    </div>
    
    <?php
    if ($user->isAdmin() == 1) {
    ?>
    <div class="col-md-8 col-md-offset-2">
        <table id="rss-table" class="table table-hover">
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