<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>test</title>
</head>
<body style="text-align:center">
 <br/>
        <br />
        <br /> <br/>
        <br />
        <br /> <br/>
        <br />
        <br />
		
<?php
	$link=mysql_connect("","root","z753951","web")or die ("无法打开数据库1");
	mysql_select_db("web")or die("无法打开数据库2");
	if(mysql_query("INSERT INTO `web`.`message` (`name`,`email`, `text`) 
	VALUES ('".$_POST['name']."', '".$_POST['email']."', '".$_POST['message']."')"))
	{
		echo "提交成功";
			
	}else
	{
		
		echo "提交失败";
	}
?>
</body>
</html>