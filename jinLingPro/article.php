<?php
include "./dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//公司信息
$result = $myPdo -> select(['company_info'],['*'],[]);
$companyInfo = $result[0];
if(!isset($_GET['type'])){
	$_GET['type'] = 1;
}
//版权信息
$copyright = $myPdo->select(['copyright'],['*'],['where'=>["cpn_id = {$companyInfo->id}"]])[0];
//查询所有的文章
$arryArticles = $myPdo -> select(['articles'],['id','title','pub_time','article_type'],['where'=>["article_type = {$_GET['type']}"]]);
//查询当前页面要显示的文章
if(isset($_GET['id']) && $_GET['id'] > 0){
	$currentArticle = $myPdo -> select(['articles'],['*'],['where'=>["id = {$_GET['id']}"]])[0];
}else{
	$currentArticle = $myPdo -> select(['articles'],['*'],['where'=>["article_type = {$_GET['type']}"],"limit"=>'1'])[0];
}
//var_dump($currentArticle);
//本页面要显示的友情链接
$arryBlogrolls = $myPdo -> select(['blogrolls'],['*'],['where'=>['page_id = 1']]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $companyInfo->cpn_name;?></title>
<link type="text/css" rel="stylesheet" href="style/style.css" />
</head>

<body>
<div class="header">
	<h1 class="logo" title="<?php echo $companyInfo->cpn_name;?>"><a href="index.php"><img src="images/logo.gif" alt="<?php echo $companyInfo->cpn_name;?>" /></a></h1>
    <p class="top_r"><a href="#" class="btn_i">设为主页</a><a href="#" class="btn_f">收藏本站</a></p>
</div>
<div class="nav">
	<div class="nav_left"></div>
    <ul>
     	<li><a href="index.php">首  页</a></li>
        <li><a href="about_us.php">公司简介</a></li>
        <li><a href="product_list.php">产品展示</a></li>
        <li class="sel"><a href="info.php">行业资讯</a></li>
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
	<div class="lefter">
    	<div class="title">
        	<h2 class="cBlue fB">详细信息<b class="cGrey fn"><?php if($_GET['type'] == 1){echo "News";}else{echo "Information";}?></b></h2>
        </div>
        <div class="article">
			<h3><?php if(isset($currentArticle)) echo $currentArticle->title;?></h3>
			<h4>发布时间：<?php  if(isset($currentArticle)) echo date('Y-m-d H:i:s',$currentArticle->pub_time);?></h4>
        	<?php if(isset($currentArticle)) echo $currentArticle -> content;?>
        </div>
    </div>
	<div class="righter">
    	<div class="rightBox">
        	<a href="guestbook.php" class="btn_s">我要留言</a>
        </div>
        <div class="blank10"></div>
    	<div class="rightBox">
			<?php if($_GET['type'] == 1){
				echo "<h3>最新公告<b class=\"cGrey fn\">News</b></h3>";
			}else{
				echo "<h3>行业资讯<b class=\"cGrey fn\">Informations</b></h3>";
			}
			?>

            <ul class="list_r">

				<?php if(isset($arryArticles) && count($arryArticles) > 0){
					foreach ($arryArticles as $key=>$article) {
						?>
						<li>
							<a href="article.php?type=1&id=<?php echo $article->id;?>"><?php  echo mb_substr($article->title,0,13).'...';?></a>
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
