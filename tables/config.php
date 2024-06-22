<?php
   $host        = "host = localhost";
   $port        = "port = 5432";
   $dbname      = "dbname = database_name_for_connection1";
   $credentials = "user = user_for_connection1 password=password_for_connection1";

   $conn = pg_connect("$host $port $dbname $credentials");
   if(!$conn) {
      echo "Error : Unable to open database\n";
   }
?>
