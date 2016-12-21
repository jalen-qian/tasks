<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/6
 * Time: 15:09.
 */
namespace fileFormTask\messageBoard;
class Message
{
	private $fileName;
	public function __construct($fileName){
		$this->fileName = $fileName;
	}

	/**
	 * 将信息保存到文件中
	 * @param $nickName 留言昵称
	 * @param $content 留言内容
	 */
	public function saveMsg($nickName,$content){
		if (strlen($nickName) > 1 && strlen($content) > 1){
			$strWrite = $this->getDate()." ".$nickName."<br>".$content."<br>";
			file_put_contents($this->fileName, $strWrite, FILE_APPEND);
		}else{
			throw new \RuntimeException("昵称或内容不能为空");
		}
	}
	public function getMsg(){
		$file = fopen($this->fileName, 'r+');
		$content = "";
		while (!feof($file)) {
			$content .= fgets($file);
		}
		fclose($file);
		return $content;
	}
	function getDate(){
		return date('Y-m-d H:i:s', time());
	}
}
?>