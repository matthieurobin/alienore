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
    public function saveData() {
        $this->write($this->_fileData);
    }    
}
