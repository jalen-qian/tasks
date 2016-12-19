<?php
include "../dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
$products = $myPdo -> select(['products'],['*'],[]);
if(isset($_POST['submit'])){
    //统计要删除的产品id
    $where = '';
    foreach ($products as $product) {
        if(isset($_POST[(string)$product->id])){
            $where .= "id = " . $product->id .' or ';
        }
    }
    $where = substr($where, 0, -4);
    if($where != ''){
        $myPdo ->delete(['products'],[$where]);
        echo "<script> alert('操作成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }else{
        echo "<script> alert('请选择要删除的产品');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>最新产品</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div class="container">
    <h3 class="marginbot">最新产品<a href="product_edit.php" class="sgbtn">添加新产品</a></h3>
    <div class="mainbox">
        <form action="#" method="post" target="main">
            <table class="datalist fixwidth">
                <tbody>
                    <tr>
                        <th nowrap="nowrap"><input name="chkall" id="chkall" class="checkbox" type="checkbox"><label for="chkall">删除</label></th>
                        <th nowrap="nowrap">产品名称</th>
						<th nowrap="nowrap">产品团片</th>
                        <th nowrap="nowrap">添加人</th>
                        <th nowrap="nowrap">添加时间</th>
                        <th nowrap="nowrap">详情</th>
                    </tr>
                    <?php
                         foreach ($products as $key => $objProduct) {
                             ?>
                             <tr>
                             <td width="80"><input name="<?php echo $objProduct->id ?>" value="" class="checkbox" type="checkbox"></td>
                             <td width="200"><strong><?php echo $objProduct->name ?></strong></td>
                             <td width="100"><img src=<?php echo $objProduct->pic_path ?>></td>
                             <td width="100"><?php echo $myPdo->select(["user"],["name"],['where'=>['id = '.$objProduct->user_id]])[0]->name?></td>
                             <td width="150"><?php echo date('Y-m-d H:i',$objProduct->add_time); ?></td>
                             <td width="100"><a href="product_edit.php?product_id=<?php echo $objProduct->id?>" target="main">编辑</a></td>
                             </tr>
                             <?php
                         }
                    ?>
                    <tr class="nobg">
                    	<td ><input value="提 交" class="btn" name = 'submit' type="submit"></td>
                        <td class="tdpage" colspan="4">
                            <div class="pages">
                            <em>100</em>
                            <strong>1</strong>
                            <a href="">2</a>
                            <a href="">3</a>
                            <a href="">4</a>
                            <a href="" class="next">&rsaquo;&rsaquo;</a>
                            <a href="" class="last">... </a>
                            <kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}" /></kbd>
                            </div>
                      	</td>
                    </tr>                
                </tbody>
        	</table>
        <div class="margintop"></div>
        </form>
    </div>
</div>
</body>
</html>