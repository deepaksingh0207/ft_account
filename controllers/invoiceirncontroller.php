<?php
class InvoiceIrnController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("invoiceirn");
    }

    public function getIrnById($Id) {
        try {
            $invoiceirn = $this->_model->get($Id);
            echo json_encode($invoiceirn);
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function getIrnByInvoice($Id) {
        try {
            $invoiceirn = $this->_model->getListByInvoiceId($Id);
            echo json_encode($invoiceirn);
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function getIrnByCreditNote($Id) {
        try {
            $invoiceirn = $this->_model->getListBycreditNoteId($Id);
            echo json_encode($invoiceirn);
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function cancelIrnByInvoice($Id) {
        try {
            $this->_model->cancelIrnByInvoice($Id);
            $invoiceirn = $this->_model->getByInvoiceId($Id);
            echo json_encode($invoiceirn);
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}