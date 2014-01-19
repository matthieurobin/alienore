<?php

namespace MVC;

abstract class Tags extends \MVC\Link {

    public static function displayTags($tags) {
        $tagStr = '';
        if (strstr($tags, ' ')) {
            $tags = explode(' ', $tags);
            $tagStr = $tags;
        } else {
            $tagStr = $tags;
        }
        return $tagStr;
    }

}
