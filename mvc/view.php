<?php
namespace MVC;

class View{
    /**
     *
     * @var String
     */
    private $_fichier; 
    /**
     *
     * @var array
     */
    private $_data;
    public function __construct($c,$a) {
        $this->_fichier= \Config\Path::VIEW.strtolower($c.'/'.$a).'.php';        
        $this->_data=array();
    }
    public function display(){
        if(file_exists(\Config\Path::VIEW.'header.php')){
            include \Config\Path::VIEW.'header.php';
        }
        include $this->_fichier;
        if(file_exists(\Config\Path::VIEW.'footer.php')){
            include \Config\Path::VIEW.'footer.php';
        }
    }
    public function setFichier($fichier){
        if(substr($fichier, -4)!='.php'){
            $fichier.='.php';
        }
        $this->_fichier= \Config\Path::VIEW.$fichier;        
    }
    public function __set($cle,$valeur){
        return $this->_data[$cle]=$valeur;
    }
    public function __get($cle){
        return $this->_data[$cle];
    }
}