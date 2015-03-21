<?php

/**
* Model Class of a RSS Feed-Story
*
* @author Torsten Oppermann
* @date 21.03.2015
*/
class Story
{    
    /**
    * @var string
    */
    private $title;
    
    /**
    * @var string
    */
    private $description;
    
    /**
    * @var string
    */
    private $link;
    
    /**
    * @var string
    */
    private $date;
    
    
    /**
    * @param $pTitle, $pDescription, $pLink, $pDate
    */ 
    public function __construct($pTitle, $pDescription, $pLink, $pDate) 
    {
        $this->title        = $pTitle;
        $this->description  = $pDescription;
        $this->link         = $pLink;
        $this->date         = $pDate;
    }
    
    /**
    * @returns string
    */ 
    public function getTitle() 
    {
        return $this->title;
    }
    
    /**
    * @returns string
    */ 
    public function getDescription() 
    {
        return $this->description;
    }
    
    /**
    * @returns string
    */ 
    public function getLink() 
    {
        return $this->link;
    }
    
    /**
    * @returns string
    */ 
    public function getDate() 
    {
        return $this->date;
    }
}

