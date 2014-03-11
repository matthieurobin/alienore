<?php

namespace MVC;

Abstract class ImportExport {

    public static function exportHtml($data) {
        $str = '<!DOCTYPE NETSCAPE-Bookmark-file-1>'
                . '<Title>Bookmarks</Title>'
                . '<H1>Bookmarks</H1>';
        foreach ($data as $link) {
            $str .= '<DT><A HREF="' . htmlspecialchars($link['url']) . '" ADD_DATE="' . $link['linkdate'] . '"';
            if ($link['tags'] != '') {
                $str .= ' TAGS="' . htmlspecialchars(str_replace(' ', ',', $link['tags'])) . '"';
            }
            $str .= '>' . htmlspecialchars($link['title']) . "</A>\n";
            if ($link['description'] != '') {
                $str .= '<DD>' . htmlspecialchars($link['description']) . "\n";
            }
        }
        return $str;
    }

    //sebsauvage funtion (base)
    public static function import($fileData, $dbdata) {
        $links = [];
        $importCount = 0;
        foreach (explode('<DT>', $fileData) as $html) { // explode is very fast
            $link = array('linkdate' => '', 'title' => '', 'url' => '', 'description' => '', 'tags' => '', 'saved' => 0, 'datesaved' => null, 'extensionfile' => null);
            $d = explode('<DD>', $html);
            if (self::startsWith($d[0], '<A ')) {
                $link['description'] = (isset($d[1]) ? html_entity_decode(trim($d[1]), ENT_QUOTES, 'UTF-8') : '');  // Get description (optional)
                preg_match('!<A .*?>(.*?)</A>!i', $d[0], $matches);
                $link['title'] = (isset($matches[1]) ? trim($matches[1]) : '');  // Get title
                $link['title'] = html_entity_decode($link['title'], ENT_QUOTES, 'UTF-8');
                preg_match_all('! ([A-Z_]+)=\"(.*?)"!i', $html, $matches, PREG_SET_ORDER);  // Get all other attributes
                $raw_add_date = 0;
                foreach ($matches as $m) {
                    $attr = $m[1];
                    $value = $m[2];
                    if ($attr == 'HREF') {
                        $link['url'] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
                    } else if ($attr == 'ADD_DATE') {
                        $link['linkdate'] = intval($value);
                    } else if ($attr == 'TAGS') {
                        $link['tags'] = html_entity_decode(str_replace(',', ' ', $value), ENT_QUOTES, 'UTF-8');
                    }
                }
                if ($link['url'] != '') {
                    if (!self::isUrlIsInDb($dbdata, $link['url'])) {
                        while (!empty($links[$link['linkdate']])) {
                            $raw_add_date++;
                        }
                        $link['linkdate'] = $link['linkdate'] + $raw_add_date;
                        $links[$link['linkdate']] = $link;
                        $importCount++;
                    }
                }
            }
        }
        return array('links' => $links, 'nbLinks' => $importCount);
    }

    public static function isUrlIsInDb($data, $url) {
        $isInDb = false;
        foreach ($data as $link) {
            if ($link['url'] == $url) {
                $isInDb = true;
                break;
            }
        }
        return $isInDb;
    }

    public static function startsWith($haystack, $needle, $case = true) {
        if ($case) {
            return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }

}
