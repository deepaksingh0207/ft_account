# Visual Query

`koolreport/visualquery` is package to build query using UI.

## Installation

1. Download and unzip the zipped file.
2. Copy the folder `visualquery` into `koolreport` folder
3. Reference to the Bindable trait by the trait name`\koolreport\visualquery\Bindable`
4. Reference to the VisualQuery input widget by the classname`\koolreport\visualquery\VisualQuery`

## Requirement

To use the `VisualQuery` widget, beside `VisualQuery` package you need the `Inputs` package as well.

## Usage

### VisualQuery

To use `VisualQuery` widget in a report view, you need to use `Bindable` trait in the report class. For example:

```
//MyReport.php
class Report extends \koolreport\KoolReport
{
    use \koolreport\visualquery\Bindable;
    ...
```

```
//MyReport.view.php
<?php
    \koolreport\visualquery\VisualQuery::create(array(
        "name" => "visualquery1",
        ...
```

#### Schema

`VisualQuery` has a property called `schema` that allows developers to set a database-like schema for users to select tables, fields; apply filters, groups, sorts, limit, offset.

```
\koolreport\visualquery\VisualQuery::create(array(
    "name" => "visualquery1",
    "schema" => array(
        "tables" => [
            "customers"=>array(
                "{meta}" => [
                    "alias" => "Customers"
                ],
                "customerNumber"=>array(
                    "alias"=>"Customer Number",
                    "type"=>"number",
                    "decimal"=>0,
                    "prefix"=>"Cus",
                ),
                "customerName"=>array(
                    "alias"=>"Customer Name",
                ),
            ),
            "orders"=>array(
                "{meta}" => [
                    "alias" => "Orders"
                ],
                "orderNumber"=>array(
                    "alias"=>"Order Number"
                ),
                "orderMonth" => [
                    "expression" => "month(orderDate)",
                ]
            ),
        ],
        "relations" => [
            ["orders.customerNumber", "leftjoin", "customers.customerNumber"]
        ]
    )
    ...
```    
`schema` can has two main properties which are `tables` and `relations`. `Tables` is used for defining tables and their metadata, fields and the fields' information like type, alias, expression, prefix, suffix. `relations` is used to for defining join relations between tables.

#### defaultValue

Beside `schema`, you could set default values for `VisualQuery` widget via `defaultValue` property, i.e which tables, fields, filters, groups, sorts, limit, offset users will see upon `VisualQuery` loads for the first time:

```
\koolreport\visualquery\VisualQuery::create(array(
    "name" => "visualquery1",
    "defaultValue" => [
        "selectTables" => [
            "orders",
            "orderdetails",
            "products",
        ],
        "selectFields" => [
            "products.productName",
        ],
        "filters" => [
            ["products.productCode", "btw", "2", "998", "or"],
            ["products.productName", "nbtw", "1", "", "and"],
            ["products.productName", "<>", "a", "", "or"],
            ["products.productName", "nin", "a", "", "or"],
            ["products.productName", "null", "a", "", "or"],
            ["products.productName", "nnull", "a", "", "or"],
            ["products.productName", "ctn", "a", "", "or"],
            ["products.productName", "nctn", "a", "", "or"],
        ],
        "groups" => [
            ["orderdetails.cost", "sum"]
        ],
        "sorts" => [
            ["products.productName", "desc"]
        ],
        "offset" => 5,
        "limit" => 10,
    ],
    ...
```
`selectTables` is an array of table names. 

`selectFields` is an array of table fields. 

`filters` is an array of filters. Each filter is an array including a field, a filter operator, filter value 1, filter value 2 and a logical operator ("and", "or"). The list of filter operators is:

|Filter operator   |Meaning   |
|---|---|
| =  | equals to  |
|  <> |  not quals to |
|  > | greater than  |
|  >= | greater than or equals to  |
|  < | less than   |
| <=>  | less than or equals to  |
| btw  |  between |
| nbtw  |  not between |
|  ctn | contains  |
| nctn  | not contains  |
|  null | is null  |
| nnull  |  is not null |
| in  | in  |
|  nin |  not in |

`groups` is an array of groups. Each group is an array including a field and an aggregated operator: "sum", "count", "avg", "min" or "max" like a database aggregate.

`sorts` is an array of sorts. Each sort is an array including a field and a direction: "asc" or "desc".

`offset` is a number indicating the offset of the first row to be retrieved. `limit` is the total number of expected returned rows.

When using `Bindable` together with `VisualQuery` widget, your report has access to a property called `queryParams` which contains an array value of the VisualQuery widget. With that value you could create a QueryBuilder object which in turn could return a sql query. Or with the array and its defined format you could convert it directly to a sql query if you want.

Here's an example of using `VisualQuery` with `QueryBuilder` package to produce a sql query:

```
//MyReport.php
class Report extends \koolreport\KoolReport
{
    use \koolreport\visualquery\Bindable;
    ...
    protected function setup()
    {
        if (isset($this->queryParams['visualquery1'])) {
            $vqParams =  $this->queryParams['visualquery1'];
            $queryBuilder = $this->paramsToQueryBuilder($vqParams);
            $queryStr = $queryBuilder->toMySQL();
        } else {
            $queryStr = "select * from myTable where 1=0";
        }
        
        $this
        ->src('myDataSource')
        ->query($queryStr)
        ->pipe($this->dataStore('myDataStore'));
    ...

//MyReport.view.php
<?php
    \koolreport\visualquery\VisualQuery::create(array(
        "name" => "visualquery1",
        ...
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.