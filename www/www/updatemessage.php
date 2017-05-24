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
	if(check==0)
	{
		move_uploaded_file($_FILES["file"]["tmp_name"],
		"upload/" . $_FILES["file"]["name"]);
		/* */
		if(mysql_query("UPDATE `web`.`visitor` SET `name` = '".$_POST['name']."',
		`password` = '".$_POST['password']."', `email` = '".$_POST['email']."', `touxiang` = '".$_FILES['file']['name']."', 
		`mylike` = '".$_POST['mylike']."', `sex` = '".$_POST['sex']."',`qianming` = '".$_POST['qianming']."'
		WHERE `visitor`.`id` = '".$_POST['id']."'"))
		{
			
			echo "修改成功";
		}else
		{
			echo "修改失败";
		}
	}
	
?>
    <a href="http://www.cxyzf.cn/suibi/login.html">跳转到登陆页面</a>
</body>
</html>