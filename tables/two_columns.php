<?php
include("config.php");
include("config2.php");
include("column_query.php");
include("common_functions.php");
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Comparing Paired Columns of 2 Databases</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
Select Schemas
>
Select Tables
>
Select Columns
>
Two Columns
</p>
</div>
<?php
$column1 = $_POST['column1'];
$column2 = $_POST['column2'];
$table_name1=$s1.".".$table1;
$table_name2=$s2.".".$table2;

if(($column1=="tet_email_template" && $column2=="tet_email_template") || ($column1=="tet_email_code" && $column2=="tet_email_code")){
    $key_column="tet_email_code";
    $value_column="tet_email_template";
    $c1='tet_email_code';
    $c2='tet_email_code';
}
elseif(($column1=="tcm_value" && $column2=="tcm_value") || ($column1=="tcm_key" && $column2=="tcm_key")){
    $key_column="tcm_key";
    $value_column="tcm_value";
    $c1='tcm_key';
    $c2='tcm_key';
}
else{
    echo "Please select only paired columns and make sure that same column name is selected from both databases.";
    exit();
}

$column_data1=getColumnData($conn7, $c1, $table_name1);
$column_data2=getColumnData($conn8, $c2, $table_name2);

$common_column_data = array_intersect($column_data1, $column_data2);

$diff_column_data1=array_diff($column_data1, $column_data2);
$diff_column_data2=array_diff($column_data2, $column_data1);

?>

<div class="table-container">
<table>
    <tr><th colspan="4">Data Selected</th><tr>
    <tr>
        <td><b>Database1:</b></td><td><?php echo $db1; ?></td>
        <td><b>Database2:</b></td><td><?php echo $db2; ?></td>
    </tr>
    <tr>
        <td><b>Schema1:</b></td><td><?php echo $s1; ?></td>
        <td><b>Schema2:</b></td><td><?php echo $s2; ?></td>
    </tr>
    <tr>
        <td><b>Table1:</b></td><td><?php echo $table1; ?></td>
        <td><b>Table2:</b></td><td><?php echo $table2; ?></td>
    </tr>
    <tr>
        <td><b>Column1:</b></td><td><?php echo $column1; ?></td>
        <td><b>Column2:</b></td><td><?php echo $column2; ?></td>
    </tr>
</table>
</div>

<div class="left">
    <h3>Matching Rows</h3>

    <div class="container">
    <div class="tab-large">

    <div class="grid-container">
    <div class="grid-item tab-heading span">
        <b>Database:</b>
        <?php
        
        if($value_column=='tet_email_template'){
            echo $db1." and ".$db2;
        }
        else {
            echo $db1;
        }
        ?>
    </div>
    
        <div class="grid-item green"><b><?php echo $key_column; ?></b></div>
        <div class="grid-item green"><b><?php echo $value_column; ?></b></div>
        <?php
        foreach($common_column_data as $data) {?>
            <div class="grid-item"><?php echo $data; ?></div>
            <div class="grid-item">
            <?php
            if($value_column=='tet_email_template'){
                
                compareEmailTemplates($conn7, $conn8, $table_name1, $table_name2, $data);
            }
            elseif($value_column=='tcm_value'){
                echo getPairedColumns($conn7, $table_name1, 'tcm_value', 'tcm_key', $data);
            }
            ?>
            </div>
        <?php
        }
        ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    
    <?php if($value_column!='tet_email_template'){   ?>
    <div class="tab-large">
    
    <div class="grid-container-single">
    <div class="grid-item tab-heading">
        <b>Database:</b> <?php echo $db2; ?>
    </div>

        <div class="grid-item green"><b><?php echo $value_column; ?></b></div>
        <?php
        foreach($common_column_data as $data) {?>
            <div class="grid-item">
            <?php
                    if($value_column=='tcm_value'){
                        echo getPairedColumns($conn8, $table_name2, 'tcm_value', 'tcm_key', $data);
                    }
            ?>
            </div>
       <?php  }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    <?php } ?>
	</div><!-- End of container -->
    
    </div>
    

    <div class="right">
	<h3>Non Matching Rows</h3>
	<div class="container">
    <div class="tab-large">
    
    <div class="grid-container">
    <div class="grid-item tab-heading span">
        <b>Database:</b> <?php echo $db1; ?>
    </div>

    <div class="grid-item green"><b><?php echo $key_column; ?></b></div>
    <div class="grid-item green"><b><?php echo $value_column; ?></b></div>
        <?php
        foreach($diff_column_data1 as $data) {?>
            <div class="grid-item"><?php echo $data; ?></div>
            <div class="grid-item">
            <?php if($value_column=='tet_email_template'){
                        
                        compareEmailTemplates($conn7, $conn8, $table_name1, $table_name2, $data);
                    }
                    elseif($value_column=='tcm_value'){
                        echo getPairedColumns($conn7, $table_name1, 'tcm_value', 'tcm_key', $data);
                    }
            ?>
            </div>
        <?php }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
    <div class="tab-large space">
    
    <div class="grid-container">
    <div class="grid-item tab-heading span">
        <b>Database:</b> <?php echo $db2; ?>
    </div>

    <div class="grid-item green"><b><?php echo $key_column; ?></b></div>
    <div class="grid-item green"><b><?php echo $value_column; ?></b></div>
        <?php
        foreach($diff_column_data2 as $data) {?>
            <div class="grid-item"><?php echo $data; ?></div>
            <div class="grid-item">
            <?php if($value_column=='tet_email_template'){
                   
                   compareEmailTemplates($conn7, $conn8, $table_name1, $table_name2, $data);
                  }
                  elseif($value_column=='tcm_value'){
                    echo getPairedColumns($conn8, $table_name2, 'tcm_value', 'tcm_key', $data);
                  }
            ?>
            </div>
       <?php  }
    ?>
    </div><!-- End of grid-container -->
    </div><!-- End of tab -->
	<div><!-- End of container -->
    </div>

</body>
</html>
