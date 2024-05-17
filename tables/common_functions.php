<?php
function getSchemas($db)
{
    $result = pg_query($db,
     "SELECT schema_name FROM information_schema.schemata
     WHERE schema_name NOT LIKE 'pg_%' AND schema_name!='information_schema'");
    if (!$result) {
        die("Error fetching columns: " . pg_last_error($db));
    }

    $schemas = [];
   
    while ($row = pg_fetch_assoc($result)) {
        $schemas[] = $row['schema_name'];
    }

   return $schemas;
}

function getTables($db, $schema)
{
    $result = pg_query($db, "SELECT DISTINCT table_name FROM information_schema.columns WHERE table_schema='$schema'");
    if (!$result) {
        die("Error fetching columns: " . pg_last_error($db));
    }

   $tables = [];
   
    while ($row = pg_fetch_assoc($result)) {
        $tables[] = $row['table_name'];
    }

   return $tables;
}

function getTableColumns($db, $tableName)
{
    $result = pg_query($db, "SELECT column_name FROM information_schema.columns WHERE table_name = '$tableName'");
    if (!$result) {
        die("Error fetching columns: " . pg_last_error($db));
    }

   $columns = [];
   
    while ($row = pg_fetch_assoc($result)) {
        $columns[] = $row['column_name'];
    }

   return $columns;
}

function getTableDataType($db, $tableName, $columnName)
{
    $result = pg_query($db,
    "SELECT data_type FROM information_schema.columns WHERE table_name = '$tableName' AND column_name='$columnName'");
    if (!$result) {
        die("Error fetching data types: " . pg_last_error($db));
    }
    $row = pg_fetch_assoc($result);
    return $row['data_type'];
}

function getAllMatchingTableData($db1, $db2, $table){
    $columns1 = getTableColumns($db1, $table);
    $columns2 = getTableColumns($db2, $table);
    $commonColumns = array_intersect($columns1, $columns2);
    $match=[[]];
    $count=0;
    foreach($commonColumns as $data){
        $data_type1=getTableDataType($db1, $table, $data);
        $data_type2=getTableDataType($db2, $table, $data);
        $match[$count]['table']=$table;
        $match[$count]['column']=$data;
        $match[$count]['data_type1']=$data_type1;
        $match[$count]['data_type2']=$data_type2;
        $count++;
    }
    return $match;
}

function getAllNonMatchingTableData1($db1Name, $db1, $db2, $table){
    $columns1 = getTableColumns($db1, $table);
    $columns2 = getTableColumns($db2, $table);
    $diff1=array_diff($columns1, $columns2);
    
    $from_db1=[[]];
    $count=0;
    foreach($diff1 as $data){
        $data_type=getTableDataType($db1, $table, $data);
        $from_db1[$count]['database']=$db1Name;
        $from_db1[$count]['table']=$table;
        $from_db1[$count]['column']=$data;
        $from_db1[$count]['data_type']=$data_type;
        $count++;
    }
    return $from_db1;
}

function getAllNonMatchingTableData2($db2Name, $db1, $db2, $table){
    $columns1 = getTableColumns($db1, $table);
    $columns2 = getTableColumns($db2, $table);
    $diff2=array_diff($columns2, $columns1);
    
    $from_db2=[[]];
    $count=0;
    foreach($diff2 as $data){
        $data_type=getTableDataType($db2, $table, $data);
        $from_db2[$count]['database']=$db2Name;
        $from_db2[$count]['table']=$table;
        $from_db2[$count]['column']=$data;
        $from_db2[$count]['data_type']=$data_type;
        $count++;
    }
    return $from_db2;
}

function getColumnNameDataType($db, $tableName)
{
    $result = pg_query($db,
     "SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$tableName'");
    if (!$result) {
        die("Error fetching columns: " . pg_last_error($db));
    }

    $table_data = [[]];
   
    $count=0;
    while ($row = pg_fetch_assoc($result)) {
        $table_data[$count]['table_name'] = $tableName;
        $table_data[$count]['column_name'] = $row['column_name'];
        $table_data[$count]['data_type'] = $row['data_type'];
        $count++;
    }

   return $table_data;
}

function getDatabaseDetails($db, $schemaName, $tableName)
{
    $result = pg_query($db,
     "SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$tableName'");
    if (!$result) {
        die("Error fetching columns: " . pg_last_error($db));
    }

    $table_data = [[]];
   
    $count=0;
    while ($row = pg_fetch_assoc($result)) {
        $table_data[$count]['schema_name'] = $schemaName;
        $table_data[$count]['table_name'] = $tableName;
        $table_data[$count]['column_name'] = $row['column_name'];
        $table_data[$count]['data_type'] = $row['data_type'];
        $count++;
    }

   return $table_data;
}
?>