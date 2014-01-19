<?php

namespace MVC;

class A {

    static function get($var,$defaut=null) {
        //action
        if (isset($_POST[$var])) {
            $a = $_POST[$var];
        } elseif (isset($_GET[$var])) {
            $a = $_GET[$var];
        } else {
            $a = $defaut;
        }
        return $a;
    }
    
    static function getParams(){
        $params=array();
        foreach($_POST as $cle=>$valeur){
            $params[$cle]=$valeur;
        }
        foreach($_GET as $cle=>$valeur){
            $params[$cle]=$valeur;
        }
        
        return $params;
    }
    static function link($c,$a,$texte,$params=array(),$tooltip=''){
        $link='<a href=".?c='.$c.'&a='.$a;
        foreach ($params as $key=>$value) {
            $link.='&'.$key.'='.$value;
        }
        $link.='">'.$texte.'</a>';
        return $link;
    }

}
