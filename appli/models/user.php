<?php

namespace Appli\Models;

class User extends \MVC\Table {

    protected $_table = 'user';
    protected $_tableRow = '\\Appli\\Models\\UserRow';

    /**
     * compter le nombre d'utilisateurs
     * @return [array] [array of sql object]
     */
    public function countAll() {
        return $this->getInstance()->select('SELECT COUNT(id) AS count FROM user')[0];
    }

    /**
     * chercher l'utilisateur identiié par son login
     * @param  [string] $username
     * @return [array]           [array of user objects]
     */
    public function getByUsername($username) {
        return $this->getInstance()->select('SELECT * FROM user WHERE username = ?', array($username));
    }

    public function getByMail($mail) {
        $query = 'SELECT * FROM user WHERE email = ?';
        return $this->getInstance()->select($query,array($mail));
    }

}
