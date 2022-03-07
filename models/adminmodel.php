<?php

class AdminModel extends Model {
    
    
    public function getUserList() {
        $sql = "select * from users where status=1 and admin=0 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from acl where user=$id";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }

    public function myaccess($userid, $controller, $action) {
        $sql = "select * from acl where user=? and controller=? and action=? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($userid, $controller, $action));
        // echo '<pre>'; var_dump($user); exit;
        if (empty($user)){ return false; }
        return true;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM acl WHERE id=$id";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($id));
    }
        
    public function save($data) {
        
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