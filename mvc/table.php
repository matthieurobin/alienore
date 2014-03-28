<?php

namespace MVC;

abstract class Table {

    protected $_tableRow = '\\MVC\\TableRow';
    private static $_pdo;
    private static $_data = array();
    private $_primaryKey = 'id';

    private function __construct($modeleEnregistrement = '\\MVC\\TableRow') {
        //$this->_tableName=$table;
       // $this->_tableRow = $modeleEnregistrement;
    }

    /**
     * 
     * @return Table
     */
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$_data[$class])) {
            self::$_data[$class] = new $class();
        }
        return self::$_data[$class];
    }

    private function pdo() {
        if (!isset(self::$_pdo)) {
            self::$_pdo = \MVC\Connexion::get();
        }
        return self::$_pdo;
    }

    public function get($id, $reload = false) {
        static $data = array();

        if (!isset($data[$this->_tableRow][$id]) or $reload) {
            $query = 'select * from ' . $this->_table .
                    ' where ' . $this->_primaryKey . ' = ?';
            $queryPrepare = $this->pdo()->prepare($query);
            $queryPrepare->execute(array($id));
            $result = $queryPrepare->fetchAll(
                    \PDO::FETCH_CLASS, $this->_tableRow
            );
            if (isset($result[0])) {
                $result[0]->setTable($this->_table);
                $data[$this->_tableRow][$id] = $result[0];
            } else {
                $data[$this->_tableRow][$id] = null;
            }
        }
        return $data[$this->_tableRow][$id];
    }

    function getAll($order = null) {
        $query = 'select * from ' . $this->_table;
        if (!is_null($order)) {
            $query.=' order by ' . $order;
        }
        return $this->pdo()->query($query)->fetchAll(
                        \PDO::FETCH_CLASS, $this->_tableRow
        );
    }

    function getListe($libelle = 'libelle', $order = null) {
        if (is_null($order)) {
            $order = $libelle;
        }
        $listeObjets = $this->getAll($order);
        $liste = array();
        foreach ($listeObjets as $objet) {
            $liste[$objet->id] = $objet->$libelle;
        }
        return $liste;
    }

    function exists($id) {
        $query = 'select * from ' . $this->_table .
                ' where ' . $this->_primaryKey . ' = ?';
        $queryPrepare = $this->pdo()->prepare($query);
        $queryPrepare->execute(array($id));
        $result = $queryPrepare->fetchAll(
                \PDO::FETCH_CLASS, $this->_tableRow
        );
        return sizeof($result) > 0;
    }

    function newItem() {
        $item = new $this->_tableRow();
        $item->setTable($this->_table);
        $query = 'show columns from ' . $this->_table;
        $colonnes = $this->pdo()->query($query)->fetchAll(\PDO::FETCH_CLASS);
        foreach ($colonnes as $col) {
            $field = $col->Field;
            $item->$field = null;
        }
        return $item;
    }

    function where($where, $params) {
        $query = 'select * from ' . $this->_table . ' where ' . $where;
        $queryPrepare = $this->pdo()->prepare($query);
        $queryPrepare->execute($params);
        $result = $queryPrepare->fetchAll(
                \PDO::FETCH_CLASS, $this->_tableRow
        );
        foreach ($result as $o) {
            $o->setTable($this->_table);
        }
        return $result;
    }

    function whereFirst($where, $params) {
        $result = $this->where($where, $params);
        if (isset($result[0])) {
            return $result[0];
        } else {
            return null;
        }
    }
    
    function select($select) {
        $query = $select;
        $queryPrepare = $this->pdo()->query($query);
        $result = $queryPrepare->fetchAll(
                \PDO::FETCH_CLASS, $this->_tableRow
        );
        foreach ($result as $o) {
            $o->setTable($this->_table);
        }
        return $result;
    }
    

}