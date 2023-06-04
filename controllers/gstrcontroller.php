<?php
class GstrController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("gstr");
    }

    public function index() {
        try {          
            $this->_view->set('title', 'GSTR Report');            
            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function create($invid, $setid) {
        if($invid && $setid) {
            $GstrList = new GstrModel();
            $customers = $GstrList->updatesetid($invid, $setid);
            echo json_encode("{'status': 'true'}");
        } else {
            echo json_encode("{'status': 'false'}");
        }
    }

    public function getsetid() {
        $oders = $this->_model->getsetid();
        $order = array();
        foreach($oders as &$o) { array_push($order, $o["gstr_set"]); }
        echo json_encode($order);
        echo false;
    }

    public function getGstrReportList($id = null) {
        // var_dump($id);
        $oders = $this->_model->getGstrReportList($id);
        $order = array();
        if($oders) {
            foreach($oders as &$o) {
                // print_r($o);
                $order[$o["id"]]= $o;
            }
        }
        // exit;
        echo json_encode($order);
        echo false;
    }
}