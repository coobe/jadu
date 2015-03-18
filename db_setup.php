<?php
// include db configuration
require_once("config/db.php");
require_once("db_clean.php");

$dbConnection   = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
if ($dbConnection->connect_errno > 0) {
    die("Could not establish connection");
}

$dbConnection->query("CREATE DATABASE IF NOT EXISTS jadu;")  or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, password varchar(50) NOT NULL, is_admin int NOT NULL DEFAULT 0);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users (name, password, is_admin) VALUES ('admin', '" . md5("admin") . "', 1);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users (name, password, is_admin) VALUES ('dummy', '" . md5("dummy") . "', 0);") or die("a mysql error has occured: " . $dbConnection->errno);





$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.feeds (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, url varchar(50) NOT NULL, display_name varchar(50) NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name) VALUES ('http://www.php.net/news.rss', 'php.net');") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name) VALUES ('http://slashdot.org/rss/slashdot.rss', 'slashdot');") or die("a mysql error has occured: " . $dbConnection->errno);

$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users_feeds (user_id int NOT NULL, feed_id int NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES jadu.users(id) ON DELETE CASCADE;") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_feeds FOREIGN KEY (feed_id) REFERENCES jadu.feeds(id) ON DELETE CASCADE;") or die("a mysql error has occured: " . $dbConnection->errno);

$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 1);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 2);") or die("a mysql error has occured: " . $dbConnection->errno);

?>