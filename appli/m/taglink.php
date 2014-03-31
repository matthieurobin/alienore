<?php

namespace Appli\M;

class Taglink extends \MVC\Table {

    protected $_table = 'taglink';
    protected $_tableRow = '\\Appli\\M\\TaglinkRow';

    
    public function exists($idLink, $idTag){
        $query  = 'SELECT * FROM taglink WHERE idLInk ='.$idLink.' AND idTag = '.$idTag;
        return $this->getInstance()->select($query);
    }
    
    
}
    
    