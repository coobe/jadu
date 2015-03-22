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
    * @var string
    */
    private $lastRead = 0;
    
    /**
    * @param $pName, $pUrl
    */ 
    public function __construct($pId, $pName, $pUrl, $pLastRead) 
    {
        $this->id                = $pId;
        $this->name              = $pName;
        $this->url               = $pUrl;
        $this->lastRead          = $pLastRead;
    }
    
    
    /**
    * @returns int
    */ 
    public function getId() 
    {
        return $this->id;
    }
    
    /**
    * @param int
    */ 
    public function setLastRead() 
    {
        $this->lastRead = time();
    }
    
    /**
    * @returns int
    */ 
    public function getLastRead() 
    {
        return $this->lastRead;
    }
    
    /**
    * @returns string
    */ 
    public function getUrl() 
    {
        return $this->url;
    }
    
    /**
    * @returns string
    */ 
    public function getName() 
    {
        return $this->name;
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

