<?php

namespace Appli\Controllers;

class Users extends \MVC\Controller {

    public static function login() {
        $data = \Appli\Models\User::getInstance()->countAll();
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
        $users = \Appli\Models\User::getInstance()->getByUsername($username);
        if (sizeof($users) > 0) {
            if (\MVC\Password::validate_password($password, $users[0]->hash)) {
                $_SESSION['user'] = $users[0]->username;
                $_SESSION['idUser'] = $users[0]->id;
                $_SESSION['language'] = $users[0]->language;
                $_SESSION['token'] = $users[0]->token;
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('IncorrectUsername');
                self::redirect('users', 'login');
            }
        }
    }

    static function create() {
        
    }

    /**
     * permit to save an account
     */
    static function saved() {
        $username = htmlspecialchars(trim(\MVC\A::get('username')));
        $password = htmlspecialchars(trim(\MVC\A::get('password')));
        $passwordRepeat = htmlspecialchars(trim(\MVC\A::get('passwordRepeat')));
        $language = htmlspecialchars(trim(\MVC\A::get('language')));
        $email = htmlspecialchars(trim(\MVC\A::get('email')));
        if ($password == $passwordRepeat) {
            if ($username != '' AND $email != '') {
                $user = \Appli\Models\User::getInstance()->getByUsername($username);
                $mail = \Appli\Models\User::getInstance()->getByMail($email);
                if (!$user AND !$mail) {
                    $user = \Appli\Models\User::getInstance()->newItem();
                    $user->username = $username;
                    $user->hash = \MVC\Password::create_hash($password);
                    $user->userdate = \MVC\Date::getDateNow();
                    $user->language = $language;
                    $user->email = $email;
                    $user->token = md5(uniqid(mt_rand(), true));
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
