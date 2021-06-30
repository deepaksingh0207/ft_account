<?php

namespace koolreport\visualquery;

use \koolreport\core\Utility as Util;
use \koolreport\querybuilder\DB;
use \koolreport\querybuilder\MySQL;

class VisualQueryHelper
{
    public function inputToParams()
    {
        $queryParams = [];
        function getInputsStartWith($prefix) {
            $vqNames = [];
            foreach ($_POST as $name => $value) {
                if (substr($name, 0, strlen($prefix)) === $prefix) {
                    $vqNames[] = $name;
                }
            }
            return $vqNames;
        }
        $vqNames = Util::get($_POST, 'visualqueries', []);
        foreach($vqNames as $vqName) {
            $vqPrefix = $vqName . '_';
            $vqInputs = getInputsStartWith($vqPrefix);
            $vqValue = [];
            foreach ($vqInputs as $vqInput) {
                $vqValue[substr($vqInput, strlen($vqPrefix))] = $_POST[$vqInput];
            }
            $queryParams[$vqName] = $vqValue;
        }
        return $queryParams;
    }

    public function paramsToValue($params)
    {
        if (!isset($params)) return null;
        $value = [
            'selectTables' => Util::get($params, 'selectTables', []),
            'selectFields' => Util::get($params, 'selectFields', []),
            'limit' => Util::get($params, 'limit', []),
            'offset' => Util::get($params, 'offset', []),
        ];

        $types = Util::get($params, 'filter_types', []);
        $fields = Util::get($params, 'filter_fields', []);
        $operators = Util::get($params, 'filter_operators', []);
        $value1s = Util::get($params, 'filter_value1s', []);
        $value2s = Util::get($params, 'filter_value2s', []);
        $filters = [];
        foreach ($fields as $i => $field) {
            $filters[] = [$field, $operators[$i], $value1s[$i], $value2s[$i], $types[$i]];
        }
        $value["filters"] = $filters;

        $fields = Util::get($params, 'group_fields', []);
        $aggregates = Util::get($params, 'group_aggregates', []);
        $groups = [];
        foreach ($fields as $i => $field) {
            $groups[] = [$field, $aggregates[$i]];
        }
        $value["groups"] = $groups;

        $fields = Util::get($params, 'sort_fields', []);
        $directions = Util::get($params, 'sort_directions', []);
        $sorts = [];
        foreach ($fields as $i => $field) {
            $sorts[] = [$field, $directions[$i]];
        }
        $value["sorts"] = $sorts;

        return $value;
    }

    protected function replaceTAlias($field)
    {
        $arr = explode(".", $field);
        $table = $arr[0];
        $tAlias = $this->tableMap[$table];
        $field = $arr[1];
        return "$tAlias.$field";
    }

    protected function replaceExpAlias($exp)
    {
        $table = $this->expTables[$exp];
        $tAlias = $this->tableMap[$table];
        $exp = str_ireplace("$table.", "$tAlias.", $exp);
        return $exp;
    }

    public function getFieldsAndLinks($schema)
    {
        $tables = Util::get($schema, "tables", []);
        $allFields = [];
        foreach ($tables as $table => $fields) {
            foreach ($fields as $field => $v) {
                Util::init($v, "alias", $field);
                // Util::init($v, 'as', $field);
                $allFields["$table.$field"] = $v;
            }
        }

        $relations = Util::get($schema, "relations", []);
        $tableLinks = [];
        foreach ($relations as $relation) {
            $table1 = explode(".", $relation[0])[0];
            $table2 = explode(".", $relation[2])[0];
            // $joinType = $relation[1];
            Util::init($tableLinks, $table1, []);
            $tableLinks[$table1][$table2] = [
                'join' => $relation[1],
                'field1' => $relation[0],
                'field2' => $relation[2]
            ];
            Util::init($tableLinks, $table2, []);
            $tableLinks[$table2][$table1] = [
                'join' => $relation[1],
                'field1' => $relation[2],
                'field2' => $relation[0]
            ];
        }
        return [$allFields, $tableLinks];
    }

    protected function buildQueryFrom($qb, $tables)
    {
        $tableLinks = $this->tableLinks;
        // $t = 0;
        $this->tableMap = [];
        foreach ($tables as $i => $table) {
            // $tAlias = "table_$t";
            $tAlias = $table;
            // $t++;
            $this->tableMap[$table] = $tAlias;
            if ($i === 0) {
                // $qb = DB::table("$table $tAlias");
                $qb = $qb->from("$table");
                continue;
            }
            for ($j = 0; $j < $i; $j++) {
                if (isset($tableLinks[$tables[$j]][$table])) {
                    $tableLink = $tableLinks[$tables[$j]][$table];
                    break;
                }
            }
            $qb = $qb->{$tableLink['join']}(
                // "$table $tAlias",
                "$table",
                $this->replaceTAlias($tableLink['field1']),
                "=",
                $this->replaceTAlias($tableLink['field2'])
            );
        }
        return $qb;
    }

    protected function buildQueryFields($qb, $fields)
    {
        $allFields = $this->allFields;
        $this->exps = [];
        $aliases = [];
        $this->expTables = [];
        foreach ($fields as $field) {
            $alias = Util::get($allFields, [$field, 'alias']);
            $exp = Util::get($allFields, [$field, 'expression'], $field);
            $this->exps[] = $exp;
            $aliases[$exp] = $alias;
            $this->expTables[$exp] = explode(".", $field)[0];
        }
        foreach ($this->exps as $exp) {
            $alias = $aliases[$exp];
            $exp = $this->replaceExpAlias($exp, $this->expTables, $this->tableMap);
            $qb = $qb->select($exp)->alias("\"$alias\"");
        }
        return $qb;
    }

    protected function buildQueryGroups($qb, $groups)
    {
        $allFields = $this->allFields;
        $this->groupExps = [];
        foreach ($groups as $group) {
            $field = $group[0];
            $agg = $group[1];
            $exp = Util::get($allFields, [$field, 'expression'], $field);
            $alias = Util::get($allFields, [$field, 'alias'], $field);
            $this->expTables[$exp] = explode(".", $field)[0];
            $exp = $this->replaceExpAlias($exp, $this->expTables, $this->tableMap);
            $groupAlias = "$agg($alias)";
            $qb = $qb->{$agg}($exp)->alias("\"$groupAlias\"");
            $this->groupExps["$agg($field)"] = "$agg($exp)";
            $this->expTables["$agg($exp)"] = explode(".", $field)[0];
            $colMeta = $agg !== "count" ? $allFields[$field] : [
                "type" => "number"
            ];
            $colMeta["alias"] = $groupAlias;
            $resultCols[] = $colMeta;
        }
        if (!empty($groups) && !empty($this->exps)) {
            $groups = "";
            foreach ($this->exps as $exp) {
                $exp = $this->replaceExpAlias($exp, $this->expTables, $this->tableMap);
                $groups .= ", $exp";
            }
            $groups = substr($groups, 2);
            $qb = $qb->groupBy($groups);
        }
        return $qb;
    }

    protected function buildQueryFilters($qb, $filters)
    {
        $allFields = $this->allFields;
        foreach ($filters as $filter) {
            $field = $filter[0];
            // $field = $this->replaceTAlias($field, $this->tableMap);
            $exp = Util::get($allFields, [$field, 'expression'], $field);
            $this->expTables[$exp] = explode(".", $field)[0];
            $exp = $this->replaceExpAlias($exp, $this->expTables, $this->tableMap);
            $op = $filter[1];
            $value1 = $filter[2];
            $value2 = $filter[3];
            $type = $filter[4];
            switch ($op) {
                case "=":
                case "<>":
                case ">":
                case ">=":
                case "<":
                case "<=":
                    $qb = $type === 'and' ?
                        $qb->where($exp, $op, $value1) :
                        $qb->orWhere($exp, $op, $value1);;
                    break;
                case "ctn":
                    $qb = $type === 'and' ?
                        $qb->where($exp, 'like', "%$value1%") :
                        $qb->orWhere($exp, 'like', "%$value1%");
                    break;
                case "nctn":
                    $qb = $type === 'and' ?
                        $qb->where($exp, 'not like', "%$value1%") :
                        $qb->orWhere($exp, 'not like', "%$value1%");
                    break;
                case "btw":
                    $qb = $type === 'and' ?
                        $qb->whereBetween($exp, [$value1, $value2]) :
                        $qb->orWhereBetween($exp, [$value1, $value2]);
                    break;
                case "nbtw":
                    $qb = $type === 'and' ?
                        $qb->whereNotBetween($exp, [$value1, $value2]) :
                        $qb->orWhereNotBetween($exp, [$value1, $value2]);
                    break;
                case "in":
                    $qb = $type === 'and' ?
                        $qb->whereIn($exp, explode(",", $value1)) :
                        $qb->orWhereIn($exp, explode(",", $value1));
                    break;
                case "nin":
                    $qb = $type === 'and' ?
                        $qb->whereNotIn($exp, explode(",", $value1)) :
                        $qb->orWhereNotIn($exp, explode(",", $value1));
                    break;
                case "null":
                    $qb = $type === 'and' ?
                        $qb->whereNull($exp) :
                        $qb->orWhereNull($exp);
                    break;
                case "nnull":
                    $qb = $type === 'and' ?
                        $qb->whereNotNull($exp) :
                        $qb->orWhereNotNull($exp);
                    break;
            }
        }
        return $qb;
    }

    protected function buildQuerySorts($qb, $sorts)
    {
        $allFields = $this->allFields;
        foreach ($sorts as $sort) {
            $field = $sort[0];
            $dir = $sort[1];
            $exp = Util::get($allFields, [$field, 'expression'], $field);
            $exp = Util::get($this->groupExps, $exp, $exp);
            $exp = $this->replaceExpAlias($exp, $this->expTables, $this->tableMap);
            $qb = $qb->orderBy($exp, $dir);
        }
        return $qb;
    }

    protected function buildQueryLimitOffset($qb, $limit, $offset)
    {
        if (is_numeric($offset) && is_numeric($limit)) {
            $qb = $qb->offset($offset)->limit($limit);
        }
        return $qb;
    }

    public function valueToQueryBuilder($schema, $params)
    {
        $qb = new \koolreport\querybuilder\Query();

        if (empty($schema)) return $qb;

        list($this->allFields, $this->tableLinks) = $this->getFieldsAndLinks($schema);

        $selectTables = Util::get($params, 'selectTables', []);
        $qb = $this->buildQueryFrom($qb, $selectTables);

        $selectFields = Util::get($params, 'selectFields', []);
        $qb = $this->buildQueryFields($qb, $selectFields);

        $groups = Util::get($params, 'groups', []);
        $qb = $this->buildQueryGroups($qb, $groups);

        $filters = Util::get($params, 'filters', []);
        $qb = $this->buildQueryFilters($qb, $filters);

        $sorts = Util::get($params, 'sorts', []);
        $qb = $this->buildQuerySorts($qb, $sorts);

        $limit = Util::get($params, 'limit', null);
        $offset = Util::get($params, 'offset', null);
        $qb = $this->buildQueryLimitOffset($qb, $limit, $offset);

        return $qb;
    }
}
