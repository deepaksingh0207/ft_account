<style>
    .custom-select, .custom-control,
    .filter-template input[type="text"] {
        display: inline-block;
        width: auto;
    }
    .visual-query-form {
        padding: 15px;
    }
    .tab-pane {
        border: solid 1px #dee2e6;
        margin-top: -2px;
        min-height: 60px;
        padding: 15px;
    }
</style>
<?php
    $queryTabs = [
        [
            'title' => 'Tables',
            'text' => 'Select and join tables here',
            'include' => "SelectTables.php",
        ],
        [
            'title' => 'Filters',
            'text' => 'Add filters here',
            'include' => "SelectFilters.php",
        ],
        [
            'title' => 'Groups',
            'text' => 'Set groups by fields here',
            'include' => "SelectGroups.php",
        ],
        [
            'title' => 'Sorts',
            'text' => 'Add sorts here',
            'include' => "SelectSorts.php",
        ],
        [
            'title' => 'Limit',
            'text' => 'Set row\'s offset and limit here',
            'include' => "SelectLimit.php",
        ],
    ];
?>
<div class="visual-query-form">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
    <?php
        foreach ($queryTabs as $i => $tab) {
            $title = $tab['title'];
            $active = $i === 0 ? 'active' : '';
            echo "<li class='nav-item'>
                <a class='nav-link $active' id='$name-$title-tab' data-toggle='tab' href='#$name-$title' role='tab' aria-controls='profile' aria-selected='false'>$title</a>
            </li>";
        }
    ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
    <?php
        foreach ($queryTabs as $i => $tab) {
            $title = $tab['title'];
            $text = $tab['text'];
            $include = $tab['include'];
            $active = $i === 0 ? 'active' : '';
            echo "<div class='tab-pane $active' id='$name-$title' role='tabpanel' aria-labelledby='$name-$title-tab'>$text <br>";
            include $include;
            echo "</div>";
        }
    ?>
    </div>
    
    <input type='hidden' name='visualqueries[]' value='<?php echo $this->name; ?>' />
    <input type='hidden' name='<?php echo $this->name; ?>_schema' value='<?php echo json_encode($this->schema); ?>' />
</div>
<script type="text/javascript">
    KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>, function() {
        <?php echo $this->name; ?>_data = {
            name: '<?php echo $this->name; ?>',
            tableNames: <?php echo json_encode($tableNames); ?>,
            tables: <?php echo json_encode($this->tables); ?>,
            tableLinks: <?php echo json_encode($this->tableLinks); ?>,
            defaultValue: <?php echo json_encode($this->defaultValue); ?>,
            value: <?php echo json_encode($this->value); ?>,
        }
        <?php echo $name; ?> = KoolReport.VisualQuery.create(<?php echo $name; ?>_data);
        <?php $this->clientSideReady(); ?>
    });
</script>



