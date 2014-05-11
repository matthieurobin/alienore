<?php

namespace Appli\M;

class Link extends \MVC\Table {

    protected $_table = 'link';
    protected $_tableRow = '\\Appli\\M\\LinkRow';

    /*
     * count the number of links
     */

    public function countAll($idUser) {
        $query = 'SELECT COUNT(id) AS count FROM link WHERE idUser= ?';
        return $this->getInstance()->select($query,array($idUser))[0];
    }

    public function getLinksForPage($limit, $idUser) {
        $query = 'SELECT * FROM link WHERE idUser= ? ORDER BY linkdate DESC LIMIT '.$limit;
        return $this->getInstance()->select($query,array($idUser));
    }

    /**
     * get the tags of a link
     * @param int $linkId
     * @return object
     */
    public function getLinkTags($linkId,$idUser) {
        $query = 'SELECT DISTINCT tag.id, label FROM tag, taglink t,link WHERE t.idTag = tag.id AND link.id=t.idLink AND t.idLink = ? AND idUser= ?';
        return $this->select($query,array($linkId, $idUser));
    }

    /**
     * 
     * @param int $tagId
     * @return object
     */
    public function getLinksByTag($tagId, $limit, $idUser) {
        $query = 'SELECT * FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ? AND link.idUser = ? ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query,array($tagId,$idUser));
    }
    
    public function countLinksByTag($tagId, $idUser){
       $query = 'SELECT COUNT(id) as count FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ? AND link.idUser = ?';
        return $this->getInstance()->select($query, array($tagId, $idUser))[0];
    }
    
    public function search($search, $limit, $idUser){
        $query = 'SELECT * FROM link WHERE idUser = ? AND title like ? OR description like ? ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query, array($idUser, '%'.$search.'%', '%'.$search.'%'));
    }
    
    public function countSearch($search, $idUser){
        $query = 'SELECT COUNT(id) as count FROM link WHERE idUser = ? AND title like ? OR description like ?';
        return $this->getInstance()->select($query, array($idUser, '%'.$search.'%', '%'.$search.'%'))[0];
    }
    
    /**
     * get the links for an user
     * @param int $userId
     * @return type
     */
    public function getUserLinks($userId){
        $query = 'SELECT * FROM link WHERE idUser = ? ORDER BY linkdate DESC ';
        return $this->getInstance()->select($query, array($userId));
    }
    
    /**
     * get the link if the url exists
     * @param string $url
     * @param id $userId
     * @return type
     */
    public function getLinkByUrl($url, $userId){
        $query = 'SELECT * FROM link WHERE idUser = ? AND url = ?'; 
        return $this->getInstance()->select($query, array($userId, $url));
    }

}
