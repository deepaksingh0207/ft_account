<?php

class UsersModel extends Model {

    public function getacl($id) {
        $sql = "select * from acl where user=$id";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }

    public function getUserList() {
        $sql = "select * from users where status=1 and admin=0 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function login($username, $password) {
        $sql = "select * from users where email = ? and password = ?  and status = 1 limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($username, $password));
        if (empty($user)){
            return false;
        }
        
        return $user;
    }
    
    
    public function getList() {
        $sql = "select * from users where admin != 1";
        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from users where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        $sql = "update users set ";
        
        foreach ($fields as $field) { $sql .= " $field = ?,"; }
        $sql = substr($sql, 0, -1);
        $sql .= " where id = ?";
        
        $data = array_values($updateRecord);
        $data[] = $id;
        
        //echo '<pre>'; print_r($data);
        
        $sth = $this->_db->prepare($sql);
        return $sth->execute($data);
    }
    
    public function save($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO users (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from users order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function myaccess($userid, $controller, $action) {
        // user=0 adds global controller and action
        $sql = "select * from acl where (user=".$userid." or user=0) and controller='".$controller."' and action='".$action."' limit 1";
        $this->_setSql($sql);
        $user = $this->getRow();
        if (!empty($user)){ return true; }
        return false;
    }

    public function getController($id) {
        $sql = "select distinct controller from acl where user=$id";
        $this->_setSql($sql);
        $data = $this->getAll(array($id));
        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function checkController($id, $controller) {
        $sql = "select distinct controller from acl where user=$id and controller=$controller";
        $this->_setSql($sql);
        $data = $this->getAll(array($id, $controller));
        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function getAction($id) {
        $sql = "select distinct action from acl where user=$id";
        $this->_setSql($sql);
        $data = $this->getAll(array($id));
        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function checkAction($id, $controller) {
        $sql = "select distinct action from acl where user=$id and action=$controller";
        $this->_setSql($sql);
        $data = $this->getAll(array($id, $controller));
        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function getmenu($id) {
        $sql = "select concat(controller, '_', action) as menu from acl where user=$id";
        $this->_setSql($sql);
        $data = $this->getAll(array($id));
        if (empty($data)){
            return false;
        }
        return $data;
    }
    
    public function delete_acl($id) {
        $sql = "DELETE FROM acl WHERE id=$id";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($id));
    }
        
    public function save_acl($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO acl (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
}