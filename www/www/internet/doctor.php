<?php 
$link=mysql_connect("","root","z753951","internet")or die ("无法打开数据库1");
	mysql_select_db("internet")or die("无法打开数据库2");
$result=mysql_query("SELECT * FROM doctor");
$check=0;
	while($row = mysql_fetch_array($result))
	{
		if(($_GET["name"]==$row['name']))
		{
			echo $row['name'];
			echo $row['sex'];
			echo $row['year'];
			echo $row['address'];
			echo $row['subject'];
			$check=1;
		}	
	}
	if($check==0)
	{
		echo "该医生不存在";
	}


?>