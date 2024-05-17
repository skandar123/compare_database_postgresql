<?php
include("db_query.php");
$s1 = $_POST['schema1'];
$s2 = $_POST['schema2'];
$conn3 = pg_connect("$host $port dbname=$db1 $credentials");
if(!$conn3) {
    echo "Error : Unable to open database\n";
 }
$conn4 = pg_connect("$host $port dbname=$db2 $credentials");
if(!$conn4) {
    echo "Error : Unable to open database\n";
 }
?>