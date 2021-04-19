<?php

class Model {
    protected $_db;
    protected $_ftdb;
    protected $_sql;

    public function __construct() {
        $this->_db = Db::init_CL();
    }
    
    function placeholders($text, $count=0, $separator=","){
        $result = array();
        if($count > 0){
            for($x=0; $x<$count; $x++){
                $result[] = $text;
            }
        }
        return implode($separator, $result);
    }
    
    protected function _setSql($sql) {
        $this->_sql = $sql;
    }
    
    public function getAll($data = null) {
        if (!$this->_sql) {
            throw new Exception("No SQL query!");
        }
    
        $sth = $this->_db->prepare($this->_sql);
        $sth->execute($data);
        return $sth->fetchAll();
    }
    
    public function getRow($data = null) {
        if (!$this->_sql) {
            throw new Exception("No SQL query!");
        }
    
        $sth = $this->_db->prepare($this->_sql);
        $sth->execute($data);
        return $sth->fetch();
    }
}