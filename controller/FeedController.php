<?php
require("AbstractController.php");
require("./config/db.php");
require("./classes/User.php");

class FeedController extends AbstractController
{
    private $user;
    private $dbConnection;
    
    public function execute($request)
    {
        session_start();
        $this->user = $_SESSION["user"];

        switch ($request["method"]) {
            case "delete":
                $feedId     = $request["feed"];
                $this->delete($feedId);
            break;
            case "add":
                $feedName   = $request["feed_name"];
                $feedUrl    = $request["feed_url"];
                $this->add($feedName, $feedUrl);
            break;
            default: 
                echo "DEFAULT";
            break;
        }
    }
    
    private function delete($pFeedId)
    {
        // create database connection
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
        if (!$this->dbConnection->connect_errno) {
            // db query
            $result = $this->dbConnection->query("DELETE FROM jadu.feeds WHERE id = " . $pFeedId . ";") or die("a mysql error has occured: " . $this->dbConnection->errno);
                
        } else {
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
        }
        
        $this->dbConnection->close();
        
        include("./views/rss_table.php");
        exit();
    }
    
    private function add($pName, $pUrl)
    {
        // create database connection
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
        if (!$this->dbConnection->connect_errno) {
            // insert new feed
            $sql = $this->dbConnection->prepare("INSERT INTO jadu.feeds(display_name, url) VALUES(?, ?);") or die("a mysql error has occured: " . $this->dbConnection->errno);
            $sql->bind_param("ss", $pName, $pUrl);
            $sql->execute();
            
            $this->dbConnection->query("INSERT INTO jadu.users_feeds(user_id, feed_id) VALUES(" . $this->user->getUserId() . ", LAST_INSERT_ID());") or die("a mysql error has occured: " . $this->dbConnection->errno); 
        } else {
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
            exit();
        }
        
        $this->dbConnection->commit();
        
        include("./views/rss_table.php");
        exit();
    }
    
}