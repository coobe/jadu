<?php
require("AjaxController.php");
require("./config/db.php");
require("UserController.php");
require("model/Story.php");
require("model/Feed.php");

/**
* Handles ajax requests regarding Feeds
* 
* @author Torsten Oppermann
* @since 19.03.2015
*/
class FeedController extends AjaxController
{
    /**
    * @var User
    */ 
    private $user;

    /**
    * @var mysqli
    */
    private $dbConnection;
    
    /**
    * @var Feed
    */
    private $feed;
    
    /**
    * delegates request to the according internal method
    * methods: delete, add
    *
    * @param $pRequest the ajax request data
    */
    public function execute($pRequest)
    {
        session_start();
        $this->user = $_SESSION["user"];

        // determine the correct internal method
        switch ($pRequest["method"]) {
            case "delete":
                $feedId     = $pRequest["feed"];
                $this->delete($feedId);
                break;
            case "add":
                $this->feed = new Feed($pRequest["feed_name"], $pRequest["feed_url"]);
                $this->add();
                break;
            case "read":
                $feedId     = $pRequest["feed"];
                $this->read($feedId);
                break;
            default: 
                echo "Wrong method supplied at FeedController";
                break;
        }
    }
    
    /**
    * delete a given feed and return the updated table
    *
    * @param $pFeedId
    */
    private function delete($pFeedId)
    {
        // create database connection
        try {
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }
            
        if ($this->dbConnection) {
            // db query
            $result = $this->dbConnection->query("DELETE FROM jadu.feeds WHERE id = " . $pFeedId . ";");                
        }
        
        $this->dbConnection->close();
        
        include("./view/rss_table.php");
        exit();
    }
    
    /**
    * add a new feed and return the updated table and render the feed table
    *
    */
    private function add()
    {
        // create database connection
        try {
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }
            
        if ($this->dbConnection) {
            // insert new feed safely
            $sql = $this->dbConnection->prepare("INSERT INTO jadu.feeds(display_name, url) VALUES(?, ?);");
            $sql->bind_param("ss", $this->feed->getName(), $this->feed->getUrl());
            $sql->execute();
            
            // update the xref table
            $this->dbConnection->query("INSERT INTO jadu.users_feeds(user_id, feed_id) VALUES(" . $this->user->getUserId() . ", LAST_INSERT_ID());");
            $this->dbConnection->commit();
        }
        
        include("./view/rss_table.php");
        exit();
    }
    
    /**
    * read a given feed and render the feed dialog
    * 
    * @param $pFeedId
    */
    private function read($pFeedId) 
    {
        // create database connection
        try {
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        };
        
        if($this->dbConnection) {
            $sql = $this->dbConnection->prepare("SELECT display_name, url FROM feeds WHERE id = ?"); 
            $sql->bind_param("s", $pFeedId);
            $sql->execute();

            // bind result variables        
            $sql->bind_result($feedName, $feedUrl);
            $sql->fetch();

            $this->feed = new Feed($feedName, $feedUrl);

            // parse feed url; warnings must be suppressed
            $feedXML = @simplexml_load_file($this->feed->getUrl());  

            if ($feedXML) {
                foreach($feedXML->channel->item as $currentStory) {
                    $story = new Story(strip_tags($currentStory->title), strip_tags($currentStory->description), strip_tags($currentStory->link), strip_tags($currentStory->date));
                    $this->feed->addStory($story);
                }

                // this is an exception for rss feeds wich have no items below the channel tag but on the same level
                foreach($feedXML->item as $currentStory) {
                    $story = new Story(strip_tags($currentStory->title), strip_tags($currentStory->description), strip_tags($currentStory->link), strip_tags($currentStory->date));
                    $this->feed->addStory($story);
                }

                $feed = $this->feed;
                include("./view/read_feed.php");   
                exit();
            } else {
                $errorMessage = "could not parse feed at <b>" . $this->feed->getUrl() . "</b>. Please check the URL";
                include("./view/error.php");
                exit();
            } 
        }
    }
}