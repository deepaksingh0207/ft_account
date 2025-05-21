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

 // public function cancelIrnByInvoice($Id) {
    
//     try {
//         $this->_model->cancelIrnByInvoice($Id);

//         $invoiceirn = $this->_model->getByInvoiceId($Id);
//         if (!empty($invoiceirn['irn_no'])) {
//             $this->invoicesController->cancelEinvoice($invoiceirn['irn_no']);
//         } else {
//             echo json_encode([
//                 'status' => 0,
//                 'message' => "IRN not found for invoice ID: " . $Id
//             ]);
//             return;
//         }

//         echo json_encode([
//             'status' => 1,
//             'data' => $invoiceirn
//         ]);
//     } catch (Exception $e) {
//         echo json_encode([
//             'status' => 0,
//             'message' => "Application error: " . $e->getMessage()
//         ]);
//     }
// }

}