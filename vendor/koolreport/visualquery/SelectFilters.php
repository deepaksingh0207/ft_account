<style>
    .select-filters .custom-select,
    .select-filters input[type="text"] {
        vertical-align: bottom;
    }
</style>

<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.addFilterClicked(this)'>
    Add filter</button>
<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.resetFilterClicked(this)'>
    Reset</button>

<div class='select-filters form'>
    <p></p>
</div>
<div class='filter-template form-group' style='display:none'>
    <p>
    <select class='custom-select filter-type form-control'>
        <option value='and' selected> AND </option>
        <option value='or'> OR </option>
    </select>
    <select class='custom-select filter-field form-control'></select>
    <select class='custom-select filter-op form-control' onchange='<?php echo $name; ?>.filterOpChanged(this)'>
        <option value='=' selected> = </option>
        <option value='<>'> != </option>
        <option value='>'> > </option>
        <option value='>='> >= </option>
        <option value='<'> < </option>
        <option value='<='> <= </option>
        <option value='btw'> between </option>
        <option value='nbtw'> not between </option>
        <option value='ctn'> contains </option>
        <option value='nctn'> not contains </option>
        <option value='null'> null </option>
        <option value='nnull'> not null </option>
        <option value='in'> in </option>
        <option value='nin'> not in </option>
    </select>
    <input class='form-control filter-value-1' type='text' />
    <input class='form-control filter-value-2' style='display:none' type='text' />
</div>