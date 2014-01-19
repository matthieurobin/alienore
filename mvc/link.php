<?php

namespace MVC;

abstract class Link extends \MVC\File{
    
    private $_fileData;
    
     /**
     * 
     * @param int $update
     * @return array
     */
    public function getFileData() {
        if (!isset($this->_fileData)) {
            $this->_fileData = $this->read();
        }
        return $this->_fileData;
    }
    
    /**
     * 
     * @param array $data
     */
    public function setFileData(array $data){
        $this->_fileData = $data;
    }
    
    /**
     * 
     */
    public function savedb() {
        $this->write($this->_fileData);
    }
    
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
    
}
