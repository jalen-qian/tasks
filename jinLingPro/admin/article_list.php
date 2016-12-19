<?php
include "../dao/MyPDO.class.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
//查询出所有的文章
$articles = $myPdo->select(['articles'],['id','title','pub_uid','pub_time'],['order'=>'id']);
if(isset($_POST['submit'])){
    //统计要删除的文章id
    $where = '';
    foreach ($articles as $article) {
        if(isset($_POST[(string)$article->id])){
            $where .= "id = " . $article->id .' or ';
        }
    }
    $where = substr($where, 0, -4);
    if($where != ''){
        $myPdo ->delete(['articles'],[$where]);
        echo "<script> alert('操作成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }else{
        echo "<script> alert('请选择要删除的文章');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>最新文章</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div class="container">
    <h3 class="marginbot">最新文章<a href="article_edit.php" class="sgbtn">添加新文章</a></h3>
    <div class="mainbox">
        <form action="article_list.php" target="main" method="post">
            <table class="datalist fixwidth">
                <tbody>
                    <tr>
                        <th nowrap="nowrap"><input name="chkall" id="chkall" class="checkbox" type="checkbox"><label for="chkall">删除</label></th>
                        <th nowrap="nowrap">文章名称</th>
                        <th nowrap="nowrap">添加人</th>
                        <th nowrap="nowrap">添加时间</th>
                        <th nowrap="nowrap">详情</th>
                    </tr>
                    <?php
                        if(isset($articles) && count($articles) > 0){
                            foreach ($articles as $article){
                                echo "<tr>";
                                echo "<td width=\"80\"><input name=\"{$article->id}\" value=\"".$article->id."\" class=\"checkbox\" type=\"checkbox\"></td>";
                                echo "<td><strong>{$article->title}</strong></td>";
                                echo "<td width=\"100\">".$myPdo->select(['user'],['name'],['where'=>["id = $article->pub_uid"]])[0]->name."</td>";
                                echo "<td width=\"150\">".date("Y-m-d H:i",$article->pub_time)."</td>";
                                echo "<td width=\"100\"><a href=\"article_edit.php"."?article_id=".$article->id."\">编辑</a></td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                    <tr class="nobg">
                    	<td><input value="提 交" name="submit" class="btn" type="submit"></td>
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