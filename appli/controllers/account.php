<?php

namespace Appli\Controllers;

class Account extends \MVC\Controller {
    
    public static function help(){
        
    }
    
    public static function preferences(){
        self::getVue()->language = \Appli\Models\user::getInstance()->getByUsername($_SESSION['user'])[0]->language;
    }
    
    public static function savedPreferences(){
        $user = \Appli\Models\user::getInstance()->getByUsername($_SESSION['user'])[0];
        $user->language = \MVC\A::get('language');
        $user->store();
        $_SESSION['language'] = \MVC\A::get('language');
        $_SESSION['errors']['success'] = \MVC\Language::T('Preferences was successful applied');
    }
    
    public static function error(){
        self::getVue()->info = \MVC\Language::T('Token error');
    }
    
}

