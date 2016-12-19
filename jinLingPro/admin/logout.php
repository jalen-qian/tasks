<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/15
 * Time: 13:09
 */
include "../common/common.php";

//开启SESSION
session_start();

//清空SESSION值
$_SESSION = [];


//删除客户端的在COOKIE中的Sessionid
if(isset($_COOKIE[session_name()])){
	setcookie(session_name(),'',time() - 3600,'/');
}
//彻底销毁session
session_destroy();