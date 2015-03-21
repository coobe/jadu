<?php 
/**
* The User Model
*
* @author Torsten Oppermann
* @since 21.03.2015
*/
class User
{
    /**
    * stores the db connection
    * @var object 
    */
    private $dbConnection = null;
    
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
        
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);    
        if (!$this->dbConnection->connect_errno) {
            
            // db query
            $result = $this->dbConnection->query("SELECT feeds.* FROM jadu.feeds "
                                                   . " JOIN jadu.users_feeds ON users_feeds.feed_id = feeds.id "
                                                   . " WHERE users_feeds.user_id = " . $this->userId . ";") or die("a mysql error has occured: " . $this->dbConnection->errno);
            while ($row = $result->fetch_row()) {
                $this->feedArray[] = $row;
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