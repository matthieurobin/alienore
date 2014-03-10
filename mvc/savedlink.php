<?php

namespace MVC;

class SavedLink extends \MVC\File {

    public function isImg($url) {
        $extension = '.html';
        if (getimagesize($url)) {
            $extension = '.jpg';
        }
        return $extension;
    }

    /*
     * return boolean
     */

    public function savedHtmlPage($url, $fileName) {
        //$fileName = $this->smallHash($fileName);

        if (!$this->isFileExists($this->directoryName)) {
            $this->create($this->directoryName);
        }
        //if ($this->isFileExists($this->directoryName, $fileName, $extension)) {
        //  $this->deleteHtmlFile($fileName);
        //}
        $extension = $this->isImg($url);
        if ($extension === '.html') {
            $file = file_get_contents($url);
            if ($file) {
                return file_put_contents($this->path . $this->directoryName . $fileName . $extension, $file);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 
     * @param string $fileName
     * @return boolean
     */
    public function deleteHtmlFile($fileName = null) {
        //$fileName = $this->smallHash($fileName);
        if ($this->isFileExists($this->directoryName, $fileName, '.html')) {
            return unlink($this->path . $this->directoryName . $fileName . '.html');
        }
        return false;
    }

    public function getPathToSavedLink($fileName) {
        //$fileName = $this->smallHash($fileName);
        if ($this->isFileExists($this->directoryName, $fileName, '.html')) {
            return $this->path . $this->directoryName . $fileName . '.html';
        }
    }

    public function smallHash($text) {
        $t = rtrim(hash('crc32', $text), '=');
        return strtr($t, '+/', '-_');
    }

}
