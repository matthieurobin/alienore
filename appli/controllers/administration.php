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
    	self::getVue()->data = json_encode(array(
    	    'users' => $users,
    	    'token' => $_SESSION['token']
    	));
    }
    
    public static function data_deleteUser(){
        $text = '';
        $error = false;
        $idUser = \MVC\A::get('idUser');
        if(\MVC\A::get('token') == $_SESSION['token']){
            if(!\Appli\Models\User::getInstance()->isAdmin($idUser)){
                \Appli\Models\User::getInstance()->get($idUser)->delete();
                $text = \MVC\Language::T('Account deleted');
            }else{
                $error = true;
                $text = \MVC\Language::T('You can\'t delete an admin account');
            }
            self::getVue()->data = json_encode(array(
                'text' => $text,
                'error' => $error
            ));
        }else{
            self::redirect('links', 'all');
        }
        
    }
    
}

