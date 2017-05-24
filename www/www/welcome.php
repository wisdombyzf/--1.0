<?php
$link=mysql_connect("","root","z753951")or die ("无法");
mysql_select_db("web")or die("无法打开");
$result = mysql_query("SELECT * FROM visitor");
while($row = mysql_fetch_array($result))
  {
   echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['password'] . "</td>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "</tr>";
 
  }

?>




