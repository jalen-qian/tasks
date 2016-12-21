
<?php
include 'Message.php';
$message = new fileFormTask\messageBoard\Message("msg.txt");
if(isset($_POST['submit'])){
	try{
		$message->saveMsg($_POST["nickName"],$_POST["content"]);
	}catch (RuntimeException $e){
		echo $e->getMessage();
	}
}
?>
<html>
<title>留言板测试</title>
<body>
<h2>我的留言本</h2>
<hr/>
<?php
    echo $message->getMsg();
?>
<br>
<br>
<hr>
<form action="test.php" enctype="multipart/form-data" method="post">
	<b>昵称：</b><input type="text" name="nickName" id="username"><br/><br/>
	<b>内容：</b><textarea name="content" style="width:350px;height:150px;"></textarea><br/><br/>
	<input type="submit" name="submit" value="提交">
</form>
</body>
</html>