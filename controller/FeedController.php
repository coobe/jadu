<?php
require("AjaxController.php");
require("./config/db.php");
require("UserController.php");
require("model/Story.php");

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
    * @var PDO
    */
    private $pdo;
    
    /**
    * @var Feed
    */
    private $feed;
    
    
    public function __construct() 
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    }
    
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
                $this->feed = new Feed(null, $pRequest["feed_name"], $pRequest["feed_url"], time());
                $this->add();
                break;
            case "read":
                $feedId     = $pRequest["feed"];
                $this->read($feedId);
                break;
            case "check":
                if (isset($pRequest["feeds"])) 
                {
                    $feeds     = $pRequest["feeds"];
                    $this->check($feeds);
                };
                
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
        $sql = $this->pdo->prepare("DELETE FROM feeds WHERE id = :id");
        if ($sql->execute(array(":id" => $pFeedId))) {
                include("./view/rss_table.php");
                exit();
        } else {
            $errorMessage = "Could not delete Entry at Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }
    }
    
    /**
    * add a new feed and return the updated table and render the feed table
    *
    */
    private function add()
    {
        // check if the feed is correct and can be parsed
        $feedXML = @simplexml_load_file($this->feed->getUrl());
        if (!$feedXML) {
            echo -1; // error flag for ajax call
            exit();
        }
        
        try {
            $this->pdo->beginTransaction();
            $sql = $this->pdo->prepare("INSERT INTO jadu.feeds(display_name, url) VALUES(:name, :url);");
            $sql->execute(array(":name" => $this->feed->getName(), ":url" => $this->feed->getUrl()));
            
            $sql = $this->pdo->prepare("INSERT INTO jadu.users_feeds(user_id, feed_id) VALUES(:id, LAST_INSERT_ID());");
            $sql->execute(array(":id" => $this->user->getUserId()));
            
            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollback();
            $errorMessage = "Could not Insert at Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }

        include("./view/rss_table.php");
        exit();
        
    }    
    
    /**
    * check for last time a feed has been read
    * 
    * @param $pFeedId
    */
    private function check($pFeeds) 
    {
        $response   = array();
        
        foreach($pFeeds as $key => $val) {
            $sql = $this->pdo->prepare("SELECT feed_id, UNIX_TIMESTAMP(feeds.last_read) AS last_read FROM users_feeds JOIN feeds ON feeds.id = users_feeds.feed_id WHERE user_id = :user_id AND feed_id = :feed_id");
            $sql->execute(array(":user_id" => $this->user->getUserId(), ":feed_id" => $val));
            $result = $sql->fetch();
            
            array_push($response, $result);
        }
        echo json_encode($response);
        exit();
    }
    
    /**
    * read a given feed and render the feed dialog
    * 
    * @param $pFeedId
    */
    private function read($pFeedId) 
    {
        $time = time();
        
        $sql = $this->pdo->prepare("SELECT id, display_name, url FROM feeds WHERE id = :id");
        if ($sql->execute(array(":id" => $pFeedId))) {
            $result  = $sql->fetch();
            $this->feed = new Feed($pFeedId, $result["display_name"], $result["url"], $time);
            $feedXML = @simplexml_load_file($this->feed->getUrl());
            
            if ($feedXML) {
                
                if (!isset($feedXML->channel->item) && !isset($feedXML->item)) 
                {
                    $errorMessage = "could not parse feed at <b>" . $this->feed->getUrl() . "</b>. Please check the XML Structure";
                    include("./view/error.php");
                    exit();
                }
                
                foreach($feedXML->channel->item as $currentStory) {
                    $story = new Story(strip_tags($currentStory->title), strip_tags($currentStory->description), strip_tags($currentStory->link), strip_tags($currentStory->date));
                    $this->feed->addStory($story);
                }
                
                foreach($feedXML->channel->item as $currentStory) {
                    $story = new Story(strip_tags($currentStory->title), strip_tags($currentStory->description), strip_tags($currentStory->link), strip_tags($currentStory->date));
                    $this->feed->addStory($story);
                }

                // this is an exception for rss feeds wich have no items below the channel tag but on the same level
                foreach($feedXML->item as $currentStory) {
                    $story = new Story(strip_tags($currentStory->title), strip_tags($currentStory->description), strip_tags($currentStory->link), strip_tags($currentStory->date));
                    $this->feed->addStory($story);
                }

                // update read timestamp of feed
                $sql = $this->pdo->prepare("UPDATE feeds SET last_read = NOW() WHERE id = :feed_id");
                $sql->execute(array(":feed_id" => $pFeedId));

                $feed = $this->feed;
                include("./view/read_feed.php");   
                exit();
            } else {
                $errorMessage = "could not parse feed at <b>" . $this->feed->getUrl() . "</b>. Please check the URL";
                include("./view/error.php");
                exit();
            }
            
        } else {
            $errorMessage = "Could not read Feed at " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }
    }
}