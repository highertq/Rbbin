<?php 

$link=mysql_connect($dbhost, $dbuser, $dbpass, $dbname);
mysql_select_db("php");
$query  = "SELECT * FROM log ";
$result = queryMysql($query);
$num    = $result->num_rows;

  echo '<table border="1" width="600" align="center">';
  echo '<caption><h1>log</h1></caption>';
  echo '<tr bgcolor="#dddddd">';
  echo '<th>user</th><th>do</th><th>time</th>';
  echo '</tr>';
  //使用双层for语句嵌套二维数组$contact1,以HTML表格的形式输出
  //使用外层循环遍历数组$contact1中的行
  while($row=mysql_fetch_row($result))
  {
      echo'<tr align="center">';
      foreach($row as $data){
          echo "<td>{$data}</td>";
      }
    echo '<tr>';}
    //使用内层循环遍历数组$contact1 中 子数组的每个元素,使用count()函数控制循环次数
    