<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.addSortClicked(this)'>
    Add sort</button>
<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.resetSortClicked(this)'>
    Reset</button>

<div class='select-sorts form'>
    <p></p>
</div>
<div class='sort-template form-group' style='display:none'>
    <p>
    <select class='custom-select sort-field form-control'></select>
    <select class='custom-select sort-dir form-control'>
        <option value='asc'>asc</option>
        <option value='desc'>desc</option>
    </select>
</div>


