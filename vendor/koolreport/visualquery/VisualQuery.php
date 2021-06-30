<?php

namespace koolreport\visualquery;

use \koolreport\core\Utility as Util;

class VisualQuery extends \koolreport\core\Widget
{
    public function version()
    {
        return "1.0.0";
    }

    protected function resourceSettings()
    {
        $themeBase = $this->getThemeBase();
        if (empty($themeBase)) $themeBase = 'bs3';

        $resources = [
            "library" => array("jQuery"),
            "folder" => "",
            "js" => ["js/visualquery.js"],
        ];

        $inputsPath = "../inputs/bower_components";
        $bootstrapMultiselectDir = $themeBase === 'bs3' ? 
            'bootstrap-multiselect' : 'bootstrap-multiselect-0.9';
        $inputsResources = [
            "js" => array(
                "$inputsPath/$bootstrapMultiselectDir/bootstrap-multiselect.js",
            ),
            "css" => array(
                "$inputsPath/$bootstrapMultiselectDir/bootstrap-multiselect.css",
            )
        ];
        if ($themeBase === 'bs4') {
            // $inputsResources['css'][] = "$inputsPath/$bootstrapMultiselectDir/additional.bs4.css";
            $resources['library'][] = 'font-awesome';
        }

        
        return array_merge_recursive(
            $resources,
            $inputsResources
        );
    }

    protected function onInit()
    {
        $this->name = Util::get($this->params, 'id', null);
        $this->name = Util::get($this->params, 'name', $this->name);

        $report = $this->getReport();
        $queryParams = Util::get($report->getQueryParams(), $this->name);
        $this->value = $report->paramsToValue($queryParams);
        $this->schema = Util::get($this->params, "schema", []);
        if (isset($this->value['schema'])) {
            if (json_decode($this->value['schema'], true) != $this->schema) {
                throw new \Exception("Schema not correct");
            }
        }
        $this->tables = Util::get($this->schema, "tables", []);
        list($this->allFields, $this->tableLinks) = 
            $report->getVQHelper()->getFieldsAndLinks($this->schema);
    }

    protected function onRender()
    {
        $this->defaultValue = Util::get($this->params, 'defaultValue');
        $this->template("VisualQuery", [
            "name" => $this->name
        ]);
    }
}
