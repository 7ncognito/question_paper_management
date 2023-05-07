<?php 

	$imgName = $_FILES['file']['name'];
	$imgTmpName =$_FILES['file']['tmp_name'];
	$imgSize = $_FILES['file']['size'];
	$imgError = $_FILES['file']['error'];
	$imgExt = explode('.', $imgName);

	$actualFileExt = strtolower(end($imgExt));
	$allowed = array('jpg','jpeg','png','pdf','docx');

	if (in_array($actualFileExt, $allowed)) {
		if ($imgError === 0) {
			if ($imgSize < 50000) {
				$fileDestination = '../databaseimg/'.$imgName;
				move_uploaded_file($imgTmpName, $fileDestination);
			} else {
				echo "file size is too big";
			}
		}else{
			echo "error while uploading your file";
		}
	}else {
			echo "you cannot upload files of this type";
	}
	


 