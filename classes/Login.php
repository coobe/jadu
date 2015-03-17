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
        }
    }
    
    
    private function login() 
    {
        if (empty($_POST['username'])) {
            $this->errors[] = "Please enter your username";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Please enter your password";
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
            // clear user input
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            // create database connection
            $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
            if (!$this->dbConnection->connect_errno) {
                // db query
                $sql = $this->dbConnection->prepare("SELECT name, password FROM users WHERE name = ? and password = ?");
                $sql->bind_param("ss", $username, $password);
                
                
                $result = $sql->execute();
                var_dump($result);
                
            } else {
                // @TODO custom error message depending on the error type
                $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
            }
        }
    }
    
    
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}