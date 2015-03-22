<?php 
require_once("model/User.php");
require_once("AjaxController.php");
require_once("./config/db.php");

/**
* Controller Class for User Objects
* handles Login/Logout
*
* @author Torsten Oppermann
* @since 17.03.2015
*/
class UserController extends AjaxController
{    
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
    
    private $pdo;
    
    public function __construct() 
    {        
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        
        if (isset($_POST["login"])) {
            $this->login();
        } elseif (isset($_GET["logout"])) {
            $this->logout();
        }
    }
    
    /**
    * ajax handling
    */
    public function execute($pRequest)
    {
        // determine the correct internal method
        switch ($pRequest["method"]) {
            case "register":
                $name           = $pRequest["name"];
                $password       = $pRequest["pw"];
                if (!$this->register($name, $password)) {
                    return 1; // return error flag
                }
                break;
            default: 
                echo "Wrong method supplied at UserController";
                break;
        }
    }
    
    /**
    * register a user
    *
    * @returns boolean
    */
    public function register($name, $password)
    {
        // check for incorrect input data
        if ((strlen($name) < 4) || (strlen($password) < 4)) {
            $errorMessage                   = "username or password length must be 4 characters or greater";
            include("./view/error.php"); 
            exit();
        };
        
        // check for incorrect input data
        if ((strlen($name) > 9) || (strlen($password) > 9)) {
            $errorMessage                   = "username or password length cannot exceed 9 characters";
            include("./view/error.php"); 
            exit();
        };
        
        // check if username already exists
        $sql = $this->pdo->prepare("SELECT name FROM users WHERE name = :name");
        $userExists = false;
        if ($sql->execute(array(":name" => $name))) {
            while($row = $sql->fetch()) {
                $userExists = true;
            }
        } else {
            $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
            include("./view/error.php");
        }

        if (!$userExists) {               
            // user does not exist go ahead and save user        
            $sql = $this->pdo->prepare("INSERT INTO users (name, password) VALUES(:name, :pw)");
            if ($sql->execute(array(":name" => $name, "pw" => md5($password)))) {
                return true;
            } else {
                $errorMessage = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST;
                include("./view/error.php");
            }
        }
        
        return false;
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

            $sql        = $this->pdo->prepare("SELECT id, name FROM users WHERE name = :name and password = :password");
            
            if ($sql->execute(array(":name" => $userName, ":password" => $password))) {
                $result = $sql->fetch();
                if (!empty($result)) {
                    $this->user                     = new User($result["id"], $result["name"], $password);
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
    * checks if a user is logged in
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