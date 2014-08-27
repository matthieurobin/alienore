<?php

namespace Config;

class App {
    
    CONST C = "users"; //default controller
    CONST A = "login"; //default action
    CONST NAME = 'alienore'; //application name
    CONST LANGUAGE = 'fr'; //default application language
    CONST VERSION = '0.13.0'; //application version
    
    //links per page
    CONST LINKS_PER_PAGE = 20;
    
    //MySQL connection
    CONST BDD_USER = 'root';
    CONST BDD_NAME = 'alienore';
    CONST BDD_HOST = 'localhost';
    CONST BDD_PASSWORD = '';
}
