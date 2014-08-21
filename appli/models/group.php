<?php

namespace Appli\Models;

class Group extends \MVC\Table {
    protected $_table = '`group`'; //cote pour éviter de rentrer en conflit avec un mot réservé par SQL
    protected $_tableRow = '\\Appli\\Models\\GroupRow';

    
}