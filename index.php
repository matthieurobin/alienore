<?php

date_default_timezone_set('UTC');

define('MVC', 'mvc/');
define('CONFIG', 'config/');

//load language
include MVC . 'language.php';
include CONFIG . 'app.php';
include CONFIG . 'path.php';
\MVC\Language::loadLanguage();

//index
header('Content-Type: text/html; charset=utf-8');
include(MVC . 'index.php');
