<?php
include("config.php");
include("config2.php");
include("column_query.php");
$query1="SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_CATALOG = '$db1' AND TABLE_SCHEMA = '$s1' AND TABLE_NAME='$table1'";
$query2="SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_CATALOG = '$db2' AND TABLE_SCHEMA = '$s2'AND TABLE_NAME='$table2'";
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Select Columns</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
Select Schemas
>
Select Tables
>
Select Columns
</p>
</div>
</div>

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
</table>
</div>

<form action="two_columns.php" method = "post">
<input type="hidden" id="db1" name="db1" value="<?php echo $db1; ?>">
<input type="hidden" id="db2" name="db2" value="<?php echo $db2; ?>">
<input type="hidden" id="schema1" name="schema1" value="<?php echo $s1; ?>">
<input type="hidden" id="schema2" name="schema2" value="<?php echo $s2; ?>">
<input type="hidden" id="table1" name="table1" value="<?php echo $table1; ?>">
<input type="hidden" id="table2" name="table2" value="<?php echo $table2; ?>">
<div class="green-container">

<label for="column1" class="txt form-label">Column 1 :</label>
<select name="column1">
<option value="" selected></option>
<?php
$columns1 = pg_query($conn7,$query1);
if (pg_num_rows($columns1) > 0) {
    while($column1_row = pg_fetch_row($columns1)) {
        ?><option><?php echo $column1_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<label for="column2" class="txt form-label">Column 2 :</label>
<select name="column2">
<option value="" selected></option>
<?php
$columns2 = pg_query($conn8,$query2);
if (pg_num_rows($columns2) > 0) {
    while($column2_row = pg_fetch_row($columns2)) {
        ?><option><?php echo $column2_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<input type="submit" name="submit" value="Two Columns" class="btn"/>

</div>
</form>

</body>
</html>