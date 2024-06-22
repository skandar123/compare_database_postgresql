<?php
include("config.php");
include("config2.php");
include("db_query.php");
$query1="SELECT DISTINCT TABLE_SCHEMA FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$db1'";
$query2="SELECT DISTINCT TABLE_SCHEMA FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$db2'";
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Select Schemas</h2>
<div>
<p>
<a href="select_db.php">Select Databases</a>
>
Select Schemas
</p>
</div>

<div class="table-container">
<table>
    <tr><th colspan="4">Data Selected</th><tr>
    <tr>
        <td><b>Database1:</b></td><td><?php echo $db1; ?></td>
        <td><b>Database2:</b></td><td><?php echo $db2; ?></td>
    </tr>
</table>
</div>

<form action="" method = "post"  name="schema_selection">
<input type="hidden" id="db1" name="db1" value="<?php echo $db1; ?>">
<input type="hidden" id="db2" name="db2" value="<?php echo $db2; ?>">

<div class="green-container">

<label for="schema1" class="txt form-label">Schema 1 :</label>
<select name="schema1">
<option value="" selected></option>
<?php
$schemas1 = pg_query($conn1,$query1);
if (pg_num_rows($schemas1) > 0) {
    while($schema1_row = pg_fetch_row($schemas1)) {
        ?><option><?php echo $schema1_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<label for="schema2" class="txt form-label">Schema 2 :</label>
<select name="schema2">
<option value="" selected></option>
<?php
$schemas2 = pg_query($conn2,$query2);
if (pg_num_rows($schemas2) > 0) {
    while($schema2_row = pg_fetch_row($schemas2)) {
        ?><option><?php echo $schema2_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<input type="submit" name="select_tables" value="Select Tables" class="btn"  onclick="selectTables();"/>
<input type="submit" name="test_all_tables" value="All Tables" class="btn" onclick="allTables();"/>
</div>
</form>
<script>
function selectTables()
{
document.schema_selection.action = "select_tables.php";
}
function allTables()
{
document.schema_selection.action = "all_tables.php";
}
</script>
</body>
</html>
