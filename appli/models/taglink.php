<?php

namespace Appli\Models;

class Taglink extends \MVC\Table {

    protected $_table = 'taglink';
    protected $_tableRow = '\\Appli\\Models\\TaglinkRow';

    /**
     * chercher le TagLink
     * @param  [int] $idLink
     * @param  [int] $idTag
     * @return [array]         [array of taglink objects]
     */
    public function getTagLink($idLink, $idTag){
        $query  = 'SELECT * FROM taglink WHERE idLInk ='.$idLink.' AND idTag = '.$idTag;
        return $this->getInstance()->select($query);
    }

    /**
     * chercher les tags appartenant à un lien
     * @param  [int] $idLink 
     * @return [array]         [array of taglink objects]
     */
    public function getTags($idLink){
    	$query  = 'SELECT * FROM taglink WHERE idLInk ='.$idLink;
        return $this->getInstance()->select($query);
    }
    
}
    
    