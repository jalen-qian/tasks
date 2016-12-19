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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $companyInfo->cpn_name ?></title>
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
     	<li><a href="index.php">首  页</a></li>
        <li><a href="about_us.php">公司简介</a></li>
        <li><a href="product_list.php">产品展示</a></li>
        <li><a href="info.php">行业资讯</a></li>
        <li><a href="guestbook.php">客户留言</a></li>
        <li class="sel"><a href="contact_us.php" class="nobg">联系我们</a></li>
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
        	<h2 class="cBlue fB">联系我们<b class="cGrey fn">Contact us</b></h2>
        </div>
        <div class="intro" style="height:167px">
        	地址：<?php echo $companyInfo->addr;?><br/>
            联系人：<?php echo $companyInfo->contacts;?><br/>
            移动电话：<?php echo $companyInfo->mobile;?><br/>
            固定电话：<?php echo $companyInfo->fixed_tel;?><br/>
            传真：<?php echo $companyInfo->fax;?>
        </div>
        <div class="title">
        	<h2 class="cBlue fB">我的位置<b class="cGrey fn">Map</b></h2>
        </div>
        <div class="intro">
        	<iframe width="360" height="266" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://ditu.google.cn/maps?f=q&amp;source=s_q&amp;hl=zh-CN&amp;geocode=&amp;q=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82%E6%B5%B7%E7%8F%A0%E5%8C%BA&amp;aq=&amp;brcurrent=3,0x3402ffaca010ae9b:0x826837df2eae7a0e,1,0x340301fe46c655a3:0xc549ef142225757a%3B5,0,0&amp;brv=25.1-b20b3018_4134eab6_98868b16_719d4a7b_295494d9&amp;sll=23.129163,113.264435&amp;sspn=0.89159,1.150818&amp;g=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82%E6%B5%B7%E7%8F%A0%E5%8C%BA&amp;t=m&amp;ll=23.086838,113.320971&amp;spn=0.021002,0.030813&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://ditu.google.cn/maps?f=q&amp;source=embed&amp;hl=zh-CN&amp;geocode=&amp;q=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82%E6%B5%B7%E7%8F%A0%E5%8C%BA&amp;aq=&amp;brcurrent=3,0x3402ffaca010ae9b:0x826837df2eae7a0e,1,0x340301fe46c655a3:0xc549ef142225757a%3B5,0,0&amp;brv=25.1-b20b3018_4134eab6_98868b16_719d4a7b_295494d9&amp;sll=23.129163,113.264435&amp;sspn=0.89159,1.150818&amp;g=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%B9%BF%E4%B8%9C%E7%9C%81%E5%B9%BF%E5%B7%9E%E5%B8%82%E6%B5%B7%E7%8F%A0%E5%8C%BA&amp;t=m&amp;ll=23.086838,113.320971&amp;spn=0.021002,0.030813&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">查看大图</a></small>
        </div>
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
