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
        $query = 'SELECT DISTINCT id, label FROM tag INNER JOIN taglink t WHERE t.idLink = ' . $linkId;
        return $this->select($query);
    }

    /**
     * 
     * @param int $tagId
     * @return object
     */
    public function getLinksByTag($tagId) {
        $query = 'SELECT * FROM link, taglink WHERE link.id = taglink.idLink AND taglink.idTag = ' . $tagId;
        return $this->getInstance()->select($query);
    }

}
