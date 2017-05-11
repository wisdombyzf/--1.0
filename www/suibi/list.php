<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>目录</title>
	<?php
	include 'link.php';
	$perNumber=5;
	$page=$_GET['page'];
	$count=mysql_query("select count(*) from suibi");
	$rs=mysql_fetch_array($count);
	$totalNumber=$rs[0];
	$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
	if (!isset($page))
	{
		$page=1;
	}
	$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
	$result=mysql_query("select * from suibi limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
	?>
    <style type="text/css">
        #div0 {
            width: 100%;
            height: 20em;
            background-color: rgb(219,221,211);
            text-align: right;
        }

        #div1 {
            float: left;
            width: 30%;
            text-align: center;
        }

        #div2 {
            float: left;
            width: 60%;
            text-align: center;
        }

        #div3 {
            float: left;
            width: 10%;
            text-align: center;
        }

        li {
            list-style-type: none;
        }

        h2 {
            color: black;
        }

        a {
            text-decoration: none;
        }
        #footer{
			float: left;
            width: 100%;
            height: 10em;
            background-color: rgb(219,221,211);
            text-align: center;
        }
    </style>
</head>
<body style="background-color:rgb(219,221,211);">
    <div id="div0">
        <img src="background.png" />
    </div>
    <div id="div1">
        <h1>目录待定  </h1>
        <p style="text-align:center"></p>
        <br />
        <br />
        <br />
        <br />
        <br />
        
    </div>
    <div id="div2">
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <ul><?php
           while ($row=mysql_fetch_array($result))
           {
			echo "<li>";
			echo "<a href='";
			echo "main.php?page=";
			echo $row['id'];
			echo  "'>";
			echo "<h2>";
            echo $row['title'];
			echo "</h2>";
            //好丑的代码。。。。把我自己都丑哭了
           }?>

        </ul><?php
           if ($page != 1)
           { //页数不等于1
           ?>
        <a href="list.php?page=<?php echo $page - 1;?>">上一页</a> <!--显示上一页--><?php
           }
           for ($i=1;$i<=$totalPage;$i++)
           	{  //循环显示出页面
           ?>
        <a href="list.php?page=<?php echo $i;?>"><?php echo $i ;?></a><?php
           }
           if ($page<$totalPage) { //如果page小于总页数,显示下一页链接
           ?>
        <a href="list.php?page=<?php echo $page + 1;?>">下一页</a><?php
           }
           ?>
    </div>
    <div id="div3">
    </div>
    <div id="footer">
	</br>
	</br>
	</br>
	</br>
	
    <p style="font-size:0.5em;">躬身自省长此生	半帘人间会相见</p>
    </div>
</body>
</html>