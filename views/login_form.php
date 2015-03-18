<div class="container">
    <div class="col-md-6 col-md-offset-4">
        <h1>RSS Webapp</h1>
    <?php
    // show errors
    if (isset($user)) {
        if ($user->errors) {
            foreach ($user->errors as $error) {
                echo "<div class='row alert alert-danger'>" . $error . "</div>";
            }
        }
    }
    ?>
    
    <!-- login form -->
        <form method="post" action="index.php" name="loginform">
            <div class="row">
                <label class="label label-default" for="login_username">Username</label>
                <input id="login_username" type="text" name="username" required />
            </div>
            <div class="row">
                <label class="label label-default"  for="login_password">Password</label>
                <input id="login_password" type="password" name="password" autocomplete="off" required />
            </div>
            <div class="row">
                <input class="btn btn-primary" type="submit" name="login" value="login" />
            </div>
        </form>
    </div>
</div>