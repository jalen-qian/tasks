<?php

class Cookie{
	/**
	* 创建一个cookie
	*/
	public function set($name,$value,$time){
		if(!isset($name)){
			return false;
		}
		if($time < 0){
			$time = 3600 * 24;
		}
		setcookie($name,$value,$time()+$time);
	}
	
	/**
	* 获取cookie
	*/
	public function get($name){
		if(!isset($name)){return false;}
		
		return $_COOKIE[$name];
	}
	
	/**
	* 销毁一个cookie
	*/
	public function destroy($name){
		if(!isset($name)){return false;}
		if(isset($_COOKIE[$name])){
			setcookie($name,'',$time() - 3600);
		}
	}
}