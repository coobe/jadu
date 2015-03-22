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
                $this->feed = new Feed(null, $pRequest["feed_name"], $pRequest["feed_url"]);
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
        $sql = $this->pdo->prepare("INSERT INTO jadu.feeds(display_name, url) VALUES(:name, :url);");
        if (!$sql->execute(array(":name" => $this->feed->getName(), ":url" => $this->feed->getUrl()))) {
            $errorMessage = "Could not Insert at Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        } else {
            $sql = $this->pdo->prepare("INSERT INTO jadu.users_feeds(user_id, feed_id) VALUES(:id, LAST_INSERT_ID());");
            if ($sql->execute(array(":id" => $this->user->getUserId()))) {
                include("./view/rss_table.php");
                exit();
            }
        }
    }
    
    /**
    * read a given feed and render the feed dialog
    * 
    * @param $pFeedId
    */
    private function read($pFeedId) 
    {
        $sql = $this->pdo->prepare("SELECT id, display_name, url FROM feeds WHERE id = :id");
        if ($sql->execute(array(":id" => $pFeedId))) {
            $result  = $sql->fetch();
            $this->feed = new Feed($pFeedId, $result["display_name"], $result["url"]);
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