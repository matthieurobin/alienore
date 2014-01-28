<?php

date_default_timezone_set('UTC');

define('MVC', 'mvc/');
define('INSTALL', 'install/');

//load language
include MVC . 'language.php';
include INSTALL . 'app.php';
include INSTALL . 'path.php';
\MVC\Language::loadLanguage();

//index
header('Content-Type: text/html; charset=utf-8');
include(MVC . 'index.php');
