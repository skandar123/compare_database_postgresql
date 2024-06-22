<?php
   $host_other        = "host = localhost";
   $port_other        = "port = 5432";
   $dbname_other      = "dbname = database_name_for_connection2";
   $credentials_other = "user = user_for_connection2 password=password_for_connection2";

   $conn_other = pg_connect("$host_other $port_other $dbname_other $credentials_other");
   if(!$conn_other) {
      echo "Error : Unable to open database\n";
   }
?>