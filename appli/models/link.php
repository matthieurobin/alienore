<?php

namespace Appli\Models;

class Link extends \MVC\Table {

    protected $_table = 'link';
    protected $_tableRow = '\\Appli\\Models\\LinkRow';

    
    /**
     * compte le nombre de liens d'un utilisateur
     * @param  [int] $idUser
     * @return [array] : array of Link objects
     */
    public function countAll($idUser) {
        $query = 'SELECT COUNT(id) AS count FROM link WHERE idUser= ?';
        return $this->getInstance()->select($query,array($idUser))[0];
    }

    /**
     * chercher les liens pour la page courante
     * @param  [string] $limit  (définit dans le controleur)
     * @param  [int] $idUser
     * @return [array] : array of sql object
     */
    public function getLinksForPage($limit, $idUser) {
        $query = 'SELECT * FROM link WHERE idUser= ? ORDER BY linkdate DESC LIMIT '.$limit;
        return $this->getInstance()->select($query,array($idUser));
    }

    /**
     * chercher les tags appartenant au lien
     * @param  [int] $linkId 
     * @param  [int] $idUser
     * @return [array] : array of tag objects
     */
    public function getLinkTags($linkId,$idUser) {
        $query = 'SELECT DISTINCT tag.id, label FROM tag, taglink t,link WHERE t.idTag = tag.id AND link.id=t.idLink AND t.idLink = ? AND idUser= ?';
        return $this->select($query,array($linkId, $idUser));
    }

    /**
     * chercher les liens identifiés par le tag et pour la page courante
     * @param  [int] $tagId
     * @param  [string] $limit  (définit dans le controleur)
     * @param  [int] $idUser
     * @return [array] : array of link objects
     */
    public function getLinksByTags($tags, $limit, $idUser) {
        $query = 'SELECT * FROM link WHERE id IN ('; 
        $query .= 'SELECT distinct idLink FROM taglink WHERE idTag IN ('.implode(',',$tags).') GROUP BY idLink HAVING COUNT(*) = '. sizeof($tags);
        $query .= ') AND link.idUser = ? ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query,array($idUser));
    }

    /**
     * compter les liens identifiés par le tag
     * utiliser pour effectuer la pagination
     * @param  [int] $tagId 
     * @param  [int] $idUser
     * @return [array] : array of sql object
     */
    public function countLinksByTags($tags, $idUser){
        $query = 'SELECT COUNT(id) as count FROM link WHERE id IN ('; 
        $query .= 'SELECT distinct idLink FROM taglink WHERE idTag IN ('.implode(',',$tags).') GROUP BY idLink HAVING COUNT(*) = '. sizeof($tags);
        $query .= ') AND link.idUser = ?';
        return $this->getInstance()->select($query,array($idUser))[0];
    }
    
    /**
     * chercher les liens correspondant à la recherche pour la page courante
     * @param  [string] $search : longueur > 2
     * @param  [string] $limit (définit dans le controleur)
     * @param  [int] $idUser
     * @return [array] : array of link objects
     */
    public function search($search, $limit, $idUser){
        $query = 'SELECT * FROM link WHERE idUser = ? AND title like ? OR description like ? ORDER BY linkdate DESC LIMIT ' . $limit;
        return $this->getInstance()->select($query, array($idUser, '%'.$search.'%', '%'.$search.'%'));
    }
    
    /**
     * compter les liens correspondant à la recherche
     * @param  [string] $search
     * @param  [int] $idUser
     * @return [array] : array of sql object
     */
    public function countSearch($search, $idUser){
        $query = 'SELECT COUNT(id) as count FROM link WHERE idUser = ? AND title like ? OR description like ?';
        return $this->getInstance()->select($query, array($idUser, '%'.$search.'%', '%'.$search.'%'))[0];
    }
    
    /**
     * [getUserLinks description]
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
    /* public function getUserLinks($userId){
        $query = 'SELECT * FROM link WHERE idUser = ? ORDER BY linkdate DESC ';
        return $this->getInstance()->select($query, array($userId));
    }*/
    
    /**
     * chercher un lien par son url
     * @param  [string] $url 
     * @param  [int] $userId
     * @return [array] : array of sql object
     */
    public function getLinkByUrl($url, $userId){
        $query = 'SELECT * FROM link WHERE idUser = ? AND url = ?'; 
        return $this->getInstance()->select($query, array($userId, $url));
    }

}
