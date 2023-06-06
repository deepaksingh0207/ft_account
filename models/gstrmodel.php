<?php

class GstrModel extends Model {
    
    public function getGstrReportList($id) {
        $sql = "SELECT i.id, c.gstin, c.name receiver, i.invoice_no, LEFT(i.invoice_date , 10) invoice_date, sum(t.total) invoice_value, CONCAT(LEFT(c.gstin , 2),'-',s.name) pos, 'N' rc, NULL tr, 'Regular B2B' it, NULL egst, 18 rate, invoice_total,NULL cs FROM invoices i inner join invoice_items t on t.invoice_id = i.id inner join customers c on i.customer_id = c.id inner join states s on s.id = c.state";
        if ($id) { $sql = $sql." where i.gstr_set = ".$id.";"; }
        else { $sql .= " where i.gstr_set is null "; }        
        $this->_setSql($sql);
        $order = $this->getAll(array($id));
        if (empty($order)){ return false; }
        return $order;
    }

    public function getsetid(){
        $sql = "SELECT distinct gstr_set FROM invoices where gstr_set is not null order by gstr_set desc;";
        $this->_setSql($sql);
        $user = $this->getAll();
        return $user;
    }

    public function updatesetid($invid, $setid){
        if(!empty($setid)) {
            $sql = "update invoices set gstr_set = ".$setid." WHERE id = ?";
            $this->_setSql($sql);
            $data = $this->getAll(array($invid));
            if (empty($data)){return false;}
            return $data;
        }
    }
}