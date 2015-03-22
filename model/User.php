<?php 
require_once("Feed.php");

/**
* The User Model
*
* @author Torsten Oppermann
* @since 21.03.2015
*/
class User
{    
    /**
    * @var int
    */
    private $userId;
    
    /**
    * @var string
    */
    private $name;
    
    /**
    * @var string
    */
    private $password;
    
    /**
    * @var array
    */
    private $feedArray = array(); 
       
    
    /**
    * @param $pId, $pName, $pPassword
    */
    public function __construct($pId, $pName, $pPassword) 
    {
        
        $this->userId   = $pId;
        $this->name     = $pName;
        $this->password = $pPassword;
    }
    
    /**
    * retrieve all saved RSS Feeds for this user
    * @return array
    */
    public function getRssFeeds() 
    {
        $this->feedArray = array();
        $pdo             = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $sql             = $pdo->prepare("SELECT id, display_name, url FROM feeds JOIN users_feeds ON users_feeds.feed_id = feeds.id WHERE users_feeds.user_id = :userId");
        if ($sql->execute(array(":userId" => $this->userId))) {
            while($row = $sql->fetch()) {
                $this->feedArray[] = new Feed($row["id"], $row["display_name"], $row["url"]);
            }
        } else {
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
        }
        
        return $this->feedArray;
    }
    
    /**
    * @return string
    */
    public function getName() 
    {
        return $this->name;
    }
    
    /**
    * @return int
    */
    public function getUserId() 
    {
        return $this->userId;
    }
    
}