<?php
$db1 = $_POST['db1'];
$db2 = $_POST['db2'];
$s1 = $_POST['schema1'];
$s2 = $_POST['schema2'];
$conn5 = pg_connect("$host $port dbname=$db1 $credentials");
if(!$conn5) {
    echo "Error : Unable to open database\n";
 }
$conn6 = pg_connect("$host_other $port_other dbname=$db2 $credentials_other");
if(!$conn6) {
    echo "Error : Unable to open database\n";
 }
?>
