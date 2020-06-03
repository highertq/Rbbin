<?php // Example : Log.php
error_reporting(0);
require_once 'header.php';

$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'net';   // Modify these...
$dbuser  = 'root';   // ...variables according
$dbpass  = 'root';   // ...to your installation

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$sql  = "SELECT * FROM log";
$result = mysqli_query($conn, $sql);
?>
<table border=1 cellspacing=0>
  <tr>
    <th>序号</th>
    <th>用户名</th>
    <th>操作</th>
    <th>时间</th>
  </tr>
  <tr>
    <?php

      while($row = mysqli_fetch_row($result)){
        echo "<tr>";
        echo "<td>".$row["0"]."</td>";
        echo "<td>".$row["1"]."</td>";
        echo "<td>".$row["2"]."</td>";
        echo "<td>". date('M jS \'y g:ia:', $row["3"])."</td>";
        echo "</tr>";
      }
    ?>
  </tr>
 <?php
mysqli_close($conn);
?>
