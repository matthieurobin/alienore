<?php

namespace Appli\M;

class Taglink extends \MVC\Table {

    protected $_table = 'taglink';
    protected $_tableRow = '\\Appli\\M\\TaglinkRow';

    
    public function getTagLink($idLink, $idTag){
        $query  = 'SELECT * FROM taglink WHERE idLInk ='.$idLink.' AND idTag = '.$idTag;
        return $this->getInstance()->select($query);
    }

    public function getTags($idLink){
    	$query  = 'SELECT * FROM taglink WHERE idLInk ='.$idLink;
        return $this->getInstance()->select($query);
    }
    
}
    
    