<?php
require("AbstractController.php");
require("./config/db.php");
require("./classes/User.php");

class FeedController extends AbstractController
{
    private $user;
    private $dbConnection;
    
    public function execute($request)
    {
        session_start();
        $this->user = $_SESSION["user"];
        
        $feedId = $request["feed"];
        
        switch ($request["method"]) {
            case "delete":
                $this->delete($feedId);
            break;
            default: 
                echo "DEFAULT";
            break;
        }
    }
    
    private function delete($pFeedId)
    {
        // create database connection
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
        if (!$this->dbConnection->connect_errno) {
            // db query
            $result = $this->dbConnection->query("DELETE FROM jadu.feeds WHERE id = " . $pFeedId . ";") or die("a mysql error has occured: " . $this->dbConnection->errno);
                
        } else {
            // @TODO custom error message depending on the error type
            $this->errors[] = "Could not connect to Database " . DB_NAME . " at "  . DB_HOST ;
        }
        
        include("./views/rss_table.php");
        exit();
     
            
            /*
            <div class="col-md-8 col-md-offset-2">
        <table id="rss-table" class="table table-hover">
            <caption>Your RSS Feeds</caption>
            <tbody>
                <tr>
                    <th class="hidden">Id</th>
                    <th>Url</th>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                foreach ($user->getRssFeeds() as $feed) { ?>
                    <tr>
                        <td class="hidden"><?php echo $feed[0] ?></td>
                        <td><?php echo $feed[1] ?></td>
                        <td><?php echo $feed[2] ?></td>
                        <td><button class="btn-delete btn-danger" feed-id="<?php echo $feed[0]; ?>">delete</button></td>
                        <td><button class="btn-primary">edit</button></td>
                        <td><button class="btn-success">activate</button></td>
                    </tr>
                <?php
                }
                ?>
                
                
            </tbody>
        </table>
    </div>*/
    }
}