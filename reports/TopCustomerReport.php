<?php

use koolreport\KoolReport;
use koolreport\processes\AggregatedColumn;
use koolreport\processes\Group;

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
            "customer"=> null
        );
    }
    
    protected function bindParamsToInputs()
    {
        return array(
            "customer"
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
        if(isset($this->params["customer"]) && $this->params["customer"] != "")
        {
            $query_params[":customer_id"] = $this->params["customer"];
        }        
        
        $this->src('ft_account')->query("select C.name, SUM(O.ordertotal) total
            from customers C 
            join orders O on O.customer_id = C.id 
            group by C.id
            order by total desc
            limit 5"
            )->params($query_params)
            ->pipe($this->dataStore("customers"));


        $this->src('ft_account')->query("select date_format(order_date, '%M-%Y') date, SUM(ordertotal) total FROM orders  where 1=1 ". ((isset($query_params[":customer_id"]))?" and  customer_id = :customer_id":"") ." GROUP BY date_format(order_date, '%M-%Y') ")->params($query_params)
        ->pipe($this->dataStore("orders"));

        $this->src('ft_account')->query("select date_format(invoice_date, '%M-%Y') date, SUM(invoice_total) total FROM invoices where 1=1 " .((isset($query_params[":customer_id"]))?" and  customer_id = :customer_id":"") ." GROUP BY date_format(invoice_date, '%M-%Y') ")->params($query_params)
            ->pipe($this->dataStore("invoices"));

        $this->src('ft_account')->query("select date_format(payment_date, '%M-%Y') date, SUM(received_amt) total FROM customer_payments where 1=1 " .((isset($query_params[":customer_id"]))?" and  customer_id = :customer_id":"") ." GROUP BY date_format(payment_date, '%M-%Y')  ")->params($query_params)
            ->pipe($this->dataStore("payments"));
            

            $this->src('ft_account')->query("select  sum(A.Qty) order_total, sum(B.Qty) invoice_total, Sum(C.Qty) payment_total FROM customers c 
            LEFT JOIN (SELECT  customer_id, SUM(ordertotal) Qty FROM orders GROUP BY customer_id) as A ON (A.customer_id = c.id)
            LEFT JOIN (SELECT  customer_id, SUM(invoice_total) Qty FROM invoices GROUP BY customer_id) as B ON B.customer_id = c.id
            LEFT JOIN (SELECT  customer_id, SUM(received_amt) Qty FROM customer_payments GROUP BY customer_id) as C ON C.customer_id = c.id where 1=1 "
            .((isset($query_params[":customer_id"]))?" and  c.id = (:customer_id)":"")
            )->params($query_params)
            ->pipe($this->dataStore("count_summary"));

            
    }
    
    
}