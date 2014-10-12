<?php

namespace Appli\Controllers;

class Administration extends \MVC\Controller {
    
    /**
     * accéder à la vue des utilisateurs, accessible si on fait parti du groupe admin
     */
    public static function users(){
        //todo faire une requete SQL (plus sécurisé ?)
        if(!$_SESSION['admin']){
            self::redirect('links', 'all');
        }
        
    }

    /**
     * méthode appelée lors de l'initialisation de la vue 'users'
     */
    public static function data_getUsers(){
    	$users = \Appli\Models\User::getInstance()->getUsers();
    	self::getVue()->data = json_encode($users);
    }
    
}

