<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/15
 * Time: 9:26
 */
namespace jinling\session;

class Session
{
	public function __construct()
	{
		ini_set("session.use_trans_sid",1);
		ini_set("session.use_only_cookies",0);
		ini_set("session.use_cookies",1);
		session_start();
	}

	public function set($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	public function get($name)
	{
		if(isset($_SESSION[$name]))
			return $_SESSION[$name];
		else
			return false;
	}

	public function del($name)
	{
		unset($_SESSION[$name]);
	}

	public function destroy()
	{
		if(isset($_COOKIE[session_id()])){
			setcookie(session_id(),'',time() - 3600,'/');
		}
		$_SESSION = [];
		session_destroy();
	}

}