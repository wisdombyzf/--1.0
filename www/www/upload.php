<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>反馈</title>
</head>
<body style="text-align:center;">
</br>
</br>
</br></br>
<?php
	
  if ($_FILES['file']['error'] > 0)
    {
    echo "传输失败，请重来" . $_FILES['file']["error"] . "<br />";
    }
  else
  {

    echo "文件名: " ;
	echo $_FILES['file']['name'] ;
	echo "<br />";
    echo "文件类型: " . $_FILES["file"]["type"] . "<br />";
    echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo  " 你已经上传过".$_FILES["file"]["name"] . "了，   别xjb搞";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
	  echo  "上传成功";
      //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
?>
</body>
</html>