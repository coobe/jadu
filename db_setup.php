<?php
// include db configuration
require_once("config/db.php");
require_once("db_clean.php");

$dbConnection   = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
if ($dbConnection->connect_errno > 0) {
    die("Could not establish connection");
}

$dbConnection->query("CREATE DATABASE IF NOT EXISTS jadu;")  or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, password varchar(50) NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users (name, password) VALUES ('admin', '" . md5("admin") . "');") or die("a mysql error has occured: " . $dbConnection->errno);



$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users_feeds (user_id int NOT NULL, feed_id int NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);


$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.feeds (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, url varchar(50) NOT NULL, display_name varchar(50) NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
?>