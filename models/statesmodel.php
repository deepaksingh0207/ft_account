<?php

class StatesModel extends Model {
    
    public function list() {
        $sql = "select states.*, countries.id as country_id, countries.country_name from states
        left join countries on countries.id = states.country_id";
        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)){ return false; }
        return $list;
    }
    
    public function get($id) {
        $sql = "select * from states where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){ return false; }
        return $user;
    }
    
}