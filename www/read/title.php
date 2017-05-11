<?php
	include 'link.php';
	$result = mysql_query("SELECT * FROM myread");
	$a=mysql_fetch_array($result);
	echo $a['title'];
?>