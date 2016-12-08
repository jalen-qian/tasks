<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/6
 * Time: 14:23
 */
class SubString{
	/**
	 * 截取字符串，如果字符串的长度超过20，则截取前20，并拼接上 '...'
	 * @param $str
	 * @return $str
	 */
	public static function mySubStr($str){
		if(strlen($str) > 60){
			$str = subString($str,0,60).'...';
		}
		return $str;
	}
}