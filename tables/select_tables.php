<?php
include("config.php");
include("config2.php");
include("schema_query.php");
$query1="SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$db1' AND TABLE_SCHEMA = '$s1'";
$query2="SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$db2' AND TABLE_SCHEMA = '$s2'";
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Select Tables</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
Select Schemas
>
Select Tables
</p>
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
</table>
</div>

<form action="" method = "post" name="table_selection">
<input type="hidden" id="db1" name="db1" value="<?php echo $db1; ?>">
<input type="hidden" id="db2" name="db2" value="<?php echo $db2; ?>">
<input type="hidden" id="schema1" name="schema1" value="<?php echo $s1; ?>">
<input type="hidden" id="schema2" name="schema2" value="<?php echo $s2; ?>">

<div class="green-container">

<label for="table1" class="txt form-label">Table 1 :</label>
<select name="table1">
<option value="" selected></option>
<?php
$tables1 = pg_query($conn3,$query1);
if (pg_num_rows($tables1) > 0) {
    while($table1_row = pg_fetch_row($tables1)) {
        ?><option><?php echo $table1_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<label for="table2" class="txt form-label">Table 2 :</label>
<select name="table2">
<option value="" selected></option>
<?php
$tables2 = pg_query($conn4,$query2);
if (pg_num_rows($tables2) > 0) {
    while($table2_row = pg_fetch_row($tables2)) {
        ?><option><?php echo $table2_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<input type="submit" name="select_tables" value="Two Tables" class="btn" onclick="twoTables();"/>
<input type="submit" name="select_columns" value="Select Columns" class="btn" onclick="selectColumns();"/>

</div>
</form>
<script>
function twoTables()
{
 document.table_selection.action ="two_tables.php";
}
function selectColumns()
{
document.table_selection.action = "select_columns.php";
}
</script>

</body>
</html>
