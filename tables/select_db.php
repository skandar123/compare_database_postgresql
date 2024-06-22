<?php
include("config.php");
include("config2.php");
$query_dbs="SELECT datname FROM pg_database";
?>
<!DOCKTYPE html>
<head>
<title>Compare Databases</title>
<link rel="stylesheet" href="style_compare_tables.css">
</head>

<body>
<h2>Select Databases</h2>

<form action="" method = "post" name="database_selection">

<div class="green-container">

<label for="db1" class="txt">Database 1 :</label>
<select name="db1">
<option value="" selected></option>
<?php
$dbs = pg_query($conn,$query_dbs);
if (pg_num_rows($dbs) > 0) {
    while($db1_row = pg_fetch_row($dbs)) {
        ?><option><?php echo $db1_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<label for="db2" class="txt">Database 2 :</label>
<select name="db2">
<option value="" selected></option>
<?php
$dbs = pg_query($conn_other,$query_dbs);
if (pg_num_rows($dbs) > 0) {
    while($db2_row = pg_fetch_row($dbs)) {
        ?><option><?php echo $db2_row[0]; ?></option>
    <?php
    }
}
?>
</select>

<input type="submit" name="select_schemas" value="Select Schemas" class="btn" onclick="selectSchemas();"/>
<input type="submit" name="all_schemas" value="All Schemas" class="btn" onclick="allSchemas();"/>
</div>
</form>
<script>
function selectSchemas()
{
 document.database_selection.action ="select_schemas.php";
}
function allSchemas()
{
document.database_selection.action = "all_schemas.php";
}
</script>
</body>
</html>
