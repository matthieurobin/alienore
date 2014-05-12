<?php

namespace MVC;

abstract class Display {

    public static function displayTag($tag) {
        $tag->label = htmlspecialchars_decode($tag->label);
        return $tag;
    }
    
    public static function displayLink($link){
        $link->title = htmlspecialchars_decode($link->title);
        $link->url = htmlspecialchars_decode($link->url);
        $link->description = htmlspecialchars_decode($link->description);
        return $link;
    }

}
