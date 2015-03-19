<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>jadu rss app</title>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">    
   
<style type="text/css">
    body {
        background-color: #1D2A33
    }
    
    table {
        margin-top: 50px;
    }
    
    .container {
        background-color: #E7EEF6;
        padding: 100px;
        margin-top: 100px;
    }
    
    .row {
        padding: 5px;
    }
    
    .alert-danger {
        max-width: 260px;
        text-align: center;
    }
    
    
    .btn-add-feed {
        margin-left: 25px;
        float: right;
    }
    
    .modal-dialog .row .label {
        line-height: 2 !important;
    }
    
    .modal-dialog input {
        margin-left: 20px;
    }
    
    .ui-dialog-titlebar-close {
        visibility: hidden;
    }
    
</style>
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

// include db configuration
require_once("config/db.php");

// load classes
require_once("classes/User.php");
session_start();

// check if user is logged in and render the appropriate view
$user = new User();
if ($user->isLoggedIn() == true) {
    $user = $_SESSION["user"];
    include("views/dashboard.php");
} else {
    $_SESSION['user'] = $user;
    include("views/login_form.php");
}
?>
    
</body>
</html>