<?php
require_once("config/db.php");

$dbConnection   = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
if ($dbConnection->connect_errno > 0) {
    die("Could not establish connection");
}


$dbConnection->query("DROP TABLE IF EXISTS jadu.users;")  or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("DROP TABLE IF EXISTS jadu.feeds;")  or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("DROP TABLE IF EXISTS jadu.users_feeds;")  or die("a mysql error has occured: " . $dbConnection->errno);
?>