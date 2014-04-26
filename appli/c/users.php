<?php

namespace Appli\C;

class Users extends \MVC\Controleur {

    public static function login() {
        $data = \Appli\M\User::getInstance()->countAll();
        if ($data->count == '0') {
            self::redirect('users', 'create');
        }
        if (isset($_SESSION['user'])) {
            self::redirect('links', 'all');
        }
    }

    public static function logout() {
        unset($_SESSION['user']);
        session_destroy();
        self::redirect('users', 'login');
    }

    public static function auth() {
        $username = htmlspecialchars(\MVC\A::get('username'));
        $password = \MVC\A::get('password');
        $users = \Appli\M\User::getInstance()->getByUsername($username);
        if (sizeof($users) > 0 ) {
            if (\MVC\Password::validate_password($password, $users[0]->hash)) {
                $_SESSION['user'] = $users[0]->username;
                $_SESSION['idUser'] = $users[0]->id;
                $_SESSION['language'] = $users[0]->language;
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('IncorrectUsername');
                self::redirect('users', 'login');
            }
        }
    }

    static function create() {
        $data = \Appli\M\User::getInstance()->countAll();
        if (intval($data->count) > 0) {
            self::redirect('users', 'login');
        }
    }

    /**
     * permit to save an account
     */
    static function saved() {
        $username = htmlentities(trim(\MVC\A::get('username')));
        $password = htmlentities(trim(\MVC\A::get('password')));
        $passwordRepeat = htmlentities(trim(\MVC\A::get('passwordRepeat')));
        if ($password == $passwordRepeat) {
            if ($username != '') {
                $user = \Appli\M\User::getInstance()->getByUsername($username);
                if (!$user) {
                    $user = \Appli\M\User::getInstance()->newItem();
                    $user->username = $username;
                    $user->hash = \MVC\Password::create_hash($password);
                    $user->userdate = \MVC\Date::getDateNow();
                    $user->language = \Install\App::LANGUAGE;
                    $user->store();
                    self::redirect('users', 'login');
                } else {
                    $_SESSION['errors']['danger'][] = \MVC\Language::T('AccountAlreadyExists');
                    self::redirect('users', 'create');
                }
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('EmptyInputs');
                self::redirect('users', 'create');
            }
        } else {
            $_SESSION['errors']['danger'][] = \MVC\Language::T('The passwords are differents');
            self::redirect('users', 'create');
        }
    }

}
