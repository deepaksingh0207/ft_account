<?php

class CountryModel extends Model {
    
    public function list() {
        $sql = "select * from countries";
        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)){ return false; }
        return $list;
    }
    
    public function get($id) {
        $sql = "select * from countries where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){ return false; }
        return $user;
    }
    
}