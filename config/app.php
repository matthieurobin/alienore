<?php

namespace Config;

class App {
    
    CONST C = "users"; //default controller
    CONST A = "login"; //default action
    CONST NAME = 'Alienore'; //application name
    CONST LANGUAGE = 'fr'; //default application language
    CONST VERSION = '0.14.0'; //application version
    
    //links per page
    CONST LINKS_PER_PAGE = 20;
    
    //MySQL connection
    CONST BDD_USER = 'matthieurobin';
    CONST BDD_NAME = 'alienore';
    CONST BDD_HOST = '172.17.248.73';
    CONST BDD_PASSWORD = '';
}
