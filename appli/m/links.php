<?php

namespace Appli\M;

class Links extends \MVC\Link {
    protected $directoryName = 'links/';
    protected $fileName = 'LinksStore';
    
    /**
     * delete a specific element
     * @param string $id
     */
    public function deleteLink($id) {
        $data = $this->getFileData();
        if (isset($data[$id])) {
            unset($data[$id]);
            $this->setFileData($data);
        }
    }

    /**
     * get a specific element
     * @param string $id
     * @return array()
     */
    public function get($id) {
        if (!is_null($id)) {
            $result = $this->getFileData();
            if (isset($result[$id])) {
                return $result[$id];
            }
        }
    }
    
    /*
     * SebSauvage function
     * return array()
     */
    public function getAllTagsByUtilisation() {
        $tags = array();
        foreach ($this->getFileData() as $link){
            foreach (explode(' ', $link['tags']) as $tag){
                if (!empty($tag)){
                    $tags[$tag] = (empty($tags[$tag]) ? 1 : $tags[$tag] + 1);
                }      
            }
        }
        arsort($tags); // Sort tags by usage (most used tag first)
        return $tags;
    }
    
    public function getLinksByTag($tagSearch){
        $links = array();
        foreach ($this->getFileData() as $link){
            foreach (explode(' ', $link['tags']) as $tag){
                if($tag == $tagSearch){
                    $links[$link['linkdate']] = $link;
                }
            }
        }
        return $links;
    }
    
    public function editTagName($newTagName,$tagEdit){
        $links = $this->getFileData();
        foreach ( $links as $link){
            $tagString = '';
            foreach (explode(' ', $link['tags']) as $tag){
                if($tag == $tagEdit){
                    $tagString .= ' '.$newTagName;
                }else{
                   $tagString .= ' '.$tag; 
                }
            }
            $links[$link['linkdate']]['tags'] = trim($tagString);
        }
        return $links;
    }
    
    public function deleteTag($tagName){
        $links = $this->getFileData();
        foreach ( $links as $link){
            $tagString = '';
            foreach (explode(' ', $link['tags']) as $tag){
                if($tagName != $tag){
                   $tagString .= ' '.$tag; 
                }
            }
            $links[$link['linkdate']]['tags'] = trim($tagString);
        }
        return $links;
    }
        
}
