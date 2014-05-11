<?php

namespace Appli\M;

class User extends \MVC\Table {

    protected $_table = 'user';
    protected $_tableRow = '\\Appli\\M\\UserRow';

    
    public function countAll(){
        return $this->getInstance()->select('SELECT COUNT(id) AS count FROM user')[0];
    }
    
    public function getByUsername($username){
        return $this->getInstance()->select('SELECT * FROM user WHERE username = ?', array($username));
    }
}
