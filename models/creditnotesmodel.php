    <?php

    class CreditNotesModel extends Model
    {

        public function getList()
        {
            $sql = " SELECT cni.*, cn.credit_note_no, i.invoice_no
            FROM credit_note_items cni
            LEFT JOIN credit_notes cn ON cni.credit_note_id = cn.id
            LEFT JOIN invoices i  ON  cn.invoice_id = i.id  
            ORDER BY cni.updated_date DESC";
            $this->_setSql($sql);
            $user = $this->getAll();
            if (empty($user)) {
                return false;
            }
            return $user;
        }

        public function creditNoteListByOrderId($orderId)
        {
            $sql = "SELECT cni.*, cn.credit_note_no
                    FROM credit_note_items cni
                    LEFT JOIN credit_notes cn ON cni.credit_note_id = cn.id
                    WHERE cni.order_id = ?
                    ORDER BY cni.updated_date DESC";

            $this->_setSql($sql);
            $user = $this->getAll([$orderId]);

            if (empty($user)) {
                return false;
            }

            return $user;
        }

        public function getCreditNoteItemsByOrderId($id)
        {
            $sql = "select * from credit_note_items where order_id = ? ";
            $this->_setSql($sql);
            $items = $this->getAll(array($id));
            if (empty($items)) {
                return false;
            }
            return $items;
        }

        public function getCreditNoteByOrderId($id)
        {
            $sql = "select * from credit_notes where order_id = ? ";
            $this->_setSql($sql);
            $items = $this->getAll(array($id));
            if (empty($items)) {
                return false;
            }
            return $items;
        }

        public function getListBycreditNoteId($id)
        {
            $sql = "SELECT cni.*, cn.hsn_id
        FROM credit_note_items cni
        JOIN credit_notes cn ON cni.credit_note_id = cn.id
        WHERE cni.credit_note_id = ?";

            $this->_setSql($sql);
            $user = $this->getAll(array($id));
            return $user;
        }


        public function getByID($id)
        {
            $sql = "
        SELECT cn.*,i.customer_id, invoice_no, SUM(cni.total) AS sub_total
        FROM credit_note_items cni
         JOIN invoices i ON cni.invoice_id = i.id
        JOIN credit_notes cn ON cn.id = cni.credit_note_id
        WHERE cn.id = ? 
        LIMIT 1";
            $this->_setSql($sql);
            $user = $this->getRow(array($id));
            return $user;
        }
    }
