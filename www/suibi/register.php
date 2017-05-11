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
	$result = mysql_query("SELECT * FROM visitor");
	$check=0;
	while($row = mysql_fetch_array($result))
	{
		if(($_POST["id"]==$row['id']))
		{
			$check=1;		
		}	
	}
	if(check==0)
	{
		if(mysql_query("INSERT INTO `web`.`visitor` (`name`, `password`, `email`, `id`) 
			VALUES ('".$_POST['name']."', '".$_POST['password']."', '".$_POST['email']."', '".$_POST['id']."')"))
		{
			echo "注册成功";
			
		}else
		{
			echo "用户已存在";
		}
		
	}else
	{	
		echo "用户已存在";
	}
?>
    <a href="http://www.cxyzf.cn/suibi/login.html">跳转到登陆页面</a>
</body>
</html>