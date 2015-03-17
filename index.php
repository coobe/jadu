<?php
/**
* index script for the rss feed application
* handles user login 
*
* @author Torsten Oppermann
* @since 17.03.2015
*/

// include db configuration
require_once("config/db.php");

// instantiate login object
require_once("classes/Login.php");
$login = new Login();

// check if user is logged in and render the appropriate view
if ($login->isUserLoggedIn() == true) {
    include("views/dashboard.php");
} else {
    include("views/login_form.php");
}
?>