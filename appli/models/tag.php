<?php

namespace Appli\Models;

class Tag extends \MVC\Table {
    protected $_table = 'tag';
    protected $_tableRow = '\\Appli\\Models\\TagRow';

    
    /**
     * chercher les tags en comptant le nombre d'utilisation 
     * @param  [int] $idUser
     * @return [array] : array of tag objects
     */
    public function getAllTagsByUtilisation($idUser) {
        $query = 'SELECT label,tag.id, COUNT(idTag) AS count FROM tag, taglink, link WHERE idTag = tag.id AND link.id = taglink.idLink AND link.idUser = ? GROUP BY idTag ORDER BY count DESC';
        return $this->getInstance()->select($query, array($idUser));
    }
    
    /**
     * chercher un lien par son libellé
     * @param  [string] $label
     * @return [array] : array of tag objects
     */
    public function getTagByLabel($label){
        $query = 'SELECT tag.id, tag.label FROM tag  WHERE label = ?';
        return $this->getInstance()->select($query, array($label));
    }
    
    /**
     * chercher les tags correspondant à la recherche (label)
     * @param  [string] $search
     * @param  [int] $idUser
     * @return [array] : array of tag objects
     */
    public function getSearchTag($search, $idUser){
        $query = 'SELECT distinct tag.id, tag.label FROM tag,taglink t,link WHERE t.idTag = tag.id AND link.id = t.idLink AND link.idUser = ? AND label LIKE ?';
        return $this->getInstance()->select($query, array($idUser, '%'.$search.'%'));
    }
    
}