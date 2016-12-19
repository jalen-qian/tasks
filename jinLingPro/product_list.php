<?php
include "./dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//公司信息
$result = $myPdo -> select(['company_info'],['*'],[]);
$companyInfo = $result[0];
//版权信息
$copyright = $myPdo->select(['copyright'],['*'],['where'=>["cpn_id = {$companyInfo->id}"]])[0];
//产品信息
$where = [];
if(isset($_GET['type'])){
	$where = ['where'=>["type_id = {$_GET['type']}"]];
}
$arryProducts = $myPdo -> select(['products'],['*'],$where);
//所有的产品类别
$arryProTypes = $myPdo -> select(['prdu_type'],["*"],[]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金陵贸易有限公司</title>
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
     	<li ><a href="index.php">首  页</a></li>
        <li><a href="about_us.php">公司简介</a></li>
        <li class="sel"><a href="product_list.php">产品展示</a></li>
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
	<div class="lefter">
    	<div class="title">
        	<h2 class="cBlue fB">产品展示<b class="cGrey fn">Products</b></h2>
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
        <div class="blank10"></div>
        <div class="pages"><a href="#" class="pre">上一页</a><a class="current">1</a><a href="#?page=2">2</a><a href="#?page=3">3</a><a href="#?page=2" class="next">下一页</a></div>
        <div class="blank6"></div>
    </div>
	<div class="righter">
    	<div class="rightBox">
        	<h3>产品分类</h3>
            <ul class="list_r">

				<?php
				    if(isset($arryProTypes) && count($arryProTypes) > 0){
						foreach ($arryProTypes as $proType) {
							?>
							<li><a href="product_list.php?type=<?php echo $proType -> id;?>"><?php echo $proType->name; ?></a></li>
							<?php
						}
					}
				?>
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
