<?php

//功能：如果当前用户没有登录，则跳转到登录页面
if($_COOKIE["islogin"] != true){
	header("Location:login.php");
}