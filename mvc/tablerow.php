<?php

namespace MVC;

class TableRow{
    private $_table;
    
    public function setTable($table){
        $this->_table=$table;
    }
    public function store($table = null, $pdo = null) {
        if (is_null($pdo)) {
            $pdo = \MVC\Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        $attributs = get_object_vars($this);
        //suppression des attributs de la classe TableRow
        foreach ($attributs as $key => $value) {
            if (substr($key, 0, 1) == '_') {
                unset($attributs[$key]);
            }
        }
        $values = array_values($attributs);

        if (isset($this->id) and !is_null($this->id)) {
            $query = 'update ' . $table . ' set ';
            $query.=implode('=?,', array_keys($attributs)) . '=?';
            $query.=' where id=?';
            $values[] = $this->id;
        } else {
            $query = 'insert into '
                    . $table
                    . '(' . implode(',', array_keys($attributs)) . ') values ('
                    . substr(str_repeat('?,', sizeof($attributs)), 0, -1) . ')';
        }
        $queryPrepare = $pdo->prepare($query);
        if (!$queryPrepare->execute($values)) {
            $error=$queryPrepare->errorInfo();
            throw new Exception("\nPDO::errorInfo():\n" . $error[2]);
        }
        if (!isset($this->id)) {
            $this->id = $pdo->lastInsertId();
        }
        return $this;
    }
    public function delete($table=null,$pdo=null){
        if (is_null($pdo)) {
            $pdo = \MVC\Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        if (isset($this->id) and !is_null($this->id)) {
            $query = 'delete from ' . $table ;
            $query.=' where id=?';
            
        }
        $queryPrepare = $pdo->prepare($query);
        return $queryPrepare->execute(array($this->id));
        
    }
}