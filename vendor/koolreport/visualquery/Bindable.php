<?php
/**
 * This file contains trait to bind visual queries' params
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */


namespace koolreport\visualquery;

use \koolreport\core\Utility as Util;

trait Bindable
{
    protected $vqHelper;

    public function __constructVisualQueryBindable()
    {
        $this->vqHelper = new VisualQueryHelper();
        $this->registerEvent("OnInit", function(){
            $this->queryParams = $this->vqHelper->inputToParams();
        });
    }

    public function paramsToValue($params)
    {
        return $this->vqHelper->paramsToValue($params);
    }

    public function valueToQueryBuilder($schema, $params)
    {
        return $this->vqHelper->valueToQueryBuilder($schema, $params);
    }

    public function paramsToQueryBuilder($params)
    {
        $schema = json_decode(Util::get($params, 'schema', '[]'), true);
        return $this->vqHelper->valueToQueryBuilder(
            $schema, $this->vqHelper->paramsToValue($params)
        );
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getVQHelper()
    {
        return $this->vqHelper;
    }

}