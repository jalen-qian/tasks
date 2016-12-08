<?php
    //如果表单被初始化了，则做操作
	if(isset($_POST["username"])){
		//连接数据库
	    include "conn_db.php";
	    $sql = "select * from user where username = '{$_POST["username"]}' and password ='".md5($_POST["password"])."';";
	    //查询数据库
		$result = $mysqli->query($sql);
		//查询到了数据
		if($result->num_rows > 0){
			echo "查询到了<br>";
			$user = $result -> fetch_assoc();
			//设置cookie
			$time = time() + 3600* 24;
			setcookie("username",$user["username"],$time);
			setcookie("userid",$user["id"],$time);
			setcookie("islogin",true,$time);
			//跳转到index.php
			header("Location:index.php");
		}else{
			echo "用户名或者密码错误!";
		}
	}
    
?>

<html>
     <head>
	        <title>用户登录</title>
	 </head>
	 <body>
	        <form action = "login.php" method = "post">
	        <table border = '1' align='center'>
			    <caption><h2>用户登录</h2></caption>
			    <tr>
				    <td>
					   用户名
					</td>
					<td>
					    <input name="username" type = "text" >
					</td>
				</tr>
				<tr>
				    <td>
					   密 码
					</td>
					<td>
					    <input name="password" type = "password" >
					</td>
				</tr>
				<tr>
				    <td colspan = '2' align = "center">
					   <input type="submit" value="登录">
					</td>
				</tr>
			</table>
			</form>
	 </body>
</html>