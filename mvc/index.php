<?php

session_start();

$_SESSION['errors'] = array('danger' => array(), 'info' => array(), 'success' => array());

function __autoload($class) {
    $chemins = explode('\\', strtolower($class));
    switch ($chemins[0]) {
        case 'install':
            $fichier = INSTALL . $chemins[1] . '.php';
            break;
        case 'mvc':
            $fichier = MVC . $chemins[1] . '.php';
            break;
        default:
            $fichier = \Install\Path::ROOT . implode('/', $chemins) . '.php';
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
        $c = \Install\App::C;
        $a = \Install\App::A;
    }
} else {
    $c = \MVC\A::get('c', 'links');
    $a = \MVC\A::get('a', 'all');
}

$controllerName = '\APPLI\\Controllers\\' . $c;

\MVC\Controller::setVue(new \MVC\View($c, $a));

$controllerName::$a(\MVC\A::getParams());

$controllerName::getVue()->display();
