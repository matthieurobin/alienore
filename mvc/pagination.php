<?php

namespace MVC;

class Pagination {

    //private static $pagination = array();

    public static function getNumberOfPages($nbLinks, $linksPerPage) {
        return ceil($nbLinks / $linksPerPage);
    }

    public static function buildPaging($links, $page = 1, $linksPerPage = 20) {
        $keys = array();
        foreach ($links as $key => $value) {
            $keys[] = $key;
        }

        if (sizeof($keys) > 0) {
            $nbPages = self::getNumberOfPages(sizeof($keys), $linksPerPage);
            $pagination['nbPages'] = $nbPages;
            $pagination['page'] = $page;
            $linksToDisplay = array();

            $i = ($page - 1 ) * $linksPerPage; // Start index.
            $end = $i + $linksPerPage;

            while ($i < $end && $i < count($keys)) {
                $link = $links[$keys[$i]];
                $linksToDisplay[$keys[$i]] = $link;
                $i++;
            }
              $pagination['links'] = $linksToDisplay;
              return $pagination;

        } else {
            return array();
        }
    }

}
