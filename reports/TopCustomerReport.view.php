<h1>Top 5 Customers</h1>
<?php

use \koolreport\inputs\Select2;
use \koolreport\inputs\Select;
use koolreport\d3\DonutChart;

?>


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
