<?php
include "../dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//查询出所有的用户信息
$users = $myPdo->select(['user'],['*'],[]);
if(isset($_POST['subAddUser'])){
    $resultCount = $myPdo -> add(['user'],['name'=>$_POST['username'],'password'=>md5($_POST['password']),'register_time'=>time(),'register_ip'=>$_SERVER['REMOTE_ADDR']]);
    if(isset($resultCount) && $resultCount > 0){
        echo "<script> alert('添加成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }else{
        echo "<script> alert('添加失败');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }
}
if(isset($_POST['subDelUser'])) {
//统计要删除的文章id
    $where = '';
    foreach ($users as $user) {
        if (isset($_POST[(string)$user->id])) {
            $where .= "id = " . $user->id . ' or ';
        }
    }
    $where = substr($where, 0, -4);
    if ($where != '') {
        $myPdo->delete(['user'], [$where]);
        echo "<script> alert('操作成功');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
    } else {
        echo "<script> alert('请选择要删除的文章');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员列表</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>

<div class="container">
    <div class="hastabmenu">
        <form action="user_list.php" target="main" method="post">
        <ul class="tabmenu">
            <li id="adduserbtn" class="tabcurrent"><a href="#" >添加管理员</a></li>
        </ul>
        <div id="adduserdiv" class="tabcontentcur">
            <table width="100%">
                <tbody>
                    <tr>
                        <td>用户名:</td>
                        <td><input name="username" class="txt" type="text"></td>
                        <td>密码:</td>
                        <td><input name="password" class="txt" type="password"></td>
                        <td><input value="提 交" name = "subAddUser" class="btn" type="submit"></td>
                    </tr>
            	</tbody>
            </table>
            </form>
        </div>
	</div>

    <br>
    <h3>管理员列表</h3>
    <div class="mainbox">
        <form action="user_list.php" target="main" method="post">
            <table class="datalist fixwidth">
                <tbody>
                    <tr>
                        <th>
                        	<input name="chkall" id="chkall" class="checkbox" type="checkbox"><label for="chkall">删除</label>
                        </th>
                        <th>用户名</th>
                        <th>注册日期</th>
                        <th>注册IP</th>
                        <th>用户状态</th>
                        <th>编辑</th>
                    </tr>
                    <?php
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td class=\"option\">";
                        echo "<input name=\"".$user->id."\" value=\"".$user->id."\" class=\"checkbox\" type=\"checkbox\">";
                        echo "</td>";
                        echo "<td><strong>".$user->name."</strong></td>";
                        echo "<td>".date('Y-m-d H:i',$user->register_time)."</td>";
                        echo "<td>".$user->register_ip."</td>";
                        echo "<td>".$user->user_state."</td>";
                        echo "<td><a href=\"user_edit.php?userId=".$user->id."\">编辑</a></td>";
                        echo "</tr>";
                        }
                    ?>
                    <tr class="nobg">
                        <td><input value="提 交" name="subDelUser" class="btn" type="submit"></td>
                        <td class="tdpage" colspan="6">
                            <div class="pages">
                            <em>100</em>
                            <strong>1</strong>
                            <a href="">2</a>
                            <a href="">3</a>
                            <a href="">4</a>
                            <a href="" class="next">&rsaquo;&rsaquo;</a>
                            <a href="" class="last">... </a>
                            <kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}" /></kbd>
                            </div>
                      	</td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
</body>
</html>