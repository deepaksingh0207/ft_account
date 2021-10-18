<style>
    .select-tables .custom-select {
        margin-right: 5px;
    }
</style>
<?php

$tableNames = array_keys($this->tables);
// echo "tables="; print_r($tables); echo "<br>";
// echo "table links="; print_r($this->tableLinks); echo "<br>";
$options = "";
foreach ($tableNames as $tableName) {
    $options .= "<option value='$tableName'>$tableName</option>";
}
?>
<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.addTableClicked(this)'>
    Add table</button>
<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.resetTableClicked(this)'>
    Reset</button>
<div class='select-tables form'>
    <p></p>
</div>
<div class='dom-templates' style="display:none">
    <div class='form-group-template form-group'></div>
    <select class='select-template custom-select form-control'></select>
    <input type="hidden" class="hidden-input-template" />
    <option class='option-template'></option>
</div>