<?php

namespace MVC;

class SavedLink extends \MVC\File {

    private function isImg($url) {
        $isImg = false;
        if (getimagesize($url)) {
            $isImg = true;
        }
        return $isImg;
    }

    function getExtension($url){
        if($this->isImg($url)){
            $size = getimagesize($url);
            $extension = str_replace('image/', '.', $size['mime']);
        }else{
            $extension = '.html';
        }
        return $extension;
    }
    
    /*
     * return boolean
     */

    public function savedHtmlPage($url, $fileName) {
        if (!$this->isFileExists($this->directoryName)) {
            $this->create($this->directoryName);
        }
        $extension = $this->getExtension($url);
        $file = file_get_contents($url);
        if ($file) {
            return file_put_contents($this->path . $this->directoryName . $fileName . $extension, $file);
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $fileName
     * @return boolean
     */
    public function deleteHtmlFile($fileName,$extension) {
        //$fileName = $this->smallHash($fileName);
        if ($this->isFileExists($this->directoryName, $fileName, $extension)) {
            return unlink($this->path . $this->directoryName . $fileName . $extension);
        }
        return false;
    }

    public function getPathToSavedLink($fileName,$extension){
        //$fileName = $this->smallHash($fileName);
        if ($this->isFileExists($this->directoryName, $fileName, $extension)) {
            return $this->path . $this->directoryName . $fileName . $extension;
        }
    }

    public function smallHash($text) {
        $t = rtrim(hash('crc32', $text), '=');
        return strtr($t, '+/', '-_');
    }

}
