<?php

namespace Appli\Controllers;

class Users extends \MVC\Controller {

  public static function login() {
    $data = \Appli\Models\User::getInstance()->countAll();
    if ($data->count == 0) {
      self::redirect('users', 'install');
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
    $user = \Appli\Models\User::getInstance()->getByMail($username);
    if (sizeof($user) == 0) {
      $user = \Appli\Models\User::getInstance()->getByUsername($username);
    }
    if (sizeof($user) > 0) {
      if (\MVC\Password::validate_password($password, $user[0]->hash)) {
        $_SESSION['user'] = $user[0]->username;
        $_SESSION['idUser'] = $user[0]->id;
        $_SESSION['language'] = $user[0]->language;
        $_SESSION['email'] = $user[0]->email;
        $_SESSION['token'] = $user[0]->token;
        $_SESSION['admin'] = \Appli\Models\User::getInstance()->isAdmin($user[0]->id);
      } else {
        $_SESSION['errors']['danger'][] = \MVC\Language::T('IncorrectUsername');
        self::redirect('users', 'login');
      }
    }
  }

  static function install() {
    $data = \Appli\Models\User::getInstance()->countAll();
    if ($data->count > 0) {
      self::redirect('users', 'login');
    }
  }

  public static function data_savedInstall(){
    $saved = false;
    $text = '';
    $username = htmlspecialchars(trim(\MVC\A::get('username')));
    $password = htmlspecialchars(trim(\MVC\A::get('password')));
    $repeatPassword = htmlspecialchars(trim(\MVC\A::get('repeatPassword')));
    $language = htmlspecialchars(trim(\MVC\A::get('language')));
    $email = htmlspecialchars(trim(\MVC\A::get('email')));
    if ($password == $repeatPassword) {
      if ($username != '' AND $email != '') {
        $user = \Appli\Models\User::getInstance()->getByUsername($username);
        $mail = \Appli\Models\User::getInstance()->getByMail($email);
        //on vérifie qu'il n'existe pas d'utilisateur utilisant le même pseudo ou le même email
        if (!$user OR !$mail) {
          //on enregistre l'utilisateur
          $user = \Appli\Models\User::getInstance()->newItem();
          $user->username = $username;
          $user->hash = \MVC\Password::create_hash($password);
          $user->userdate = \MVC\Date::getDateNow();
          $user->language = $language;
          $user->email = $email;
          $user->token = md5(uniqid(mt_rand(), true));
          $user->store();
          //on crée le groupe admin
          $group = \Appli\Models\Group::getInstance()->newItem();
          $group->label = 'admin';
          $group->store();
          //on l'affecte à l'utilisateur
          $groupUser = \Appli\Models\GroupUser::getInstance()->newItem();
          $groupUser->idGroup = $group->id;
          $groupUser->idUser = $user->id;
          $groupUser->store();
          $saved = true;
        } else {
          $text = \MVC\Language::T('AccountAlreadyExists');
        }
      } else {
        $text = \MVC\Language::T('EmptyInputs');
      }
    } else {
      $text= \MVC\Language::T('The passwords are differents');
    }
    self::getVue()->data = json_encode(array(
          'text' => $text,
          'saved' => $saved
      ));
  }

  /**
   * permit to save an account
   * 
   *//*
  public static function saved() {
    $username = htmlspecialchars(trim(\MVC\A::get('username')));
    $password = htmlspecialchars(trim(\MVC\A::get('password')));
    $repeatPassword = htmlspecialchars(trim(\MVC\A::get('repeatPassword')));
    $language = htmlspecialchars(trim(\MVC\A::get('language')));
    $email = htmlspecialchars(trim(\MVC\A::get('email')));
    if ($password == $repeatPassword) {
      if ($username != '' AND $email != '') {
        $user = \Appli\Models\User::getInstance()->getByUsername($username);
        $mail = \Appli\Models\User::getInstance()->getByMail($email);
                //on vérifie qu'il n'existe pas d'utilisateur utilisant le même pseudo ou le même email
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
  }*/

}
