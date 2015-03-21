<?php

/**
* Model Class of a RSS Feed
* 
* @author Torsten Oppermann
* @date 21.03.2015
*/
class Feed
{    
    /**
    * @var array
    */
    private $stories = array();
    
    /**
    * @var string
    */
    private $name;
    
    /**
    * @var string
    */
    private $url;
    
    /**
    * @param $pName, $pUrl
    */ 
    public function __construct($pName, $pUrl) 
    {
        $this->name         = $pName;
        $this->url          = $pUrl;
    }
    
    /**
    * @returns string
    */ 
    public function getName() 
    {
        return $this->name;
    }
    
    /**
    * @returns string
    */ 
    public function getUrl() 
    {
        return $this->url;
    }
    
    /**
    * @param Story
    */
    public function addStory($pStory) 
    {
        array_push($this->stories, $pStory);
    }
    
    /**
    * @returns array
    */
    public function getStories() 
    {
        return $this->stories;
    }
}

