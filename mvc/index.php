<?php

session_start();

function __autoload($class) {
    $chemins = explode('\\', strtolower($class));
    switch ($chemins[0]) {
        case 'config':
            $fichier = CONFIG . $chemins[1] . '.php';
            break;
        case 'mvc':
            $fichier = MVC . $chemins[1] . '.php';
            break;
        default:
            $fichier = \Config\Path::ROOT . implode('/', $chemins) . '.php';
    }
    if (file_exists($fichier)) {
        include $fichier;
    } else {
        var_dump($fichier);
        var_dump($class);
    }
}

if (!isset($_SESSION['user'])) {
    if(\MVC\A::get('c') === 'users'){
        $c = 'users';
        $a = \MVC\A::get('a');
    }else{
        $c = \Config\App::C;
        $a = \Config\App::A;
    }
} else {
    $c = \MVC\A::get('c', 'links');
    $a = \MVC\A::get('a', 'all');
}

$controllerName = '\APPLI\\Controllers\\' . $c;

\MVC\Controller::setVue(new \MVC\View($c, $a));

$controllerName::$a(\MVC\A::getParams());

$controllerName::getVue()->display();
