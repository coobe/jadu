<?php
// include db configuration
require_once("../config/db.php");
require_once("db_clean.php");

$dbConnection   = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
if ($dbConnection->connect_errno > 0) {
    die("Could not establish connection");
}

$dbConnection->query("CREATE DATABASE IF NOT EXISTS jadu;")  or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, password varchar(50) NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users (name, password) VALUES ('dummy', '" . md5("dummy") . "');") or die("a mysql error has occured: " . $dbConnection->errno);

$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.feeds (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, url varchar(150) NOT NULL, display_name varchar(50) NOT NULL, last_read TIMESTAMP);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://www.php.net/news.rss', 'php.net', 0);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://slashdot.org/rss/slashdot.rss', 'slashdot', 0);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://feeds.bbci.co.uk/news/rss.xml?edition=uk', 'bbc', 0);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://www.reddit.com/r/php/.rss', 'reddit/php', 0);") or die("a mysql error has occured: " . $dbConnection->errno);

$dbConnection->query("CREATE TABLE IF NOT EXISTS jadu.users_feeds (user_id int NOT NULL, feed_id int NOT NULL);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES jadu.users(id) ON DELETE CASCADE;") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_feeds FOREIGN KEY (feed_id) REFERENCES jadu.feeds(id) ON DELETE CASCADE;") or die("a mysql error has occured: " . $dbConnection->errno);

$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 1);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 2);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 3);") or die("a mysql error has occured: " . $dbConnection->errno);
$dbConnection->query("INSERT INTO jadu.users_feeds VALUES (1, 4);") or die("a mysql error has occured: " . $dbConnection->errno);
?>