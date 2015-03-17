<?php
$dbConnection   = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
if ($dbConnection->connect_errno > 0) {
    die("Could not establish connection");
}

$dbConnection->query("DROP TABLE IF EXISTS jadu.users;")  or die("a mysql error has occured: " . $dbConnection->errno);
?>