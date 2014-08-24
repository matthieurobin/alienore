<?php

namespace Appli\Controllers;

class Administration extends \MVC\Controller {
    
    public static function users(){
        if(!$_SESSION['admin']){
            self::redirect('links', 'all');
        }
        
    }

    public static function data_getUsers(){
    	$users = \Appli\Models\User::getInstance()->getUsers();
    	self::getVue()->data = json_encode($users);
    }
    
}

