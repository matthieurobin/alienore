<?php

namespace MVC;

class Pagination {

    //private static $pagination = array();

    public static function getNumberOfPages($nbLinks, $linksPerPage) {
        return ceil($nbLinks / $linksPerPage);
    }

    public static function buildPaging($nbLinks, $page = 1, $linksPerPage = \Install\App::LINKS_PER_PAGE) {
        $maxPage = self::getNumberOfPages($nbLinks, $linksPerPage);
        if ($page > 1) {
            if ($page > $maxPage) {
                $page = $maxPage;
            }
            $limit = ($page * $linksPerPage) - $linksPerPage;
        } else {
            $page = 1;
            $limit = 0;
        }
        return array('limit' => $limit.','.$linksPerPage, 'nbPages' => $maxPage);
    }

}
