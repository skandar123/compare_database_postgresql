<?php
include("config.php");
include("table_query.php");
include("common_functions.php");
?>
<!DOCKTYPE html>
<head>
<title>Compare Tables</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Comparing Tables of 2 Databases</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
> Select Tables > Two Tables
</p>
</div>
<?php

$table1 = $_POST['table1'];
$table2 = $_POST['table2'];

$columns1 = getTableColumns($conn5, $table1);
$columns2 = getTableColumns($conn6, $table2);

$commonColumns = array_intersect($columns1, $columns2);

$diff1=array_diff($columns1, $columns2);
$diff2=array_diff($columns2, $columns1);
?>

    <div class="left">
    <h3>Matching Columns</h3>

    <div class="container">
    <div class="tab">

    <div class="grid-container">
    <div class="grid-item tab-heading"></div>
    <div class="grid-item tab-heading"><b><?php echo $table1; ?> of <?php echo $db1; ?></b></div>
    
        <div class="grid-item green"><b>Column</b></div>
        <div class="grid-item green"><b>DataType</b></div>
        <?php
        foreach($commonColumns as $data) {?>
            <div class="grid-item"><b><?php echo $data;?></b></div>
            <div class="grid-item"><?php echo getTableDataType($conn5, $table1, $data); ?></div>
        <?php }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
    <div class="tab">
    
    <div class="grid-container-single">
    <div class="grid-item tab-heading"><b><?php echo $table2; ?> of <?php echo $db2; ?></b></div>
    
        <div class="grid-item green"><b>DataType</b></div>
        <?php
        foreach($commonColumns as $data) {?>
            <div class="grid-item"><?php echo getTableDataType($conn6, $table2, $data); ?></div>
       <?php  }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
	</div><!-- End of container -->
    </div>


	<div class="right">
	<h3>Non Matching Columns</h3>
	<div class="container">
    <div class="tab">
    
    <div class="grid-container">
    <div class="grid-item span tab-heading"><b><?php echo $table1; ?> of <?php echo $db1; ?></b></div>
   
        <div class="grid-item green"><b>Column</b></div>
        <div class="grid-item green"><b>DataType</b></div>
        <?php
        foreach($diff1 as $data) {?>
            <div class="grid-item"><b><?php echo $data;?></b></div>
            <div class="grid-item"><?php echo getTableDataType($conn5, $table1, $data); ?></div>
        <?php }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    <div class="tab space">
    
    <div class="grid-container">
    <div class="grid-item span tab-heading"><b><?php echo $table2; ?> of <?php echo $db2; ?></b></div>

        <div class="grid-item green"><b>Column</b></div>
        <div class="grid-item green"><b>DataType</b></div>
        <?php
        foreach($diff2 as $data) {?>
            <div class="grid-item"><b><?php echo $data; ?></b></div>
            <div class="grid-item"><?php echo getTableDataType($conn6, $table2, $data); ?></div>
       <?php  }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
	<div><!-- End of container -->
    </div>

</body>
</html>