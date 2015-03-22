DROP TABLE IF EXISTS jadu.users_feeds;
DROP TABLE IF EXISTS jadu.users;
DROP TABLE IF EXISTS jadu.feeds;

CREATE DATABASE IF NOT EXISTS jadu;

CREATE TABLE IF NOT EXISTS jadu.users (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(50) NOT NULL, password varchar(50) NOT NULL);
INSERT INTO jadu.users (name, password) VALUES ('dummy', md5('dummy'));

CREATE TABLE IF NOT EXISTS jadu.feeds (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, url varchar(150) NOT NULL, display_name varchar(50) NOT NULL, last_read TIMESTAMP);
INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://www.php.net/news.rss', 'php.net', 0);
INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://slashdot.org/rss/slashdot.rss', 'slashdot', 0);
INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://feeds.bbci.co.uk/news/rss.xml?edition=uk', 'bbc', 0);
INSERT INTO jadu.feeds (url, display_name, last_read) VALUES ('http://www.reddit.com/r/php/.rss', 'reddit/php', 0);

CREATE TABLE IF NOT EXISTS jadu.users_feeds (user_id int NOT NULL, feed_id int NOT NULL);
ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES jadu.users(id) ON DELETE CASCADE;
ALTER TABLE jadu.users_feeds ADD CONSTRAINT fk_feeds FOREIGN KEY (feed_id) REFERENCES jadu.feeds(id) ON DELETE CASCADE;

INSERT INTO jadu.users_feeds VALUES (1, 1);
INSERT INTO jadu.users_feeds VALUES (1, 2);
INSERT INTO jadu.users_feeds VALUES (1, 3);
