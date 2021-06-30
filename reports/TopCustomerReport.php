<?php

use koolreport\KoolReport;

class TopCustomerReport extends KoolReport
{
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    
    use \koolreport\clients\jQuery;
    use \koolreport\clients\Bootstrap;
    use \koolreport\clients\FontAwesome;
    
    
    protected function defaultParamValues()
    {
        return array(
            "months"=> null,
            "years"=>array()
        );
    }
    
    protected function bindParamsToInputs()
    {
        return array(
            "years",
            "months",
        );
    }
    
    function settings()
    {
        return array(
            "assets"=>array(
                "path"=>"koolreport_assets",
                "url"=>"koolreport_assets"
            ),
            "dataSources"=>array(
                "ft_account"=>array(
                    "connectionString"=>"mysql:host=".DB_HOST.";dbname=".DB_NAME,
                    "username"=> DB_USER,
                    "password"=> DB_PASS,
                    "charset"=>"utf8"
                )
            )
        );
    }
    
    
    function setup()
    {
        $query_params = array();
        if(isset($this->params["months"]) && $this->params["months"] != "00")
        {
            $query_params[":months"] = $this->params["months"];
        }
        if(isset($this->params["years"]) && $this->params["years"]!=array())
        {
            $query_params[":years"] = $this->params["years"];
        }
        
        
        $this->src('ft_account')->query("select C.name, SUM(O.ordertotal) total
from customers C 
join orders O on O.customer_id = C.id 
group by C.id
order by total desc
limit 5"
            )->params($query_params)
            ->pipe($this->dataStore("customers"));
               
    }
    
    
}