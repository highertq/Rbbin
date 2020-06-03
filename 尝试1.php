<!DOCTYPE html>
<html>
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
         <title></title>   
          <style>        
          table {            
              border-collapse: collapse;           
              font-family: Futura, Arial, sans-serif;       
               }        
          caption {            
              font-size: larger;           
              margin: 1em auto;       
               }       
          th, td {           
              font-size: 12px;            
              padding: .65em;       
               }       
          th {            
              background: #555 nonerepeat scroll 0 0;            
              border: 1px solid #777;           
              color: #fff;        
              }        
          td {           
              border: 1px solid#777;        
              }        
          th {            
              background: #696969;            
              color:#FFFFFF;        
              }        
          tbody tr:nth-child(odd) {            
              background: #ccc;        
              }    
              </style>
              </head>
              <body> </body>
              </html>
              <?php
              $id = 1;
              $con = mysqli_connect('localhost','robinsnest','root', '');
              if (!$con) {die('Could not connect: ' . mysqli_error($con));}
              mysqli_set_charset($con, "utf8");
              echo "<table border='0'>
              <tr>
              <th>ID</th>
              <th>user</th>
              <th>do</th>
              <th>time</th>
              </tr>";
              $fh = mysqli_query($con,"select MAX(id) from log");
              $c_echo = mysqli_fetch_array($fh);
              $maxid = number_format($c_echo['MAX(id)'],0);
              while ($id <= $maxid) 
              {$sql = "SELECT * FROM log WHERE ID = '".$id."'";
                $result = mysqli_query($con,$sql);
                while ($row = mysqli_fetch_array($result)) 
                {echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['user'] . "</td>";
                    echo "<td>" . $row['do'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "</tr>";
                }
                    $id=$id+1;
                }
                    echo "</table>";
                    mysqli_close($con);

