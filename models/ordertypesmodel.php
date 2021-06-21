<?php

class OrderTypesModel extends Model {
    
    
    public function list() {
        $sql = "select * from order_types";
        $this->_setSql($sql);
        $types = $this->getAll();
        return $types;
    }
    
}