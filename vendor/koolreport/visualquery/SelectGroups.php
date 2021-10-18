<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.addGroupClicked(this)'>
    Add group</button>
<button type='button' class='btn btn-light' onclick='<?php echo $name; ?>.resetGroupClicked(this)'>
    Reset</button>

<div class='select-groups form'>
    <p></p>
</div>
<div class='group-template form-group' style='display:none'>
    <p>
    <select class='custom-select group-field form-control'></select>
    <select class='custom-select group-agg form-control'>
        <option value='sum'>sum</option>
        <option value='count'>count</option>
        <option value='avg'>avg</option>
        <option value='min'>min</option>
        <option value='max'>max</option>
    </select>
</div>