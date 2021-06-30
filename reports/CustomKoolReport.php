<?php

namespace customkollreport;

use koolreport\KoolReport;

class CustomKoolReport extends KoolReport
{
    
    function settings()
    {
        return array(
            "assets"=>array(
                "path"=>"koolreport_assets",
                "url"=>"koolreport_assets"
            ),
            "dataSources"=>array(
                "shird_report"=>array(
                    "connectionString"=>"mysql:host=".DB_HOST.";dbname=".DB_NAME,
                    "username"=> DB_USER,
                    "password"=> DB_PASS,
                    "charset"=>"utf8"
                )
            )
        );
    }
    
}