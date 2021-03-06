<?php

namespace Appli\Controllers;

class Users extends \MVC\Controller {

  /**
   * permet d'accéder à la page de connexion si l'utilisateur n'est pas connecté,
   * sinon il est redirigé vers la vue par défaut
   */
  public static function login() {
    $data = \Appli\Models\User::getInstance()->countAll();
    if ($data->count == 0) {
      self::redirect('users', 'install');
    }
    if (isset($_SESSION['idUser'])) {
      self::redirect('links', 'all');
    }
    self::getVue()->canLogin = \MVC\Session::canTryToLogin();
  }

  /**
   * déconnexion de l'utilisateur
   */
  public static function logout() {
    \MVC\Session::logout();
    self::redirect('users', 'login');
  }

  /**
   * authentification de l'utilisateur
   */
  public static function data_auth() {
    if(\MVC\Session::canTryToLogin()){
      $text          = '';
      $error         = false;
      $usernameEmail = htmlspecialchars(trim(\MVC\A::get('usernameEmail')));
      $password      = htmlspecialchars(trim(\MVC\A::get('password')));
      $user          = \Appli\Models\User::getInstance()->getByMail($usernameEmail);
      if (sizeof($user) == 0) {
        $user = \Appli\Models\User::getInstance()->getByUsername($usernameEmail);
      }
      if (sizeof($user) > 0) {
        if (\MVC\Password::validate_password($password, $user[0]->password)) {
          if(\Appli\Models\User::getInstance()->isAdmin($user[0]->id)){
            $admin = true;
          }else{
            $admin = false;
          }
          //génération d'un nouveau token pour la connexion en cours
          $user[0]->token = \MVC\Session::getNewToken();
          $user[0]->store();
          //initialisation de la session utilisateur
          \MVC\Session::initializeUserSession(
            $user[0]->username, 
            $user[0]->email, 
            $user[0]->id, 
            $user[0]->language, 
            $user[0]->token, 
            $admin
            );
        } else {
          $text = \MVC\Language::T('Incorrect username/email or password');
          $error = true;
          \MVC\Session::incrementNbFailures();
        }
      }else{
        $text = \MVC\Language::T('Incorrect username/email or password');
        $error = true;
        \MVC\Session::incrementNbFailures();
      }
      self::getVue()->data = json_encode(array(
        'error' => $error,
        'text'  => $text
        ));
    }else{
      self::getVue()->data = json_encode(array(
        'error' => true,
        'text'  => \MVC\Language::T('You have been banned for 15 minutes due to many failures attempts to login')
        ));
    }
  }


  /**
   * accéder à l'installation : création du premier compte de l'application
   */
  static function install() {
    $data = \Appli\Models\User::getInstance()->countAll();
    if ($data->count > 0) {
      self::redirect('users', 'login');
    }
  }

  /**
   * méthode pour créer un utilisateur
   * @param  string $username 
   * @param  string $email    
   * @param  string $password 
   * @param  string $language 
   * @return object       
   */
  private static function createUser($username, $email, $password, $language = \Config\App::LANGUAGE){
    $user = \Appli\Models\User::getInstance()->newItem();
    $user->username = $username;
    $user->password = \MVC\Password::create_hash($password);
    $user->userdate = \MVC\Date::getDateNow();
    $user->language = $language;
    $user->email    = $email;
    $user->token    = md5(uniqid(mt_rand(), true));
    $user->store();
    return $user;
  }

  /**
   * enregistrer l'installation
   */
  public static function data_savedInstall(){
    if(\Appli\Models\User::getInstance()->countAll()->count == 0){
      $saved = false;
      $text = '';
      $username       = htmlspecialchars(trim(\MVC\A::get('username')));
      $password       = htmlspecialchars(trim(\MVC\A::get('password')));
      $repeatPassword = htmlspecialchars(trim(\MVC\A::get('repeatPassword')));
      $language       = htmlspecialchars(trim(\MVC\A::get('language')));
      $email          = htmlspecialchars(trim(\MVC\A::get('email')));
      if ($password == $repeatPassword) {
        if ($username != '' AND $email != '') {
          $user = \Appli\Models\User::getInstance()->getByUsername($username);
          $mail = \Appli\Models\User::getInstance()->getByMail($email);
        //on vérifie qu'il n'existe pas d'utilisateur utilisant le même pseudo ou le même email
          if (!$user AND !$mail) {
          //on enregistre l'utilisateur
            $user = self::createUser($username, $email, $password, $language);
          //vérifier si le groupe admin existe déjà
            $group = \Appli\Models\Group::getInstance()->getGroupAdmin();
            if(!$group){
            //on crée le groupe admin
              $group = \Appli\Models\Group::getInstance()->newItem();
              $group->label = 'admin';
              $group->store();
            }else{
              $group = $group[0];
            }
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
  }

  /**
   * création d'un compte lorqu'on soumet le formulaire de l'écran utilisateurs
   * 
   */
  public static function data_createUser() {
    $saved    = false;
    $text     = '';
    $username = htmlspecialchars(trim(\MVC\A::get('username')));
    $password = htmlspecialchars(trim(\MVC\A::get('password')));
    $email    = htmlspecialchars(trim(\MVC\A::get('email')));
    if ($username != '' AND $email != '') {
      $user = \Appli\Models\User::getInstance()->getByUsername($username);
      $mail = \Appli\Models\User::getInstance()->getByMail($email);
                //on vérifie qu'il n'existe pas d'utilisateur utilisant le même pseudo ou le même email
      if (!$user AND !$mail) {
        $user = self::createUser($username, $email, $password);
        $userJSON = array(
          'id'       => $user->id,
          'username' => $user->username,
          'email'    => $user->email
          );
        $saved = true;
        $text = \MVC\Language::T('The user was successfully created');
      } else {
        $text = \MVC\Language::T('AccountAlreadyExists');
        $userJSON = null;
      }
    } else {
      $text = \MVC\Language::T('EmptyInputs');
    }
    self::getVue()->data = json_encode(array(
      'text'  => $text,
      'saved' => $saved,
      'user'  => $userJSON
      ));
  }

}
