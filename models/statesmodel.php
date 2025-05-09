<?php

class StatesModel extends Model {
    
    public function list() {
        $sql = "select * from states";
        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)){
            return false;
        }
        return $list;
    }
    
    public function get($id) {
        $sql = "select * from states where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return false;
        }
        return $user;
    }
   
    public function getStatesByCountry($countryId) {
        $sql = "SELECT * FROM states WHERE country_id = ?"; 
        $this->_setSql($sql);
        $states = $this->getAll(array($countryId));
        return $states;
    }
}