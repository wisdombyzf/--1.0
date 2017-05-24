<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?php include 'findtitle.php' ?></title>
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
            width: 70%;
            text-align: center;
        }
    </style>
</head>
<body style="background-color:rgb(219,221,211);">
    <div id="div0">
        <img src="background.png" />
    </div>
    <div id="div1">
        <h1><?php include 'findtitle.php' ?></h1>
		<br />
        <br />
        <h2 style="text-align:center">简介</h2>
        <?php include 'findabstract.php' ?>
        <br />
        <br />
        <br />
        <br />
        <br />
        <p>简介皆引自我校<a href="http://www.lib.whu.edu.cn">图书馆</a></p>
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
		
		<?php include 'findbody.php' ?>
    </div>
</body>
</html>