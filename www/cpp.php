<?php
    if(isset($_POST['user']))
    {
		$link=mysql_connect("","root","z753951");
		mysql_select_db("fivechess")or die("无法打开数据库2");   
		$result = mysql_query("SELECT * FROM user");
		while($row = mysql_fetch_array($result))
		{
			
			$a=$_POST['user'];
			$b=$row['name'];
			echo $a;
			echo $b;
			if($a==$b)
			{
				echo $row['password'];
				echo $_POST['user'];
			}
		}
        //echo $_POST['user'];
    }
?>