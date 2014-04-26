<?php

namespace Appli\M;

class Link extends \MVC\Table {

    protected $_table = 'link';
    protected $_tableRow = '\\Appli\\M\\LinkRow';

    /*
     * count the number of links
     */

    public function countAll($idUser) {
        $query = 'SELECT COUNT(id) AS count FROM link WHERE idUser= ' . $idUser;
        return $this->getInstance()->select($query)[0];
    }

    public function getLinksForPage($limit, $idUser) {
        $query = 'SELECT * FROM link WHERE idUser=' . $idUser . ' ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query);
    }

    /**
     * get the tags of a link
     * @param int $linkId
     * @return object
     */
    public function getLinkTags($linkId,$idUser) {
        $query = 'SELECT DISTINCT tag.id, label FROM tag, taglink t,link WHERE t.idTag = tag.id AND link.id=t.idLink AND t.idLink = ' . $linkId . ' AND idUser= ' . $idUser;
        return $this->select($query);
    }

    /**
     * 
     * @param int $tagId
     * @return object
     */
    public function getLinksByTag($tagId, $limit, $idUser) {
        $query = 'SELECT * FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ' . $tagId . ' AND link.idUser = ' . $idUser . ' ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query);
    }
    
    public function countLinksByTag($tagId, $idUser){
       $query = 'SELECT COUNT(id) as count FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ' . $tagId . ' AND link.idUser =' . $idUser;
        return $this->getInstance()->select($query)[0];
    }
    
    public function search($search, $limit, $idUser){
        $query = 'SELECT * FROM link WHERE idUser = ' . $idUser . ' AND title like \'%' . $search . '%\' OR description like \'%' . $search . '%\' AND idUser =' . $idUser . ' ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query);
    }
    
    public function countSearch($search, $idUser){
        $query = 'SELECT COUNT(id) as count FROM link WHERE idUser = ' . $idUser . ' AND title like \'%' . $search . '%\' OR description like \'%' . $search . '%\'AND idUser =' . $idUser . '  ';
        return $this->getInstance()->select($query)[0];
    }
    
    /**
     * get the links for an user
     * @param int $userId
     * @return type
     */
    public function getUserLinks($userId){
        $query = 'SELECT * FROM link WHERE idUser = '. $userId .' ORDER BY linkdate DESC ';
        return $this->getInstance()->select($query);
    }
    
    /**
     * get the link if the url exists
     * @param string $url
     * @param id $userId
     * @return type
     */
    public function getLinkByUrl($url, $userId){
        $query = 'SELECT * FROM link WHERE idUser = '. $userId .' AND url = \''. $url .'\''; 
        return $this->getInstance()->select($query);
    }

}
