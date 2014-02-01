<?php

namespace Appli\M;

class Users extends \MVC\FileData {

    protected $directoryName = 'users/';
    protected $fileName = 'UsersStore';

    public function auth($login, $password) {
        $users = $this->getFileData();
        if (isset($users[$login])) {
            if ($users[$login]['password'] == $password) {
                return true;
            }
            return false;
        }
        return false;
    }
    
}
