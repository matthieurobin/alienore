<?php

namespace Appli\Controllers;

class Account extends \MVC\Controller {
    
    public static function help(){
        
    }
    
    public static function preferences(){
        self::getVue()->language = \Appli\Models\user::getInstance()->getByUsername($_SESSION['user'])[0]->language;
    }
    
    public static function savedLanguagePreference(){
        $user = \Appli\Models\user::getInstance()->getByUsername($_SESSION['user'])[0];
        $user->language = \MVC\A::get('language');
        $user->store();
        $_SESSION['language'] = \MVC\A::get('language');
    }
    
    public static function error(){
        self::getVue()->info = \MVC\Language::T('Token error');
    }

    public static function data_savedPassword(){
        $saved = false;
        $oldPassWord = htmlspecialchars(trim(\MVC\A::get('oldPassword')));
        $user = \Appli\Models\user::getInstance()->getByUsername($_SESSION['user'])[0];
        if(\MVC\Password::validate_password($oldPassWord, $user->password)){
            $newPassword       = htmlspecialchars(trim(\MVC\A::get('newPassword')));
            $repeatNewPassword = htmlspecialchars(trim(\MVC\A::get('repeatNewPassword')));
            if($newPassword == $repeatNewPassword){
                $user->password = \MVC\Password::create_hash($newPassword);
                $user->store();
                $saved = true;
                $text = \MVC\Language::T('The new password was successfully changed');
            }else{
                $text = \MVC\Language::T('The new password and the repeat new password are differents');
            }
        }else{
            $text = \MVC\Language::T('Old password incorrect');
        }
        self::getVue()->data = json_encode(array(
            'saved' => $saved,
            'text'  => $text
        ));
    }
    
}

