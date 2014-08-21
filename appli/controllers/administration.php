<?php

namespace Appli\Controllers;

class Administration extends \MVC\Controller {
    
    public static function users(){
        if($_SESSION['admin']){
            self::getVue()->users = \Appli\Models\User::getInstance()->getAll();
        }else{
            self::redirect('links', 'all');
        }
        
    }
    
}

