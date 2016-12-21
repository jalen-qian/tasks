<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/60
 * Time: 11:31
 */
namespace fileFormTask\getFileTypeName;
class GetFileTypeName
{
	private $path = 'var/mnt/share/init/test.php';

	/**
	 * 得到文件扩展名
	 * @return string 文件扩展名 
	 */
	public function getTypeNameOne(){
		$arr =explode('.',$this->path);
		return ".". $arr[count($arr)-1];
	}
	/**
	 * 得到文件扩展名
	 * @return string 文件扩展名
	 */
	public function getTypeNameTwo(){
		return strstr($this->path,'.');
	}
	/**
	 * 得到文件扩展名
	 * @return string 文件扩展名
	 */
	public function getTypeNameThree(){
		return substr($this->path,strrpos($this->path,'.'));
	}
}