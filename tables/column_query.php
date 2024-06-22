<?php
$db1 = $_POST['db1'];
$db2 = $_POST['db2'];
$s1 = $_POST['schema1'];
$s2 = $_POST['schema2'];
$table1 = $_POST['table1'];
$table2 = $_POST['table2'];
$conn7 = pg_connect("$host $port dbname=$db1 $credentials");
if(!$conn7) {
    echo "Error : Unable to open database\n";
 }
$conn8 = pg_connect("$host_other $port_other dbname=$db2 $credentials_other");
if(!$conn8) {
    echo "Error : Unable to open database\n";
 }
?>