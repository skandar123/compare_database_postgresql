# PostgreSQL Database Comparison Tool (PHP)

### 📌 Overview

This project is a web-based PHP application to compare PostgreSQL databases at different levels.
It provides a structured UI to explore and compare:

* Databases
* Schemas
* Tables
* Columns
* Even paired column data (e.g., email templates, key-value pairs)

### 🚀 Features

* Database-level comparison
  * Select two PostgreSQL databases from a server.
  * Compare all schemas, highlight matching and non-matching ones.
* Schema-level comparison
  * Explore schemas in both databases.
  * Identify schemas present in one DB but missing in another.
* Table-level comparison
  * Compare tables inside selected schemas.
  * Find common tables and highlight column differences.
* Column-level comparison
  * Drill down into columns of selected tables.
  * Detect datatype mismatches.
* Paired column data comparison
  * Special handling for paired key-value or email template columns.
  * Normalize and compare HTML email templates.
  * Highlight identical vs differing rows across databases.
* Interactive UI
  * Navigation flows: Select Databases → Select Schemas → Select Tables → Select Columns.
  * Tabular, grid-based output styled with CSS.
  * Clear distinction between ✅ matching and ⚠️ non-matching elements.

### 📂 Project Structure

    tables
    ├── config.php              # PostgreSQL connection for DB1
    ├── config2.php             # PostgreSQL connection for DB2
    ├── db_query.php            # Common DB query functions
    ├── schema_query.php        # Schema-level query functions
    ├── table_query.php         # Table-level query functions
    ├── column_query.php        # Column-level query functions
    ├── common_functions.php    # Helpers (HTML normalization, comparison, etc.)
    ├── select_db.php           # UI to select databases
    ├── select_schemas.php      # UI to select schemas
    ├── select_tables.php       # UI to select tables
    ├── select_columns.php      # UI to select columns
    ├── all_schemas.php         # Compare all schemas
    ├── all_tables.php          # Compare all tables in selected schemas
    ├── two_tables.php          # Compare two specific tables
    ├── two_columns.php         # Compare two paired columns
    ├── style_compare_tables.css# CSS styles for UI

### ⚙️ Requirements

1. PHP 7.4+ (with pgsql extension enabled)
2. PostgreSQL 11+
3. Web server (Apache/Nginx with PHP)

### 🔧 Setup Instructions

Clone or copy the project into your web server root:

    git clone <repo-url>
    cd pg-database-compare


Update PostgreSQL connection details in config.php and config2.php:

// config.php

    $host        = "host = localhost";
    $port        = "port = 5432";
    $dbname      = "dbname = database_name_for_connection1";
    $credentials = "user = user1 password=your_password";

// config2.php

    $host_other        = "host = localhost";
    $port_other        = "port = 5432";
    $dbname_other      = "dbname = database_name_for_connection2";
    $credentials_other = "user = user2 password=your_password";


Start your PostgreSQL and web server.

Open in browser:

    http://localhost/pg-database-compare/select_db.php

### 🖥️ Usage Workflow

1. Select Databases → Pick DB1 and DB2.

   * Options: Compare all schemas or Select specific schemas.

2. Select Schemas → Choose schemas from both DBs.

   * Options: Compare all tables or Select specific tables.

3. Select Tables → Choose tables to compare.

   * Options: Compare all columns or Select specific columns.

4. Select Columns → Choose paired columns to compare.

   * Special logic for:
     * tet_email_code + tet_email_template
     * tcm_key + tcm_value

5. View Results:

   * Matching schemas/tables/columns are displayed in green.
   * Non-matching elements are separated and highlighted.
   * Paired columns show row-level comparisons.

### 🎨 UI Styling

* SeaGreen highlights matching structures.
* Grey/DarkGreen indicate structural differences.
* Responsive grid layout with categories:
  * Matching Schemas
  * Non-Matching Schemas
  * Common Schema, Different Tables
  * Common Table, Different Columns
  * Row-level differences

### 📌 Example Use Case

* Compare two versions of the same database (e.g., production vs staging).
* Verify schema consistency after migrations.
* Compare email templates stored as HTML across environments.
* Identify missing or mismatched tables/columns in large multi-schema databases.

### 👩‍💻 Author

Sayantika Kandar