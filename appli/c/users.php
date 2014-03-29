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
        var_dump($users);
        if (sizeof($users) > 0 ) {
            if (\MVC\Password::validate_password($password, $users[0]->hash)) {
                $_SESSION['user'] = $users[0]->username;
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('IncorrectUsername');
                self::redirect('users', 'login');
            }
        }
    }

    static function create() {
        $data = \Appli\M\User::getInstance()->countAll();
        if (intval($data[0]->count) > 0) {
            self::redirect('users', 'login');
        }
    }

    /**
     * permit to save an account
     */
    static function saved() {
        $username = htmlspecialchars(\MVC\A::get('username'));
        $password = \MVC\A::get('password');
        $passwordRepeat = \MVC\A::get('passwordRepeat');
        if ($password == $passwordRepeat) {
            if ($username != '') {
                /*$users = \Appli\M\Users::getInstance();
                $data = $users->getFileData();
                if (!isset($data[$username])) {
                    $user = array(
                        'username' => $username,
                        'hash' => \MVC\Password::create_hash(\MVC\A::get('password')),
                        'userdate' => \MVC\Date::getDateNow()
                    );

                    $data[$username] = $user;
                    $users->setFileData($data);
                    $users->saveData();
                    self::redirect('users', 'login');
                } else {
                    $_SESSION['errors']['danger'][] = \MVC\Language::T('AccountAlreadyExists');
                    self::redirect('users', 'create');
                }*/
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
