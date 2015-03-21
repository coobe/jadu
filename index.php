<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>jadu rss app</title>
    
<script src="public/js/jquery-1.11.2.min.js"></script>    
<!-- bootstrap js MUST be loaded before jquery-ui ! -->
<script src="public/js/bootstrap.min.js"></script>    
<script src="public/js/jquery-ui.min.js"></script>
    
<link rel="stylesheet" href="public/css/bootstrap.min.css">
<link rel="stylesheet" href="public/css/bootstrap-theme.min.css">      
<link rel="stylesheet" href="public/css/jquery-ui.min.css">
<link rel="stylesheet" href="public/css/custom.css">   

</head>
<body>
<?php
/**
* index script for the rss feed application
* handles user login 
*
* @author Torsten Oppermann
* @since 17.03.2015
*/

// enforce https
if($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

require_once("config/db.php");
require_once("controller/UserController.php");
require_once("model/User.php");

session_start();

$userController = new UserController();

if ($userController->isLoggedIn() == true) {
    $user = $_SESSION["user"];
    include("view/dashboard.php");
} else {
    include("view/login_form.php");
}
?>
  
</body>
</html>