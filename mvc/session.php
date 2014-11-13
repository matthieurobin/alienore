<?php

namespace MVC;

abstract class Session{

	public static $inactivityTimeout = 3600; //1 hour
	public static $banAfter = 4; // ban after this many failures
	public static $banDuration = 900; //15 min

	/**
	 * initialize a session
	 */
	public static function init(){
		if (empty(session_id())) {
            session_start();
        }
    }

	/**
	 * set a key and its value
	 * @param string $key
	 * @param all $value 
	 */
	public static function set($key, $value){
		$_SESSION[$key] = $value;
	}

	/**
	 * get a key and its value
	 * @param  string $key  
	 * @param  string $subKey
	 * @return key value
	 */
	public static function get($key){
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * generate a token
	 * @return string 
	 */
	public static function getNewToken(){
		return md5(uniqid(mt_rand(), true));
	}

	/**
	 * blocked the login for the specified duration
	 */
	public static function ban(){
		self::set('ban',time() + self::$banDuration);
	}

	/**
	 * know if the current session is ban
	 * @return boolean
	 */
	public static function isBan(){
		return self::get('ban');
	}

	/**
	 * know if the user can login
	 * @return boolean 
	 */
	public static function canTryToLogin(){
        if(self::isBan()){
            if(self::get('ban') > time()){
                return false;
            }else{
                self::set('nbFailures', 0);
                unset($_SESSION['ban']);
                return true;
            }
        }
        return true;
    }

	/**
	 * increment the number of failures and ban if nbFailures > nb of possible atempts
	 */
	public static function incrementNbFailures(){
		if(!self::get('nbFailures')) self::set('nbFailures',0);
		$nbFailures = self::get('nbFailures');
		self::set('nbFailures', ++$nbFailures);
		if(self::get('nbFailures') > self::$banAfter){
			self::ban();
		}
	}

	/**
	 *  initialize the user session
	 */
	public static function initializeUserSession($login, $email, $idUser, $language, $token, $isAdmin){
		self::set('login',$login);
		self::set('email',$email);
		self::set('idUser',$idUser);
		self::set('language',$language);
		self::set('token',$token);
		self::set('admin',$isAdmin);
		self::set('expires_on',time() + self::$inactivityTimeout);
	}

	/**
	 * logout : unset the session's variables
	 */
	public static function logout(){
		$_SESSION = array();
	}

	/**
	 * know if the user is logged
	 * @return boolean
	 */
	public static function isLogged(){
		if(!self::get('idUser')){
			return false;
		}else{
			if(!self::get('expires_on')) self::set('expires_on',time() + self::$inactivityTimeout);

			if(self::get('expires_on') < time()){
				self::logout();
				return false;
			}else{
				self::set('expires_on',time() + self::$inactivityTimeout);
				return true;
			}
		}
		
	}

}