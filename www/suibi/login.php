<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>test</title>
</head>
<body style="text-align:center">
    
	<?php
$link=mysql_connect("","root","z753951","web")or die ("无法打开数据库1");
mysql_select_db("web")or die("无法打开数据库2");
$result = mysql_query("SELECT * FROM visitor");
$check=0;

while($row = mysql_fetch_array($result))
{
	if(($_POST["id"]==$row['id'])&&($_POST['password']==$row['password']))
	{
		echo "<br /><br /><br />";
		echo "<br /><br /><br />";
		echo "亲爱的";
		echo $_POST["id"];
		echo "欢迎回来";
		echo "<br /><br /><br />";
		echo "<a href="."list.php".">点击此处跳转</a>";
		$pp = mysql_query("SELECT * FROM myread");
		$a=mysql_fetch_array($pp);
		
		
		
		
		
		$check=1;
		
	}	
}
if($check==0)
{
	echo "用户不存在";
	echo "<br />";
	echo "（你可以尝试暴力破解，反正我还没有验证码或者封IP的反制措施哦ヾ(o◕∀◕)ﾉヾ）";
}



?>

</body>
</html>