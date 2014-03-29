<?php

namespace Appli\M;

class Tags extends \MVC\Table {
    protected $_table = 'tags';
    protected $_tableRow = '\\Appli\\M\\TagsRow';

    
    /*
     * Get All tag sort by the most used ( For the tags cloud ) 
     */
    
    public function getAllTagsByUtilisation() {
        
        return $this->getInstance()->select("SELECT label, COUNT(idTag)AS count FROM tag, taglink WHERE idTag = tag.id GROUP BY idTag") ;
       
    }
    
}