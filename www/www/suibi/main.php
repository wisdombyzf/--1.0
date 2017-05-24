<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
	<?php  
	include 'link.php';
	$page=$_GET['page'];
	$result = mysql_query("SELECT * FROM suibi");
	while($find=mysql_fetch_array($result))
	{
	if($page==$find['id'])
		{
			$title=$find['title'];
			$body=$find['body'];
			break;
		}
	}
	?>
    <title><?php echo $title ?></title>
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
        <h1><?php echo $title ?></h1>
		<br />
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
		
		<?php echo $body  ?>
    </div>
	<div id="div3">
    </div>
    <div id="footer">
	</br>
	</br>
	</br>
	</br>
    <p style="font-size:0.5em;">躬身自省长此生	半帘人间会相见</p>
	<p style="font-size:0.5em;"></p>
    </div>
</body>
</html>