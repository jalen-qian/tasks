<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/19
 * Time: 11:22
 * 正则表达式
 */
namespace regular\expre;
class RegularExpre{
	public function __construct(){

	}

	/**
	 * 第一题：
	 * $array=array("Linux RedHat9.0", "Apache2.2.9", "MySQL5.0.51", "PHP5.2.6", "LAMP", "100");
	 * 使用正则表达式找出数组中以字母开始和以数字结束，并且没有空格的单元
	 */
	public function findMatchEles(){
		$array = ["Linux RedHat9.0", "Apache2.2.9", "MySQL5.0.51", "PHP5.2.6", "LAMP", "100"];
		$result = [];
		foreach ($array as $value){
			if(preg_match('/^[a-zA-Z]\S*[0-9]$/',$value)){
				$result[] = $value;
			}
		}
		return $result;
	}

	/**
	 * 网址http://www.yaochufa.com/index.php,
	 * 请用正则取出 URL中的协议，URL中的主机, URL中的域名,URL中的文件名
	 */
	public function getMsgsFromUrl($strUrl){
		$result = [];
		//$result['host'] = preg_match_all()
	}
}