<?php

namespace Appli\Controllers;

class Account extends \MVC\Controller {
    
    /**
     * accéder à la vue de l'aide
     */
    public static function help(){
        
    }
    
    /**
     * accéder à la vue des préférences
     */
    public static function preferences(){
        self::getVue()->language = \Appli\Models\user::getInstance()->getByUsername($_SESSION['login'])[0]->language;
    }
    
    /**
     * méthode appelée lors de l'envoi du formulaire pour enregistrer la langue
     */
    public static function savedLanguagePreference(){
        $user = \Appli\Models\user::getInstance()->getByUsername($_SESSION['login'])[0];
        $user->language = \MVC\A::get('language');
        $user->store();
        $_SESSION['language'] = \MVC\A::get('language');
    }
    
    /**
     * méthode appelée lors de la suppression d'un lien avec un mauvais token
     * TODO à revoir puisque la suppression se fait par angular
     */
    public static function error(){
        self::getVue()->info = \MVC\Language::T('Token error');
    }

    /**
     * méthode appelée lors de de l'envoi du formulaire pour modifier son mot de passe
     */
    public static function data_savedPassword(){
        $saved = false;
        $oldPassWord = htmlspecialchars(trim(\MVC\A::get('oldPassword')));
        $user = \Appli\Models\user::getInstance()->getByUsername($_SESSION['login'])[0];
        //on vérifie si l'ancien mot de passe correspond avec la bdd
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

