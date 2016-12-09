<?php
/**
* @author qianwenjun
* @date 2016/12/7
* 封装的Session类
*/
class Session{
	/**
	* 开启session
	*/
	public function start(){
		session_start();
	}
	
	/**
	* 创建一个session
	*/
	public function create($name,$value){
		if(isset($name) && isset($value)){
			$_SESSION[$name] = [$value];
		}
	}
	/**
	* 查询session
	*/
	public function get($name){
		if(isset($_SESSION[$name])){
			return $_SESSION[$name];
		}
	}
	/**
	* 销毁一个session
	*/
	public function destroy($name){
		$_SESSION = [];
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-3600);
		}
		session_destroy();
	}
}