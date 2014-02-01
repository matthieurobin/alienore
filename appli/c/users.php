<?php

namespace Appli\C;

class Users extends \MVC\Controleur {

    public static function login() {
        $users = \Appli\M\Users::getInstance();
        $data = $users->getFileData();
        if (sizeof($data) === 0) {
            self::redirect('users', 'create');
        }
    }

    public static function logout() {
        unset($_SESSION['user']);
        session_destroy();
        self::redirect('user', 'login');
    }

    static function auth() {
        $username = htmlspecialchars(\MVC\A::get('username'));
        $password = sha1(\MVC\A::get('password'));
        if (\Appli\M\Users::getInstance()->auth($username, $password)) {
            $users = \Appli\M\Users::getInstance()->getFileData();
            $_SESSION['user'] = $users[$username];
            self::redirect('links', 'all');
        } else {
            self::redirect('users', 'login');
        }
    }

    static function create() {
        
    }

    static function saved() {
        $username = htmlspecialchars(\MVC\A::get('username'));
        $password = sha1(\MVC\A::get('password'));
        if ($username != '') {
            $users = \Appli\M\Users::getInstance();
            $data = $users->getFileData();
            if (!isset($data[$username])) {
                $user = array(
                    'username' => $username,
                    'password' => $password,
                    'userdate' => \MVC\Date::getDateNow()
                );

                $data[$username] = $user;
                $users->setFileData($data);
                $users->saveData();
                self::redirect('links', 'all');
            }else{
                self::redirect('users', 'create');
            }
        } else {
            self::redirect('users', 'create');
        }
    }

}
