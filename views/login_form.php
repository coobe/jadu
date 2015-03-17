<?php
// show errors
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
}
?>
<!-- login form box -->
<form method="post" action="index.php" name="loginform">
    <label for="login_username">Username</label>
    <input id="login_username" type="text" name="username" required />
    <label for="login_password">Password</label>
    <input id="login_password" type="password" name="password" autocomplete="off" required />
    <input type="submit" name="login" value="Log in" />
</form>