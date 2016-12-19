<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/18
 * Time: 22:21
 */
include "../session/session.php";
$mySession = new jinling\session\Session();
$mySession->del('username');
$mySession->del('userId');
$mySession->del('isLogin');
$mySession->destroy();
echo "退出登录成功，3秒钟之后跳转到登录页面";
echo "<meta http-equiv=\"refresh\" content=\"3; url=login.php\">";
