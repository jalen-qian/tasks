<?php
include "../dao/MyPDO.class.php";
include "../session/session.php";
$mysession = new \jinling\session\Session();
$myPdo = \jinling\dao\MyPDO::getInstance();

if(isset($_POST['submit'])){
    $currentUser = $myPdo -> select(['user'],['*'],['where'=>["id = {$_POST['userId']}"]])[0];
    $password = $currentUser->password;
    if($_POST['password'] != ''){
        $password = md5($_POST['password']);
    }
    $rowCount = $myPdo->update(['user'],["id = {$_POST['userId']}"],['name'=>$_POST['username'],'password'=>$password,'register_ip'=>$_SERVER["REMOTE_ADDR"],'user_state'=>$_POST['userState']]);
    if(isset($rowCount) && $rowCount > 0){
        if($mysession->get('userId') == $_POST['userId']){
            $mysession->del('username');
            $mysession->del('userId');
            $mysession->del('isLogin');
            $mysession->destroy();
            echo "<script> alert('您已更改密码，请重新登录。。。');location.href='"."login.php"."';location.target='view_window'</script>";
        }else{
            echo "<script> alert('修改成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }
    }else{
        echo "<script> alert('操作失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
    }
}else{
    $currentUser = $myPdo -> select(['user'],['*'],['where'=>["id = {$_GET['userId']}"]])[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑用户资料</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
</head>

<body>
<div class="container">
    <h3 class="marginbot">编辑用户资料<a href="user_list.php" class="sgbtn">返回用户列表</a></h3>
    <div class="mainbox">
        <form action="user_edit.php" target="main" method="post">
            <input type="hidden" name="userId" value="<?php echo $_GET['userId']?>"/>
            <table class="opt">
                <tbody>
                    <tr>
                        <th>用户名:</th>
                    </tr>
                    <tr>
                        <td>
                        <input name="username" class="txt" value="<?php echo $currentUser->name;?>" type="text">
                        </td>
                    </tr>
                    <tr>
                        <th>密　码:<span style="font-weight:normal"> [密码留空，保持不变]</span></th>
                    </tr>
                    <tr>
                        <td>
                        <input name="password" value="" class="txt" type="password"> 
                        </td>
                    </tr>
                    <tr>
                        <th>用户状态：</th>
                        <td>
                            <select name="userState">
                                <option <?php if($currentUser->user_state == '启用') echo "selected = \"selected\""?>>启用</option>
                                <option <?php if($currentUser->user_state == '未启用') echo "selected = \"selected\""?>>未启用</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="opt"><input name="submit" value=" 提 交 " class="btn" tabindex="3" type="submit"></div>
        </form>
    </div>
</div>
</body>
</html>