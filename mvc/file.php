<?php

namespace MVC;

Abstract class File {

    private static $path = 'data/';
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
     * cerate the directory
     * @param string $directoryName
     */
    public static function create($directoryName) {
        mkdir(self::$path . $directoryName);
    }

    /**
     * 
     * @param string $fileName
     * @param string $directoryName
     * @return boolean
     */
    public function isFileExists($fileName, $extension) {
        return file_exists(self::$path . $this->directoryName . $fileName . $extension);
    }

    /**
     * read data from a file
     * @return array()
     */
    protected function read() {
        if ($this->isFileExists($this->fileName, '.php')) {
            return unserialize(gzinflate(
                            base64_decode(
                                    substr(file_get_contents(self::$path . $this->directoryName . $this->fileName . '.php'), strlen(self::$phpPrefix), - strlen(self::$phpSufix))
                            )
            ));
        } else {
            return array();
        }
    }

    /**
     * write in a given file
     * @param array $data
     * @return array
     */
    protected function write(array $data) {
        return file_put_contents(self::$path . $this->directoryName . $this->fileName . '.php', self::$phpPrefix . base64_encode(
                        gzdeflate(serialize($data)))
                . self::$phpSufix);
    }

    /*
     * return boolean
     */

    public function savedHtmlPage($url, $fileName) {
        if ($this->isFileExists($fileName, '.html')) {
            $this->deleteHtmlFile($fileName);
        }
        return file_put_contents(self::$path . $this->directoryName . $fileName . '.html', file_get_contents($url));
    }

    /**
     * 
     * @param string $fileName
     * @return boolean
     */
    public function deleteHtmlFile($fileName = null) {
        if ($this->isFileExists($fileName, '.html')) {
            return unlink(self::$path . $this->directoryName . $fileName . '.html');
        }
        return false;
    }

}
