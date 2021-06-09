<?php

class CustomerGroupsModel extends Model {
    
    public function list() {
        $sql = "select * from customer_groups";
        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)){
            return false;
        }
        return $list;
    }
    
    public function get($id) {
        $sql = "select * from customer_groups where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
}