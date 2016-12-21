<?php
/**
 * test
 */
include "fileUpload.class.php";
$fileUpload = new fileFormTask\fileUpload\FileUpload($_FILES['file']['name'],'./');
$result = $fileUpload->upload();
if($result){
	echo "文件上传成功！";
}else{
	echo "文件上传失败";
}
