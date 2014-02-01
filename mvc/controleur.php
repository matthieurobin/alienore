<?php

namespace MVC;

class Controleur{
    static private $_vue;

    static public function redirect($c = null, $a = null, $params = array()) {
        self::$_vue = new Vue($c, $a);
        $nomControleur = '\APPLI\\C\\' . $c;
        $nomControleur::$a($params);
    }

    static public function setVue($vue) {
        return self::$_vue = $vue;
    }

    /**
     * return the view
     * @return \MVC\Vue
     */
    public static function getVue() {
        return self::$_vue;
    }

}