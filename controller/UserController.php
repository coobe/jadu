<?php 
require_once("model/User.php");

/**
* Controller Class for User Objects
* handles Login/Logout
*
* @author Torsten Oppermann
* @since 17.03.2015
*/
class UserController
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
    private $userName;
    
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
    
    /**
    * @var object
    */
    private $user;
    
    
    public function __construct() 
    {        
        if (isset($_POST["login"])) {
            $this->login();
        } elseif (isset($_GET["logout"])) {
            $this->logout();
        }
    }
    
    /**
    * attempt to login 
    */ 
    private function login() 
    {        
        if (empty($_POST["username"])) {
            $this->errors[] = "Please enter your username";
        } elseif (empty($_POST["password"])) {
            $this->errors[] = "Please enter your password";
        } elseif (!empty($_POST["username"]) && !empty($_POST["password"])) {
            
            $userName   = htmlspecialchars($_POST["username"]);
            $password   = md5(htmlspecialchars($_POST["password"]));
            
            // create database connection
            mysqli_report(MYSQLI_REPORT_STRICT); // enable exceptions
            try {
                $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            } catch (Exception $e) {
                $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
                include("./view/error.php");
            }
            
            
            // check login credentials
            if ($this->dbConnection) {
               
                // db query
                $sql = $this->dbConnection->prepare("SELECT id, name FROM users WHERE name = ? and password = ?");
                $sql->bind_param("ss", $userName, $password);
                $sql->execute();
                $sql->store_result();
                
                // bind result variables
                $sql->bind_result($this->userId, $this->userName);
                $sql->fetch();
                
                if ($sql->num_rows == 1) { // successful login
                    $this->user                     = new User($this->userId, $userName, $password);
                    $this->user->getRssFeeds();
                    
                    $_SESSION["user"]               = $this->user;
                    $_SESSION["user_login_status"]  = 1;
                } else {
                    $_SESSION["user_login_status"]  = 0;
                    $errorMessage                   = "wrong username or password";
                    include("./view/error.php");
                }
                
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
        if (isset($_SESSION["user_login_status"]) && $_SESSION["user_login_status"] == 1) {
            return true;
        }
        
        return false;
    }

    /**
    * @returns Object 
    */
    public function getUser() 
    {
        return $this->user;
    }
}