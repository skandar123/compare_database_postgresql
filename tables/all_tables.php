<?php
include("config.php");
include("db_query.php");
include("schema_query.php");
include("table_query.php");
include("common_functions.php");
?>
<!DOCKTYPE html>
<head>
<title>Compare Tables</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Comparing all Tables of 2 Databases</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
All Tables
</p>
</div>
<?php
    $tables1 = getTables($conn5, $s1);
    $tables2 = getTables($conn6, $s2);
    
    $commonTables = array_intersect($tables1, $tables2);
    
    $diff_tables1=array_diff($tables1, $tables2);
    $diff_tables2=array_diff($tables2, $tables1);
?>

    <div class="left">
    <h3>Matching Tables and Columns</h3>

    <div class="container">
    <div class="tab">

    <div class="grid-container-4">

        <div class="grid-item tab-heading"><b>Table</b></div>
        <div class="grid-item tab-heading"><b>Column</b></div>
        <div class="grid-item tab-heading"><b>DataType of <?php echo $db1; ?></b></div>
        <div class="grid-item tab-heading"><b>DataType of <?php echo $db2; ?></b></div>
        <?php
            foreach($commonTables as $tbl){
                $match_row=getAllMatchingTableData($conn5, $conn6, $tbl);
                for($i=0; $i<count($match_row); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $match_row[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $match_row[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $match_row[$i]['data_type1']; ?></div>
            <div class="grid-item"><?php echo $match_row[$i]['data_type2']; ?></div>
        <?php }
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
	</div><!-- End of container -->
    </div>

    <div class="right">
    <h3>Non Matching Tables or Columns</h3>

    <div class="container">
    <div class="tab">

    <div class="grid-container-3">
    
    <div class="grid-item tab-heading span-3"><b><?php echo $db1; ?></b></div>
    
        <div class="grid-item green"><b>Table</b></div>
        <div class="grid-item green"><b>Column</b></div>
        <div class="grid-item green"><b>DataType</b></div>
        
    <?php
    if(empty($commonTables)){
            foreach($diff_tables1 as $data) {
                $table_data=getColumnNameDataType($conn5, $data);
                for($i=0; $i<count($table_data); $i++){
                    ?>
                    <div class="grid-item-green"><b><?php echo  $table_data[$i]['table_name']; ?></b></div>
                    <div class="grid-item"><b><?php echo  $table_data[$i]['column_name']; ?></b></div>
                    <div class="grid-item"><?php echo  $table_data[$i]['data_type']; ?></div>
                   <?php }
            }
    }else{
        foreach($commonTables as $tbl){
            $ct1=getAllNonMatchingTableData1($db1, $conn5, $conn6, $tbl);
            if(!empty($ct1[0]))
            for($i=0; $i<count($ct1); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $ct1[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $ct1[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $ct1[$i]['data_type']; ?></div>
        <?php }
        }
        foreach($diff_tables1 as $tbl){
            $dt1=getAllNonMatchingTableData1($db1, $conn5, $conn6, $tbl);
            if(!empty($dt1[0]))
            for($i=0; $i<count($dt1); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $dt1[$i]['table']; ?></b></div>
            <div class="grid-item"><b><?php echo $dt1[$i]['column']; ?></b></div>
            <div class="grid-item"><?php echo $dt1[$i]['data_type']; ?></div>
        <?php }
        }
    }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
    <div class="tab space">

    <div class="grid-container-3">
    
    <div class="grid-item tab-heading span-3"><b><?php echo $db2; ?></b></div>
    
        <div class="grid-item green"><b>Table</b></div>
        <div class="grid-item green"><b>Column</b></div>
        <div class="grid-item green"><b>DataType</b></div>
        
        <?php
    if(empty($commonTables)){
            foreach($diff_tables2 as $data) {
                $table_data=getColumnNameDataType($conn6, $data);
                for($i=0; $i<count($table_data); $i++){
                ?>
                    <div class="grid-item-green"><b><?php echo  $table_data[$i]['table_name'];?></b></div>
                    <div class="grid-item"><b><?php echo  $table_data[$i]['column_name'];?></b></div>
                    <div class="grid-item"><?php echo $table_data[$i]['data_type']; ?></div>
                <?php }
            }
    }else{
        foreach($commonTables as $tbl){
            $ct2=getAllNonMatchingTableData2($db2, $conn5, $conn6, $tbl);
            if(!empty($ct2[0]))
            for($i=0; $i<count($ct2); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $ct2[$i]['table'];?></b></div>
            <div class="grid-item"><b><?php echo $ct2[$i]['column'];?></b></div>
            <div class="grid-item"><?php echo $ct2[$i]['data_type']; ?></div>
        <?php }
        }
        foreach($diff_tables2 as $tbl){
            $dt2=getAllNonMatchingTableData2($db2, $conn5, $conn6, $tbl);
            if(!empty($dt2[0]))
            for($i=0; $i<count($dt2); $i++){
        ?>
            <div class="grid-item-green"><b><?php echo $dt2[$i]['table'];?></b></div>
            <div class="grid-item"><b><?php echo $dt2[$i]['column'];?></b></div>
            <div class="grid-item"><?php echo $dt2[$i]['data_type']; ?></div>
        <?php }
        }
    }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->

	</div><!-- End of container -->
    </div>

</body>
</html>