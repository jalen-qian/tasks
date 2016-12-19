<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/15
 * Time: 9:28
 */
ini_set("session.use_trans_sid",1);
ini_set("session.use_only_cookies",0);
ini_set("session.use_cookies",1);
session_start();
if(!$_SESSION["isLogin"]){
	header("Location:../admin/login.php");
}