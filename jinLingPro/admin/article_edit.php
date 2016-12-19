<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/18
 * Time: 19:54
 */
include "../dao/MyPDO.class.php";
include "../session/session.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
$mSession = new jinling\session\Session();
$isArticleUpdate = false;
if(isset($_POST['article_title'])){
	if($_POST['from_type'] == 'new_article'){
		$rowCount = $myPdo -> add(['articles'],['pub_uid'=>$mSession->get('userId'),'title'=>$_POST['article_title'],'content'=>$_POST['article_content'],'pub_time'=>time(),'article_type'=>$_POST['article_type']]);
	}else{
		$articleId = $_POST['article_id'];
		$rowCount = $myPdo -> update(['articles'],["id = $articleId"],['pub_uid'=>$mSession->get('userId'),'title'=>$_POST['article_title'],'content'=>$_POST['article_content'],'pub_time'=>time(),'article_type'=>$_POST['article_type']]);
	}
	if(isset($rowCount) && $rowCount > 0){
		echo "<script> alert('操作成功');location.href='article_list.php'; location.target='main';</script>";
	}else{
		echo "<script> alert('操作失败');location.href='article_list.php'; location.target='main';</script>";
	}
}else if(isset($_GET['article_id']) && $_GET['article_id'] != 0){
	$isArticleUpdate = true;
	$articleObj = $myPdo -> select(['articles'],["*"],['where'=>["id = {$_GET['article_id']}"]])[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>编辑文章</title>
	<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
	<style type="text/css">
		.err{
			text-align: left;
			border: 1px solid red;
			background-color: #FFEBEB;
		}
	</style>
	<script type="text/javascript">
		function check(fm) {
			var eleTitle = document.getElementById("article_title");
			var eleContent = document.getElementById("article_content");
			var errTitle = document.getElementById("err_article_title");
			var errContent = document.getElementById("err_article_content");
			if(eleTitle.value == ""){
				errTitle.style.display = "inline";
				eleTitle.focus();
				return false;
			}
			errTitle.style.display = "none";
			if(eleContent.value == ""){
				errContent.style.display = "inline";
				eleContent.focus();
				return false;
			}
			errContent.style.display = "none";
			return true;
		}
		
	</script>
</head>
<body>
<div class="container">
	<h3 class="marginbot">编辑文章<a href="article_list.php" class="sgbtn">返回文章列表</a></h3>
	<div class="mainbox">
		<form action="#" method="post" enctype="multipart/form-data" target="main" onsubmit="return check(this)">
			<input type="hidden" name = 'from_type' value="<?php if($isArticleUpdate && $articleObj->id != 0){echo 'update_article';}
			else{echo 'new_article';}?>"/>
			<input type="hidden" name = "article_id" value="<?php if($isArticleUpdate && $articleObj->id != 0){ echo $articleObj->id; } ?>"/>
			<table class="opt" style="width:600px;">
				<tbody>
				<tr>
					<th>文章标题：</th>
				</tr>
				<tr>
					<td>
						<input name="article_title" id="article_title" class="txt" value="<?php if($isArticleUpdate && $articleObj->id != 0){echo $articleObj->title;} ?>" style="width:400px;" type="text">
					</td>
					<td><p class="err" style="display:none" id="err_article_title">文章标题不能为空！</p></td>
				</tr>
				<tr>
					<th>文章类别：
						<select name="article_type">
							<option <?php if($isArticleUpdate && $articleObj->id != 0 && $articleObj->article_type == 1){echo "selected = \"selected\"";}?>value="1">公   告</option>
							<option <?php if($isArticleUpdate && $articleObj->id != 0 && $articleObj->article_type == 2){echo "selected = \"selected\"";}?>value="2">资   讯</option>
						</select>
					</th>
				</tr>
				<tr>
					<th>文章内容：</th>
				</tr>
				<tr>
					<td><textarea style="width:400px; height:150px"  name="article_content" id = "article_content"><?php if($isArticleUpdate && $articleObj->id != 0){echo $articleObj->content;} ?></textarea>
					</td>
					<td><p class="err"  id = "err_article_content" style="display: none">文章内容不能为空</p></td>
				</tr>

				</tbody>
			</table>
			<div class="opt"><input name="submit" value=" 提 交 " class="btn" tabindex="3" type="submit"></div>

		</form>
	</div>
</div>
</body>
</html>
