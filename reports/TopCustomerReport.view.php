<?php

use \koolreport\inputs\Select2;
use \koolreport\inputs\Select;
use koolreport\d3\DonutChart;
use \koolreport\amazing\GaugeCard;


$countSummary= $this->dataStore('count_summary')->data();
?>

<div class="report-content" style="padding:15px">
   
    
    <div class="row">
        <div class="col-md-3">
        <?php
        \koolreport\amazing\ChartCard::create(array(
            "title"=>"Orders Amount",
            "value"=>$countSummary[0]['order_total'],
            "preset"=>"primary",
            "chart"=>array(
                "dataSource"=>$this->dataStore("orders")
            ),
            "cssClass"=>array(
                "icon"=>"icon-people"
            ),
            "columns"=>array(
                "total"=>array(
                    "label"=>"Total",
                    "type"=>"number",
                    "prefix" => 'INR '
                )
            )
        ));
        ?>
        </div>
        <div class="col-md-3">
        <?php
        \koolreport\amazing\ChartCard::create(array(
            "title"=>"Invoice Amount",
            "value"=>$countSummary[0]['invoice_total'],
            "preset"=>"success",
            "chart"=>array(
                "dataSource"=>$this->dataStore("invoices")
            ),
            "cssClass"=>array(
                "icon"=>"icon-people"
            ),
        ));
        ?>
        </div>
        <div class="col-md-3">
        <?php
        \koolreport\amazing\ChartCard::create(array(
            "title"=>"Payment Amount",
            "value"=>$countSummary[0]['payment_total'],
            "preset"=>"warning",
            "chart"=>array(
                "dataSource"=>$this->dataStore("payments")
            ),
            "cssClass"=>array(
                "icon"=>"icon-people"
            ),
        ));
        ?>
        </div>
        
    </div>
</div>


<h1>Top Customers</h1>
<div class="row">
    <div class="mt-1 mb-1 col-md-4">
<?php

DonutChart::create(array(
    "title"=>"",
    "dataSource"=>$this->dataStore("customers"),
    "label"=>array(
        "show"=>true,
        "use"=>"ratio",
        "decimals"=>2,
        "suffix"=>"%"
    ),
    "tooltip"=>array(
        "use"=>"value",
        "prefix"=>"Rs."
    ),
    "clientEvents"=>[
        "itemSelect"=>"function(params){
            console.log(params);
        }"
    ]
));
?>
</div>
<div class="mt-1 mb-1 col-md">
<?php
\koolreport\datagrid\DataTables::create(array(
    "dataSource"=>$this->dataStore("customers"),
    "options"=>array(
        'ordering' => false,
        "order"=>array(),
    ),
    "columns"=>array(
        "name" => array( "label"=>"Customer"),
        "total"=>array(
            "label"=>"Total ",
            "type"=>"number",
            "prefix" => 'INR '
        )
    )
));

?>

</div>
</div>




