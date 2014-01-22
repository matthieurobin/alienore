<?php

namespace MVC;

Abstract class File {

    private $path = 'data/';
    private static $phpPrefix = '<?php /* ';
    private static $phpSufix = ' */ ?>';
    private static $_data = array();

    /**
     * 
     * @return object
     */
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$_data[$class])) {
            self::$_data[$class] = new $class();
        }
        return self::$_data[$class];
    }

    /**
     * create the directory
     * @param string $directoryName
     */
    public function create($directoryName) {
        //if main directory exists
        if ($this->isFileExists()) {
            mkdir($this->path . $directoryName, 0777);
        } else {
            //main directory is created
            mkdir($this->path, 0777);
        }
    }

    /**
     * 
     * @param string $fileName
     * @param string $directoryName
     * @return boolean
     */
    public function isFileExists($directoryName = null, $fileName = null, $extension = null) {
        return file_exists($this->path . $directoryName . $fileName . $extension);
    }

    /**
     * read data from a file
     * @return array()
     */
    protected function read() {
        //if file exists
        if ($this->isFileExists($this->directoryName, $this->fileName, '.php')) {
            return unserialize(gzinflate(
                            base64_decode(
                                    substr(file_get_contents($this->path . $this->directoryName . $this->fileName . '.php'), strlen(self::$phpPrefix), - strlen(self::$phpSufix))
                            )
            ));
        } else {
            //file is created
            $this->write(array());
            return $this->read();
        }
    }

    /**
     * write in a given file
     * @param array $data
     * @return array
     */
    protected function write(array $data) {
        //if direcory exists
        if ($this->isFileExists($this->directoryName)) {
            return file_put_contents($this->path . $this->directoryName . $this->fileName . '.php', self::$phpPrefix . base64_encode(
                            gzdeflate(serialize($data)))
                    . self::$phpSufix);
        } else {
            //directory is created
            $this->create($this->directoryName);
            return $this->write($data);
        }
    }

    /*
     * return boolean
     */

    public function savedHtmlPage($url, $fileName) {
        if(getimagesize($url)){
            $extension = '.jpg';
        }else{
            $extension = '.html';
        }
        
        if(!$this->isFileExists($this->directoryName)){
            $this->create($this->directoryName);
        }
        if ($this->isFileExists($this->directoryName, $fileName, $extension)) {
            $this->deleteHtmlFile($fileName);
        }
        return file_put_contents($this->path . $this->directoryName . $fileName . $extension, file_get_contents($url));
    }

    /**
     * 
     * @param string $fileName
     * @return boolean
     */
    public function deleteHtmlFile($fileName = null) {
        if ($this->isFileExists($this->directoryName, $fileName, '.html')) {
            return unlink($this->path . $this->directoryName . $fileName . '.html');
        }else if($this->isFileExists($this->directoryName, $fileName, '.jpg')){
            return unlink($this->path . $this->directoryName . $fileName . '.jpg');
        }
        return false;
    }

}
