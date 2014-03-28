<?php

namespace Appli\M;

class Tags extends \MVC\Table {
    protected $_table = 'tags';
    protected $_tableRow = 'TagsRow';

    
    /*
     * Get All tag sort by the most used ( For the tags cloud ) 
     */
    
    public function getAllTagsByUtilisation() {
        $tags = array();
       /* foreach ($this->getFileData() as $link) {
            foreach (explode(' ', $link['tags']) as $tag) {
                if (!empty($tag)) {
                    $tags[$tag] = (empty($tags[$tag]) ? 1 : $tags[$tag] + 1);
                }
            }
        }*/
        $results = mysql_query("SELECT DISTINCT idTag FROM taglink") ;
        foreach( $results as $result){
            $tag = mysql_query("SELECT label FROM tag, taglink WHERE idTag = tag.id AND tag.id=".$result) ;
                 if (!empty($tag)) {
                    $tags[$tag] = (empty($tags[$tag]) ? 1 : $tags[$tag] + 1);
                }    
        }
        arsort($tags); // Sort tags by usage (most used tag first)
        return $tags;
    }
    
}