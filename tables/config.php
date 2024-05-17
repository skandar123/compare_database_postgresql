<?php
   $host        = "host = localhost";
   $port        = "port = 5432";
   $dbname      = "dbname = your_database_name";
   $credentials = "user = postgres password=your_password";

   $conn = pg_connect("$host $port $dbname $credentials");
   if(!$conn) {
      echo "Error : Unable to open database\n";
   }
?>