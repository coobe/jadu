<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>jadu rss app</title>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>    
<!-- bootstrap js MUST be loaded before jquery-ui ! -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>    
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">      
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   
<style type="text/css">
    body {
        background-color: #1D2A33
    }
    
    a:visited {
        color: #000000 !important;
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
        margin-right: 10px;
        float: right;
    }
    
    .btn-delete-feed {
        float: right;
    }
    
    .modal-dialog .row .label {
        line-height: 2;
    }
    
    .modal-dialog input {
        margin-left: 20px;
    }
    
    .no-title .ui-dialog-titlebar {
        display: none;
    }
    
    .rss-row {
        cursor: pointer;
    }
    
    .label:hover {
        color: red !important;
    }
    
    .hide-scrollbar {
        overflow: hidden;
    }
    
    .error-message {
        position: absolute;
        text-align: center;
        width: auto;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        max-width: 500px !important;
    }
    
    #read-feed-dialog h3 {
        margin-top: 15px;
    }
    
    #message-box {
        position: absolute;
        text-align: center;
        width: 300px;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
    }
    
    #overlay {
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 999;
        position: absolute;
        width: 100%;
        height: 100%;
        display: none;
    }
    
    #loading-indicator {
        background:rgba(0,0,0,0.3);
        width:100%;
        height:100%;
        z-index: 9999;
        position: absolute;
        text-align: center;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
    }
    
    #loading-indicator img {
        position: absolute;
        text-align: center;
        width: auto;
        left: 100;
        right: 100;
        margin-left: auto;
        margin-right: auto;
        margin-top: 140px;
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