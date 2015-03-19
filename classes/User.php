<?php 

/**
* Class for User related logic
*
* @author Torsten Oppermann
* @since 17.03.2015
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
    * @var int
    */
    private $isAdmin = 0;
    
    /**
    * @var array
    */
    private $feedArray = array();
    
    /**
    * stores error messages for display in the view
    * @var array
    */ 
    public $errors = array();
    
    
    
    public function __construct() 
    {
        #session_start();
        
        if (isset($_POST["login"])) {
            $this->login();
        } elseif (isset($_GET["logout"])) {
            $this->logout();
        }
    }
    
    /**
    * checks for correct login data
    */ 
    private function login() 
    {
        if (empty($_POST["username"])) {
            $this->errors[] = "Please enter your username";
        } elseif (empty($_POST["password"])) {
            $this->errors[] = "Please enter your password";
        } elseif (!empty($_POST["username"]) && !empty($_POST["password"])) {
            // clear user input
            $this->name = htmlspecialchars($_POST["username"]);
            $password   = md5(htmlspecialchars($_POST["password"]));
            
            // create database connection
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
            if (!$this->dbConnection->connect_errno) {
                // db query
                $sql = $this->dbConnection->prepare("SELECT id, name, is_admin FROM users WHERE name = ? and password = ?");
                $sql->bind_param("ss", $this->name, $password);
                
                
                $sql->execute();
                /* bind result variables */
                $sql->bind_result($this->userId, $this->name, $this->isAdmin);
                /* fetch values */
                while ($sql->fetch()) {
                    printf ("%s (%s)\n", $this->name, $this->isAdmin);
                }   

                $sql->store_result(); // binds the last given result to the $sql object
                if ($sql->num_rows == 1) { // successfull login
                    $this->getRssFeeds();
                    $_SESSION["user"]               = $this;
                    $_SESSION["user_login_status"]  = 1;
                } else {
                    $_SESSION["user_login_status"]  = 0;
                    $this->errors[]                 = "wrong username / password";
                }
                
                # check first if open $this->dbConnection->close();
                # $sql->num_rows;
                
            } else {
                // @TODO custom error message depending on the error type
                $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
            }
        }
    }
    
    /**
    * ends the current session
    */
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
    }
    
    /**
    * checks if a user is logged in (returns true/false)
    *
    * @returns boolean
    */
    public function isLoggedIn()
    {
        if (isset($_SESSION["user_login_status"]) AND $_SESSION["user_login_status"] == 1) {
            return true;
        }
        
        return false;
    }
    
    public function getName() 
    {
        return $this->name;
    }
    
    /**
    * @returns int
    */
    public function isAdmin() 
    {
        return $this->isAdmin;
    }
    
    /**
    * @returns int
    */
    public function getUserId() 
    {
        return $this->userId;    
    }
    
    /**
    * retrieve all saved RSS Feeds for this user
    */
    public function getRssFeeds() 
    {
        $this->feedArray = array();
        
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);    
        if (!$this->dbConnection->connect_errno) {
            // db query
            $result = $this->dbConnection->query("SELECT feeds.* FROM jadu.feeds "
                                                   . " JOIN jadu.users_feeds ON users_feeds.feed_id = feeds.id "
                                                   . " WHERE users_feeds.user_id = " . $this->userId. ";") or die("a mysql error has occured: " . $this->dbConnection->errno);
            while ($row = $result->fetch_row()) {
                $this->feedArray[] = $row;
            }
                
        } else {
            // @TODO custom error message depending on the error type
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
        }
        
        return $this->feedArray;
    }
}