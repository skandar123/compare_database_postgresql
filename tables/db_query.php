<?php
$db1 = $_POST['db1'];
$db2 = $_POST['db2'];
$conn1 = pg_connect("$host $port dbname=$db1 $credentials");
if(!$conn1) {
    echo "Error : Unable to open database\n";
 }
$conn2 = pg_connect("$host $port dbname=$db2 $credentials");
if(!$conn2) {
    echo "Error : Unable to open database\n";
 }
?>