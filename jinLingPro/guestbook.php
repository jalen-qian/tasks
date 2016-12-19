<?php
include "./dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//公司信息
$result = $myPdo -> select(['company_info'],['*'],[]);
$companyInfo = $result[0];
//版权信息
$copyright = $myPdo->select(['copyright'],['*'],['where'=>["cpn_id = {$companyInfo->id}"]])[0];
//查询所有的新闻
$arryNews = $myPdo -> select(['articles'],['id','title','pub_time','article_type'],['where'=>['article_type = 1']]);
//本页面要显示的友情链接
$arryBlogrolls = $myPdo -> select(['blogrolls'],['*'],['where'=>['page_id = 1']]);

if(isset($_POST['sub'])){
	$rowcount = $myPdo-> add(['leave_msgs'],['nickname'=>$_POST['nickname'],'content'=>$_POST['content'],'pub_time'=>time()]);
	var_dump($rowcount);
	if($rowcount > 0){
		echo "<script> alert('您的留言提交成功！');location.href='guestbook.php'; location.target='main';</script>";
	}else{
		echo "<script> alert('操作失败');</script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $companyInfo->cpn_name ?></title>
<link type="text/css" rel="stylesheet" href="style/style.css" />
	<style type="text/css">
		.err{
			text-align: left;
			margin-left:280px;
			border: 1px solid red;
			background-color: #FFEBEB;
		}
	</style>
	<script type="text/javascript">
		function checks(f){
			var eleNickname = document.getElementById("nickname");
			var eleContent = document.getElementById("content");
			var eleErrMsg = document.getElementById("err_msg");
			if(eleNickname.value == ''){
				eleErrMsg.style.display = "inline";
				eleErrMsg.innerText = "请输入昵称";
				eleNickname.focus();
				return false;
			}
			if(eleContent.value == ''){
				eleErrMsg.style.display = "inline";
				eleErrMsg.innerText = "请输入内容";
				eleContent.focus();
				return false;
			}
			eleErrMsg.style.display = "none";
			return true;
		}
	</script>
</head>

<body>
<div class="header">
	<h1 class="logo" title="<?php if(isset($companyInfo) && $companyInfo->id != 0) echo $companyInfo->cpn_name; ?>"><a href="index.php"><img src="images/logo.gif" alt="<?php if(isset($companyInfo) && $companyInfo->id != 0) echo $companyInfo->cpn_name; ?>" /></a></h1>
    <p class="top_r"><a href="#" class="btn_i">设为主页</a><a href="#" class="btn_f">收藏本站</a></p>
</div>
<div class="nav">
	<div class="nav_left"></div>
    <ul>
     	<li><a href="index.php">首  页</a></li>
        <li><a href="about_us.php">公司简介</a></li>
        <li><a href="product_list.php">产品展示</a></li>
        <li><a href="info.php">行业资讯</a></li>
        <li class="sel"><a href="guestbook.php">客户留言</a></li>
        <li><a href="contact_us.php" class="nobg">联系我们</a></li>
     </ul>
     <div class="time"><?php echo date('Y-m-d H:i',time());?></div>
    <div class="nav_right"></div>
</div>
<div class="banner">
	<a href="#"><img src="images/banner.jpg" align="banner" /></a>
</div>
<div class="content">
	<div class="lefter">
		<form action="guestbook.php" method="post" onsubmit="return checks(this)">
    	<div class="title">
        	<h2 class="cBlue fB">客户留言<b class="cGrey fn">Guestbook</b></h2>
        </div>
        <div class="intro" style="padding-top:16px">
        	<label>呢称：</label><input name="nickname" id = "nickname" type="text" /><p class="err" style="display:none" id="err_msg">昵称不能为空</p><br/>
			<label>内容：</label><textarea name="content" id= "content" cols="" rows="" style="width:545px;height:138px"></textarea>
            <input name="sub" type="submit" value="提交" class="btn_input" />
        </div>
		</form>
    </div>
	<div class="righter">
    	<div class="rightBox">
        	<a href="guestbook.php" class="btn_s">我要留言</a>
        </div>
        <div class="blank10"></div>
    	<div class="rightBox">
        	<h3>最新公告<b class="cGrey fn">News</b></h3>
            <ul class="list_r">
				<?php if(isset($arryNews) && count($arryNews) > 0){
					foreach ($arryNews as $key=>$news) {
						?>
						<li>
							<a href="article.php?type=1&id=<?php echo $news->id;?>"><?php  echo mb_substr($news->title,0,13).'...';?></a>
						</li>
						<?php
					}
				} ?>
            </ul>
        </div>
        <div class="blank10"></div>
        <div class="rightBox">
        	<h3>友情链接<b class="cGrey fn">Links</b></h3>
            <ul class="list_r">
				<?php if(isset($arryBlogrolls) && count($arryBlogrolls) > 0){
					foreach ($arryBlogrolls as $blogrollObj){
						?>
						<li><a href="<?php echo $blogrollObj->content ?>" target="_blank"><?php echo $blogrollObj->name ?></a></li>
						<?php
					}
				}?>
            </ul>
        </div>
    </div>
    <div class="hackbox"></div>
    
    
</div>
<div class="footer">
	<p>地址：<?php echo $companyInfo->addr?>  联系人：<?php echo $companyInfo->contacts?>   移动电话：<?php echo $companyInfo->mobile?> 固定电话：<?php echo $companyInfo->fixed_tel?> 传 真：<?php echo $companyInfo->fax?></p>
	<p><?php echo $copyright->copyright_no;?> <?php echo $companyInfo->cpn_name;?> 版权所有</p>
	<p><a href="#"><?php echo $companyInfo->icp_no;?></a></p>
</div>
</body>
</html>
