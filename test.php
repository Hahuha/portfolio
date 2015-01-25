<?php
require_once 'application/utils/database.php';

$sql =<<<EOF
      CREATE TABLE projet
      (id INT PRIMARY KEY     NOT NULL,
      title           TEXT    NOT NULL,
      AGE            INT     NOT NULL,
      ADDRESS        CHAR(50),
      SALARY         REAL);
EOF;
?>