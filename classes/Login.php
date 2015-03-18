<?php 

/**
* Class for Login/Logout related logic
*
* @author Torsten Oppermann
* @since 17.03.2015
*/
class Login
{
    /**
    * stores the db connection
    * @var object 
    */
    private $dbConnection = null;
    
    /**
    * stores error messages for display in the view
    * @var array
    */ 
    public $errors = array();
    
    public function __construct() 
    {
        session_start();
        
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
        if (empty($_POST['username'])) {
            $this->errors[] = "Please enter your username";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Please enter your password";
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
            // clear user input
            $username = htmlspecialchars($_POST["username"]);
            $password = md5(htmlspecialchars($_POST["password"]));
            
            // create database connection
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
            if (!$this->dbConnection->connect_errno) {
                // db query
                $sql = $this->dbConnection->prepare("SELECT name, password FROM users WHERE name = ? and password = ?");
                $sql->bind_param("ss", $username, $password);
                
                
                $result = $sql->execute();
                $sql->store_result(); // binds the last given result to the $sql object
                
                if ($sql->num_rows == 1) { // successfull login
                    $_SESSION['user_name']          = $username;
                    $_SESSION['user_login_status']  = 1;
                } else {
                    $_SESSION['user_login_status']  = 0;
                    $this->errors[]                 = "wrong username / password";
                }
                
                #echo $sql->num_rows;
                
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
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}