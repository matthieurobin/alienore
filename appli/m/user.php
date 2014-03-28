<?php

namespace Appli\M;

class User extends \MVC\Table {

    protected $_table = 'user';
    protected $_tableRow = '\\Appli\\M\\UserRow';

    
    public function countAll(){
        return $this->getInstance()->select('select count(id) as count from user');
    }
    
    public function getByUsername($username){
        return $this->getInstance()->select('select * from user where username = "'.$username.'"');
    }
}
