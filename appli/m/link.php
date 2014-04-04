<?php

namespace Appli\M;

class Link extends \MVC\Table {

    protected $_table = 'link';
    protected $_tableRow = '\\Appli\\M\\LinkRow';

    /*
     * count the number of links
     */

    public function countAll() {
        return $this->getInstance()->select('select count(id) as count from link')[0];
    }

    public function getLinksForPage($limit) {
        $query = 'SELECT * FROM link LIMIT ' . $limit;
        return $this->getInstance()->select($query);
    }

    /**
     * get the tags of a link
     * @param int $linkId
     * @return object
     */
    public function getLinkTags($linkId) {
        $query = 'SELECT DISTINCT id, label FROM tag, taglink t WHERE t.idTag = tag.id AND t.idLink = ' . $linkId;
        return $this->select($query);
    }

    /**
     * 
     * @param int $tagId
     * @return object
     */
    public function getLinksByTag($tagId, $limit) {
        $query = 'SELECT * FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ' . $tagId .' LIMIT ' . $limit;
        return $this->getInstance()->select($query);
    }
    
    public function countLinksByTag($tagId){
       $query = 'SELECT COUNT(id) as count FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ' . $tagId;
       return $this->getInstance()->select($query)[0]; 
    }
    
    public function search($search, $limit){
        $query = 'SELECT * FROM link WHERE title like \'%'.$search.'%\' OR description like \'%'.$search.'%\' LIMIT '. $limit;
        return $this->getInstance()->select($query);
    }
    
    public function countSearch($search){
        $query = 'SELECT COUNT(id) as count FROM link WHERE title like \'%'.$search.'%\' OR description like \'%'.$search.'%\'';
        return $this->getInstance()->select($query)[0];
    }
    
    public function getUserLinks($userId){
        $query = 'SELECT * FROM link WHERE idUser = '. $userId;
        return $this->getInstance()->select($query);
    }

}
