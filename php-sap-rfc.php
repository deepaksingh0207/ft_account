<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

class workerThread extends Thread {
    public function __construct($i){
        $this->i=$i;
    }
    
    public function run(){
        while(true){
            echo $this->i;
            sleep(1);
        }
    }
}

for($i=0;$i<50;$i++){
    $workers[$i]=new workerThread($i);
    $workers[$i]->start();
}



exit;

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

$config = [
    'ashost' => '122.175.13.217',
    'sysnr'  => '07',
    'client' => '800',
    'user'   => 'userk1',
    'passwd' => 'vijayfiori',
];

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$counter = isset($_GET['counter']) ? intval($_GET['counter']) : 10;

try {
    $c = new SapConnection($config); 
    
    $f = $c->getFunction('STFC_CHANGING');
    $result = $f->invoke([
        'START_VALUE' => $start,
        'COUNTER' => $counter,
    ]); 
    
    
    echo json_encode(($result));
} catch(SapException $ex) {
    echo 'Exception: ' . $ex->getMessage() . PHP_EOL;
}

?>