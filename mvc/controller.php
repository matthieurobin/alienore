<?php

namespace MVC;

class Controller {

    static private $_view;

    static public function redirect($c = null, $a = null, $params = array()) {
        self::$_view = new View($c, $a);
        $controllerName = '\APPLI\\Controllers\\' . $c;
        $controllerName::$a($params);
    }

    static public function setVue($view) {
        return self::$_view = $view;
    }

    /**
     * return the view
     * @return \MVC\Vue
     */
    public static function getVue() {
        return self::$_view;
    }

}
