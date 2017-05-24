<?php
  if ($_FILES['file']['error'] > 0)
    {
    echo "Return Code: " . $_FILES['file']["error"] . "<br />";
    }
  else
    {
		echo "我也很无奈啊";
		if (!is_dir('upload/'))
	{
		mkdir('upload/');
		echo "dfas";
	}else
	{
		echo "dsfsadfdsa";
	}

    echo "Upload: " ;
	echo $_FILES['file']['name'] ;
	echo "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
?>