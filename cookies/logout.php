<?php

//流程：如果没有登录，则会自动跳转到登录页面（common.php的逻辑）
// 这里只需要将cookie删除，并提供重新登录的链接
include "common.php";

$username = $_COOKIE["username"];

setcookie("username");

setcookie("userid");

setcookie("islogin");

echo "再见,<b>$username</b>!<br><br><br>";
echo "<a href='login.php'>重新登录</a>";