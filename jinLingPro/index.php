<?php
include "./dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//公司信息
$result = $myPdo -> select(['company_info'],['*'],[]);
$companyInfo = $result[0];
//版权信息
$copyright = $myPdo->select(['copyright'],['*'],['where'=>["cpn_id = {$companyInfo->id}"]])[0];
//产品信息
$arryProducts = $myPdo -> select(['products'],['*'],[]);
//查询所有的新闻
$arryNews = $myPdo -> select(['articles'],['id','title','pub_time','article_type'],['where'=>['article_type = 1']]);
//查询所有的资讯
$arryInfromations = $myPdo -> select(['articles'],['id','title','pub_time','article_type'],['where'=>['article_type = 2']]);
//本页面要显示的友情链接
$arryBlogrolls = $myPdo -> select(['blogrolls'],['*'],['where'=>['page_id = 1']]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $companyInfo -> cpn_name;?>-首页</title>
<link type="text/css" rel="stylesheet" href="style/style.css" />
</head>

<body>
<div class="header">
	<h1 class="logo" title="<?php if(isset($companyInfo) && $companyInfo->id != 0) echo $companyInfo->cpn_name; ?>"><a href="index.php"><img src="images/logo.gif" alt="<?php if(isset($companyInfo) && $companyInfo->id != 0) echo $companyInfo->cpn_name; ?>" /></a></h1>
    <p class="top_r"><a href="#" class="btn_i">设为主页</a><a href="#" class="btn_f">收藏本站</a></p>
</div>
<div class="nav">
	<div class="nav_left"></div>
    <ul>
     	<li class="sel"><a href="index.php">首  页</a></li>
        <li><a href="about_us.php">公司简介</a></li>
        <li><a href="product_list.php">产品展示</a></li>
        <li><a href="info.php">行业资讯</a></li>
        <li><a href="guestbook.php">客户留言</a></li>
        <li><a href="contact_us.php" class="nobg">联系我们</a></li>
     </ul>
     <div class="time"><?php echo date('Y-m-d H:i',time());?></div>
    <div class="nav_right"></div>
</div>
<div class="banner">
	<a href="#"><img src="images/banner.jpg" align="banner" /></a>
</div>
<div class="content">
	<div class="w475_l">
    	<div class="title">
        	<h2 class="cBlue fB">公司简介<b class="cGrey fn">About us</b></h2>
        </div>
        <div class="intro">
			<?php if(isset($companyInfo) && $companyInfo->id != 0){
				      if(isset($_GET['cpn_intro_watch_more']) && $_GET['cpn_intro_watch_more']) {
						  echo $companyInfo->cpn_intro;
						  echo "<a href=\"index.php\" class=\"cBlue\"> 收起...</a>";
					  }else{
						  echo mb_substr($companyInfo->cpn_intro, 0, 150);
						  echo "<a href=\"?cpn_intro_watch_more=1\" class=\"cBlue\"> 查看更多...</a>";
					  }
			} ?>

                <div class="hackbox">asdf</div>
        </div>
        <div class="blank10"></div>
        <div class="title">
        	<h2 class="cBlue fB">产品展示<b class="cGrey fn">Products</b></h2><span class="more"><a href="product_list.php" class="cBlue"> 更多...</a></span>
        </div>
        <ul class="list_l">
			<?php if(isset($arryProducts) && count($arryProducts) > 0){
				foreach ($arryProducts as $key => $productObj) {
					?>
					<li>
						<span class="listimg">
							  <img src="images/tran.gif" class="blank"/><a href="product_info.php?id=<?php echo $productObj->id;?>"><img src="<?php echo "./admin/".substr($productObj->pic_path,2,strlen($productObj->pic_path) - 2) ?>" alt="<?php echo $productObj->name.'效果图'?>"/></a>
                        </span>
						<span class="listtxt"><a href="product_info.php?id=<?php echo $productObj->id;?>"><?php echo $productObj->name?></a></span>
					</li>
					<?php
				}
			} ?>
		</ul>
    </div>
    <div class="w370_r">
    	<div class="title">
        	<h2 class="cBlue fB">最新公告<b class="cGrey fn">News</b></h2>
        </div>
        <ul class="list_r">
        	<?php if(isset($arryNews) && count($arryNews) > 0){
				foreach ($arryNews as $key=>$newsObj) {
					?>
					<li>
						<a title="xinxi" href="article.php?type=1&id=<?php echo $newsObj->id;?>"><?php  echo mb_substr($newsObj->title,0,15).'...';?></a>
						<span class="time1"><?php echo date('Y-m-d H:i:s',$newsObj->pub_time);?></span>
					</li>
					<?php
				}
			} ?>
        </ul>
        <div class="blank29"></div>
        <div class="title">
        	<h2 class="cBlue fB">行业资讯<b class="cGrey fn">Information</b></h2><span class="more"><a href="info.php" class="cBlue"> 更多...</a></span>
        </div>
        <ul class="list_r">
	        <?php if(isset($arryInfromations) && count($arryInfromations) > 0){
				    foreach ($arryInfromations as $key => $infromationObj) {
					?>
					<li><a title="<?php echo mb_substr($infromationObj->title,0,15).'...'?>" href="article.php?type=2&id=<?php echo $infromationObj->id;?>"><?php echo mb_substr($infromationObj->title,0,15).'...'?></a>
						<span class="time1"><?php echo date('Y-m-d H:i:s',$infromationObj->pub_time);?></span></li>
					<?php
				}
			}?>
        	
        </ul>
    </div>
    <div class="hackbox"></div>
    
	<div class="title">
        	<h2 class="cBlue fB">友情链接<b class="cGrey fn">Links</b></h2>
    </div>
    <p class="links">
		    <?php if(isset($arryBlogrolls) && count($arryBlogrolls) > 0){
				$index = 0;
				foreach ($arryBlogrolls as $blogrollObj){
					if(++$index != count($arryBlogrolls)) {
						?>
						<a href="<?php echo $blogrollObj->content ?>" target="_blank"><?php echo $blogrollObj->name ?></a> |
						<?php
					}else{
						echo "<a href=\"$blogrollObj->content\" target='_blank'>$blogrollObj->name</a>";
					}
				}
			}?>
    </p>
</div>
<div class="footer">
	<p>地址：<?php echo $companyInfo->addr?>  联系人：<?php echo $companyInfo->contacts?>   移动电话：<?php echo $companyInfo->mobile?> 固定电话：<?php echo $companyInfo->fixed_tel?> 传 真：<?php echo $companyInfo->fax?></p>
	<p><?php echo $copyright->copyright_no;?> <?php echo $companyInfo->cpn_name;?> 版权所有</p>
	<p><a href="#"><?php echo $companyInfo->icp_no;?></a></p>
</div>
</body>
</html>