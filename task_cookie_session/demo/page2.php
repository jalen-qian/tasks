<?php
include "common.php";
include "conn_db.php";
echo "欢迎您，<b>{$_COOKIE["username"]}</b>,这里是网站第二页<br>";
echo "您具有以下权限：<br>";
//查询该用户的权限
$sql = "select permiss_1,permiss_2,permiss_3,permiss_4 from user where username = '{$_COOKIE["username"]}';";
$result = $mysqli -> query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	if($row["permiss_1"] == 1){
		echo "11111111111111111111111111<br>";
	}
	if($row["permiss_2"] == 1){
		echo "22222222222222222222222222<br>";
	}
	if($row["permiss_3"] == 1){
		echo "33333333333333333333333333<br>";
	}
	if($row["permiss_4"] == 1){
		echo "44444444444444444444444444<br>";
	}
}

?>
<a href = "login.php">登录页</a><br>
<a href = "index.php">首页</a><br>
<a href = "page2.php">第二页</a><br>
<a href = "page3.php">第三页</a><br>
<a href = "logout.php">退出登录</a><br>