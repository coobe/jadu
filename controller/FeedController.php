<?php
require("AbstractController.php");
require("./config/db.php");
require("./classes/User.php");

/**
* Handles ajax requests regarding Feeds
* 
* @author Torsten Oppermann
* @since 19.03.2015
*/
class FeedController extends AbstractController
{
    private $user;
    private $dbConnection;
    private $feedUrl;
    private $feedName;
    
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
                $feedName   = $pRequest["feed_name"];
                $feedUrl    = $pRequest["feed_url"];
                $this->add($feedName, $feedUrl);
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
    
    /**
    * add a new feed and return the updated table
    *
    * @param $pName, $pUrl 
    */
    private function add($pName, $pUrl)
    {
        // create database connection
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
        if (!$this->dbConnection->connect_errno) {
            // insert new feed safely
            $sql = $this->dbConnection->prepare("INSERT INTO jadu.feeds(display_name, url) VALUES(?, ?);") or die("a mysql error has occured: " . $this->dbConnection->errno);
            $sql->bind_param("ss", $pName, $pUrl);
            $sql->execute();
            
            // update the xref table
            $this->dbConnection->query("INSERT INTO jadu.users_feeds(user_id, feed_id) VALUES(" . $this->user->getUserId() . ", LAST_INSERT_ID());") or die("a mysql error has occured: " . $this->dbConnection->errno); 
        } else {
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
            exit();
        }
        
        $this->dbConnection->commit();
        
        include("./views/rss_table.php");
        exit();
    }
    
    /**
    * read a given feed
    * 
    * @param $pFeedId
    */
    private function read($pFeedId) 
    {
        // create database connection
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $sql = $this->dbConnection->prepare("SELECT url, display_name FROM feeds WHERE id = ?") or die("a mysql error has occured: " . $this->dbConnection->errno); 
        $sql->bind_param("s", $pFeedId);
        $sql->execute();
        
        /* bind result variables */
        $sql->bind_result($this->feedUrl, $this->feedName);
        $sql->fetch();
        
        $feed = @simplexml_load_file($this->feedUrl);  
        
        if ($feed) {
            //$feed = simplexml_load_file("http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/front_page/rss.xml");
            $feedArray = array();
            foreach($feed->channel->item as $story){
                $storyArray = array (
                                      'title'   => strip_tags($story->title),
                                      'desc'    => strip_tags($story->description),
                                      'link'    => strip_tags($story->link),
                                      'date'    => strip_tags($story->date)
                );

                array_push($feedArray, $storyArray);
            }

            // this is an exception for rss feeds wich have no items below the channel tag but on the same level
            foreach($feed->item as $story){
                $storyArray = array (
                                      'title'   => strip_tags($story->title),
                                      'desc'    => strip_tags($story->description),
                                      'link'    => strip_tags($story->link),
                                      'date'    => strip_tags($story->date)
                );

                array_push($feedArray, $storyArray);
            }

            $feedName = $this->feedName;
            include("./views/read_feed.php");   
        } else {
            $errorMessage = "could not parse feed at <b>" . $this->feedUrl . "</b>. Please check the URL";
            include("./views/error.php");
            exit();
        }
        
    }
    
}