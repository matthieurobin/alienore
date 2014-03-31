<?php

namespace Appli\M;

class Tag extends \MVC\Table {
    protected $_table = 'tag';
    protected $_tableRow = '\\Appli\\M\\TagRow';

    
    /*
     * Get All tag sort by the most used ( For the tags cloud ) 
     */
    
    public function getAllTagsByUtilisation() {
        $query = 'SELECT label,id, COUNT(idTag) AS count FROM tag, taglink WHERE idTag = tag.id GROUP BY idTag';
        return $this->getInstance()->select($query) ;
       
    }
    
    public function getTagByLabel($label){
        $query = 'SELECT * FROM tag WHERE label = \''.$label.'\'';
        return $this->getInstance()->select($query) ;
    }
    
    public function getSearchTag($search){
        $query = 'SELECT * FROM tag WHERE label LIKE \'%'.$search.'%\'';
        return $this->getInstance()->select($query) ;
    }
    
}