<?php
$link=mysql_connect("","root","z753951")or die ("无法");
if (!$link)
  {
  die('Could not connect: ' . mysql_error());
  }

if (mysql_query("CREATE DATABASE mydfgsgfsd",$link))
  {
  echo "Database created";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

mysql_close($link);

?>




