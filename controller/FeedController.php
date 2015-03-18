<?php
require("AbstractController.php");

class FeedController extends AbstractController
{
    public function execute($request)
    {
        #var_dump($request);
        #echo "HELLO FROM FEEDCONTROLLER";
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
        echo "delete function called for " . $pFeedId;
    }
}