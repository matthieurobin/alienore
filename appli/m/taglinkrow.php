<?php

namespace Appli\M;

class TaglinkRow extends \MVC\TableRow {
    
    public function deleteTagLink(){
    	$query = 'delete from taglink where idTag = ' . $this->idTag . ' and idLink = '.$this->idLink;
    	$pdo = \MVC\Connexion::get();
        $queryPrepare = $pdo->prepare($query);
        return $queryPrepare->execute(array());
    }
   
}

