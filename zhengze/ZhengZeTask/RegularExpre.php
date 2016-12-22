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
	 * 第二题：
	 * 网址http://www.yaochufa.com/index.php,
	 * 请用正则取出 URL中的协议，URL中的主机, URL中的域名,URL中的文件名
	 */
	public function getMsgsFromUrl($strUrl){
		preg_match("/^((https?|ftps?):\/\/((www|mail|news)\.([^\.\/]+)\.(com|org|net)))\/([a-zA-z0-9]+\.php|jsp|html)/i",$strUrl,$arry);
		return $arry;
	}

	/**
	 * 用正则取出字符串中的所有网址
	 */
	public function getAllUrls(){
		$str = "<tr><td><a href=\"http://qzone.qq.com\">QQ空间</a></td><td><a href=\"http://www.ganji.com\">赶 集 网</a></td><td><a href=\"http://www.baixing.com\">百 姓 网</a></td><td><a href=\"http://www.taobao.com\">淘 宝 网</a></td><td><a href=\"http://tuan.baidu.com\">百度团购</a></td><td><a href=\"http://www.dianping.com\">大众点评网</a></td></tr>";
		preg_match_all("/(https?|ftps?):\/\/[a-zA-Z0-9]+\.([^\.\/]+)\.(com|org|net)/i",$str,$arry);
		return $arry;
	}
	
	/**
	 * 去掉所有的html标签
	 */
	public function removeHtmlTags($str){
		return preg_replace("/<.*>/U",'',$str);
	}
}