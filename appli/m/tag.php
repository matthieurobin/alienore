<?php

namespace Appli\M;

class Tag extends \MVC\Table {
    protected $_table = 'tag';
    protected $_tableRow = '\\Appli\\M\\TagRow';

    
    /*
     * Get All tag sort by the most used ( For the tags cloud ) 
     */
    
    public function getAllTagsByUtilisation($idUser) {
        $query = 'SELECT label,tag.id, COUNT(idTag) AS count FROM tag, taglink, link WHERE idTag = tag.id AND link.id = taglink.idLink AND link.idUser = ' . $idUser . ' GROUP BY idTag';
        return $this->getInstance()->select($query);
    }
    
    public function getTagByLabel($label,$idUser){
        $query = 'SELECT tag.id, tag.label FROM tag,taglink t,link WHERE t.idTag = tag.id AND t.idLink = link.id AND link.idUser = ' . $idUser . '  AND label = \'' . $label . '\'';
        return $this->getInstance()->select($query);
    }
    
    public function getSearchTag($search, $idUser){
        $query = 'SELECT tag.id, tag.label FROM tag,taglink t,link WHERE t.idTag = tag.id AND link.id = t.idLink AND link.idUser = ' . $idUser . ' AND label LIKE \'%' . $search . '%\'';
        return $this->getInstance()->select($query);
    }
    
}