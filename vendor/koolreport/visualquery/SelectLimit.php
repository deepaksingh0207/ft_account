<div class='select-limit form form-check'>
    <input type="checkbox" class="" name="<?php echo $this->name; ?>_limit_enabled" 
        checked onchange="<?php echo $name; ?>.limitChkChanged(this)" >
    <label class="form-check-label" for="inlineFormCheck">
        Enable offset/limit
    </label><br>
    <input type="number" class="form-control custom-control" name="<?php echo $this->name; ?>_offset" placeholder=" Offset" value="0" name='<?php echo $this->name; ?>_offset' />
    <input type="number" class="form-control custom-control" name="<?php echo $this->name; ?>_limit" placeholder=" Limit" value="10" name='<?php echo $this->name; ?>_limit' />
</div>