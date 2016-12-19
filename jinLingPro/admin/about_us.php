<?php
include "../session/session.php";
include "../dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
$mySession = new jinling\session\Session();
$result = $myPdo -> select(['company_info'],['*'],[]);
$companyInfo = $result[0];
//var_dump($companyInfo);
if(isset($_POST['sub'])){
	$time = time();
	$rowCount = $myPdo ->update(['company_info'],['id = 1'],["cpn_intro" => $_POST['content'],"user_id" => $_SESSION['userId'],"add_time" => $time]);
	if(isset($rowCount) && $rowCount > 0){
		echo "<script> alert('操作成功');location.href='about_us.php'; location.target='main';</script>";
	}else{
		echo "<script> alert('操作失败，请重试');location.href='about_us.php'; location.target='main';</script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公司简介</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
</head>
<body>
<div id="append"></div>
<div class="container">
	<h3>公司简介</h3>
    <div class="mainbox">
        <form action="#" target="main" method="post">
            <table style="width:700px;">
                <tbody>
                	<tr>
                    	<td><textarea rows="10" cols="80" name="content"><?php if(isset($companyInfo) && $companyInfo->id != 0){echo $companyInfo->cpn_intro;} ?></textarea></td>
                    </tr>
                    <tr>
                    	<td>添加人：<?php if(isset($companyInfo) && $companyInfo->id != 0){
								echo $myPdo -> select(['user'],['name'],['where'=>["id = {$companyInfo->user_id}"]])[0]->name;
							} ?> &nbsp;&nbsp;&nbsp;添加时间：<?php if(isset($companyInfo) && $companyInfo->id != 0){echo date('Y-m-d H:i',$myPdo -> select(['company_info'],['add_time'],[])[0]->add_time);} ?></td>
                    </tr>
                    <tr>
                        <td><input value="提 交" name = 'sub' class="btn" type="submit"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
</body>
</html>

