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
    * @var int
    */
    private $id;
    
    /**
    * @param $pName, $pUrl
    */ 
    public function __construct($pId, $pName, $pUrl) 
    {
        $this->id           = $pId;
        $this->name         = $pName;
        $this->url          = $pUrl;
    }
    
    
    /**
    * @returns int
    */ 
    public function getId() 
    {
        return $this->id;
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

