<?php
include("config.php");
include("config2.php");
include("db_query.php");
include("common_functions.php");
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Comparing all Schemas of 2 Databases</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
All Schemas
</p>
</div>
<?php
    $schemas1 = getSchemas($conn1);
    $schemas2 = getSchemas($conn2);
    $commonSchemas = array_intersect($schemas1, $schemas2);
    $diff_schemas1=array_diff($schemas1, $schemas2);
    $diff_schemas2=array_diff($schemas2, $schemas1);
?>

<div class="table-container">
<table>
    <tr><th colspan="4">Data Selected</th><tr>
    <tr>
        <td><b>Database1:</b></td><td><?php echo $db1; ?></td>
        <td><b>Database2:</b></td><td><?php echo $db2; ?></td>
    </tr>
</table>
</div>

    <div class="left">
    <h3>Matching Schemas</h3>

    <div class="container">
    <div class="tab-large">

    <div class="grid-container-5">
        <div class="grid-item tab-heading"><b>Schema</b></div>
        <div class="grid-item tab-heading"><b>Table</b></div>
        <div class="grid-item tab-heading"><b>Column</b></div>
        <div class="grid-item tab-heading"><b>DataType of Database:</b> <?php echo $db1; ?></div>
        <div class="grid-item tab-heading"><b>DataType of Database:</b> <?php echo $db2; ?></div>
        <?php
            foreach($commonSchemas as $schema_data) {
                $tablesOfCommonSchemas1 = getTables($conn1, $schema_data);
                $tablesOfCommonSchemas2 = getTables($conn2, $schema_data);
                $commonTablesOfCommonSchemas = array_intersect($tablesOfCommonSchemas1, $tablesOfCommonSchemas2);
                if(count($commonTablesOfCommonSchemas)>0){
                    foreach($commonTablesOfCommonSchemas as $tbl){
                        $match_row=getAllMatchingTableData($conn1, $conn2, $tbl);
                        for($i=0; $i<count($match_row); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $schema_data; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $match_row[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $match_row[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $match_row[$i]['data_type1']; ?></div>
            <div class="grid-item"><?php echo $match_row[$i]['data_type2']; ?></div>
        <?php }
            }
          }
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
	</div><!-- End of container -->
    </div>

    <div class="left">
    <h3>Non-Matching Schemas</h3>

    <div class="container">
    <div class="tab-large">

    <div class="grid-container-5">
        <div class="grid-item tab-heading"><b>Database</b></div>
        <div class="grid-item tab-heading"><b>Schema</b></div>
        <div class="grid-item tab-heading"><b>Table</b></div>
        <div class="grid-item tab-heading"><b>Column</b></div>
        <div class="grid-item tab-heading"><b>DataType</b></div>
        <?php
           if(count($diff_schemas1)>0){
            foreach($diff_schemas1 as $schema_data) {
                $tables1 = getTables($conn1, $schema_data);
                foreach($tables1 as $data) {
                  $table_data=getDatabaseDetails($conn1, $schema_data, $data);
                  for($i=0; $i<count($table_data); $i++){
        ?>
            <div class="grid-item-darkgreen"><b><?php echo $db1; ?></b></div>
            <div class="grid-item-green"><b><?php echo $table_data[$i]['schema_name']; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $table_data[$i]['table_name']; ?></b></div>
            <div class="grid-item"><b><?php echo $table_data[$i]['column_name']; ?></b></div>
            <div class="grid-item"><?php echo $table_data[$i]['data_type']; ?></div>
        <?php }
            }
          }
        }
        if(count($diff_schemas2)>0){
            foreach($diff_schemas2 as $schema_data) {
                $tables2 = getTables($conn2, $schema_data);
                foreach($tables2 as $data) {
                  $table_data=getDatabaseDetails($conn2, $schema_data, $data);
                  for($i=0; $i<count($table_data); $i++){
                    ?>
            <div class="grid-item-darkgreen"><b><?php echo $db2; ?></b></div>
            <div class="grid-item-green"><b><?php echo $table_data[$i]['schema_name']; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $table_data[$i]['table_name']; ?></b></div>
            <div class="grid-item"><b><?php echo $table_data[$i]['column_name']; ?></b></div>
            <div class="grid-item"><?php echo $table_data[$i]['data_type']; ?></div>
        <?php }
            }
          }
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
	</div><!-- End of container -->
    </div>

    <div class="left">
    <h3>Common Schema, Different Tables</h3>

    <div class="container">
    <div class="tab-large">

    <div class="grid-container-5">
        <div class="grid-item tab-heading"><b>Database</b></div>
        <div class="grid-item tab-heading"><b>Schema</b></div>
        <div class="grid-item tab-heading"><b>Table</b></div>
        <div class="grid-item tab-heading"><b>Column</b></div>
        <div class="grid-item tab-heading"><b>DataType</b></div>
        <?php
           foreach($commonSchemas as $schema_data) {
            $tablesOfCommonSchemas1 = getTables($conn1, $schema_data);
            $tablesOfCommonSchemas2 = getTables($conn2, $schema_data);
            $diffTablesOfCommonSchemas1 = array_diff($tablesOfCommonSchemas1, $tablesOfCommonSchemas2);
            $diffTablesOfCommonSchemas2 = array_diff($tablesOfCommonSchemas2, $tablesOfCommonSchemas1);
            foreach($diffTablesOfCommonSchemas1 as $tbl){
                    $dt1=getAllNonMatchingTableData1($db1, $conn1, $conn2, $tbl);
                    if(!empty($dt1[0])){
                    for($i=0; $i<count($dt1); $i++){
        ?>
            <div class="grid-item-darkgreen"><b><?php echo $dt1[$i]['database']; ?></b></div>
            <div class="grid-item-green"><b><?php echo $schema_data; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $dt1[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $dt1[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $dt1[$i]['data_type']; ?></div>
        <?php }
            }
          }
        
          foreach($diffTablesOfCommonSchemas2 as $tbl){
            $dt2=getAllNonMatchingTableData2($db2, $conn1, $conn2, $tbl);
            if(!empty($dt2[0])){
            for($i=0; $i<count($dt2); $i++){
                    ?>
            <div class="grid-item-darkgreen"><b><?php echo $dt2[$i]['database']; ?></b></div>
            <div class="grid-item-green"><b><?php echo $schema_data; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $dt2[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $dt2[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $dt2[$i]['data_type']; ?></div>
        <?php }
            }
          }
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
	</div><!-- End of container -->
    </div>

    <div class="left">
    <h3>Common Schema, Common Table, Different Columns</h3>

    <div class="container">
    <div class="tab-large">

    <div class="grid-container-5">
        <div class="grid-item tab-heading"><b>Database</b></div>
        <div class="grid-item tab-heading"><b>Schema</b></div>
        <div class="grid-item tab-heading"><b>Table</b></div>
        <div class="grid-item tab-heading"><b>Column</b></div>
        <div class="grid-item tab-heading"><b>DataType</b></div>
        <?php
           foreach($commonSchemas as $schema_data) {
            $tablesOfCommonSchemas1 = getTables($conn1, $schema_data);
            $tablesOfCommonSchemas2 = getTables($conn2, $schema_data);
            $commonTablesOfCommonSchemas = array_intersect($tablesOfCommonSchemas1, $tablesOfCommonSchemas2);
            if(count($commonTablesOfCommonSchemas)>0){
                foreach($commonTablesOfCommonSchemas as $tbl){
                    $ct1=getAllNonMatchingTableData1($db1, $conn1, $conn2, $tbl);
                    if(!empty($ct1[0])){
                    for($i=0; $i<count($ct1); $i++){
        ?>
            <div class="grid-item-darkgreen"><b><?php echo $ct1[$i]['database']; ?></b></div>
            <div class="grid-item-green"><b><?php echo $schema_data; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $ct1[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $ct1[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $ct1[$i]['data_type']; ?></div>
        <?php }
            }
          }
        
          foreach($commonTablesOfCommonSchemas as $tbl){
            $ct2=getAllNonMatchingTableData2($db2, $conn1, $conn2, $tbl);
            if(!empty($ct2[0])){
            for($i=0; $i<count($ct2); $i++){
                    ?>
            <div class="grid-item-darkgreen"><b><?php echo $ct2[$i]['database']; ?></b></div>
            <div class="grid-item-green"><b><?php echo $schema_data; ?></b></div>
            <div class="grid-item-grey"><b><?php echo $ct2[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $ct2[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $ct2[$i]['data_type']; ?></div>
        <?php }
            }
          }
        }
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
	</div><!-- End of container -->
    </div>

</body>
</html>
