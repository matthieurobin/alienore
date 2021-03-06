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

    /**
     * chercher l'utilisateur par son email
     * @param  string $mail 
     * @return array     
     */
    public function getByMail($mail) {
        $query = 'SELECT * FROM user WHERE email = ?';
        return $this->getInstance()->select($query,array($mail));
    }

    /**
     * savoir si l'utilisateur fait parti du groupe admin
     * @param  id  $idUser
     * @return boolean 
     */
    public function isAdmin($idUser){
        $query = 'SELECT * FROM groupuser where idGroup = (SELECT idGroup FROM `group` where label = "admin") and idUser = ?';
        return $this->select($query,array($idUser));
    }

    /**
     * chercher tous les utilisateurs de l'application
     * @return array 
     */
    public function getUsers(){
        $query = 'SELECT id, username, email FROM user';
        return $this->select($query);
    }

}
