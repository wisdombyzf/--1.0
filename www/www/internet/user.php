<?php
$link=mysql_connect("","root","z753951","internet")or die ("无法打开数据库1");
mysql_select_db("internet")or die("无法打开数据库2");
$result = mysql_query("SELECT * FROM user");
$check=0;

while($row = mysql_fetch_array($result))
{
	if(($_POST["id"]==$row['id'])&&($_POST['password']==$row['password']))
	{
		header('Refresh:5;url=list.php');
		echo "亲爱的";
		echo $_POST["id"];
		echo "欢迎回来";
		$check=1;	
	}	
}
if($check==0)
{
	echo "";
}
?>
