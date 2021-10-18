<?php

require_once "../../../../core/autoload.php";

use \koolreport\core\Utility as Util;

class Report extends \koolreport\KoolReport
{
    use \koolreport\bootstrap4\Theme;
    // use \koolreport\clients\Bootstrap;
    use \koolreport\visualquery\Bindable;

    function settings()
    {
        return array(
            "dataSources" => array(
                "automaker" => array(
                    "connectionString"=>"mysql:host=localhost;dbname=automaker",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                ),
            )
        );
    }

    protected function setup()
    {
        $params = Util::get($this->queryParams, 'visualquery1');
        $qb = $this->paramsToQueryBuilder($params);
        // $arr = $qb->toArray();
        // echo "qb array="; Util::prettyPrint($arr);
        $this->queryStr = $queryStr = $params ? $qb->toMySQL() : "select * from customers where 1=0";
        // echo "queryStr="; echo $queryStr; echo "<br>";
        
        $this
        ->src('automaker')
        ->query($queryStr)
        ->pipe(new \koolreport\processes\ColumnMeta([
            "Order Number" => [
                "type" => "string"
            ],
            "orderMonth" => [
                "type" => "string"
            ],
        ]))
        ->pipe($this->dataStore('vqDS'));
    }
}
