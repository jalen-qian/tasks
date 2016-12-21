<?php
/**
 * Created by PhpStorm.
 */
namespace fileFormTask\fileUpload;
class FileUpload{
	private $fileName = null;//要上传的文件名称
	private $upload_dir = null;//要上传的路径
	
	public function __construct($fileName,$upload_dir){
		$this->fileName = $fileName;
		$this->upload_dir = $upload_dir;
	}
	public function upload(){
		//得到扩展名
		$arry = explode('.', $this->fileName);
		$extension = $arry[count($arry) - 1];

		//获取缓存目录内的上传的文件路径
		$fileSrc = $_FILES['file']['tmp_name'];
		//产生随机名
		$randName = date("YmdHis",time()).'.'.$extension;
		//从缓冲区重命名和拷贝上传的文件
		if (is_uploaded_file($fileSrc)){        //判断上传的文件是否存在
			if (move_uploaded_file($fileSrc, $this->upload_dir.$randName)) {
				return $randName;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}