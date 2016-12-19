<?php
include "../dao/MyPDO.class.php";
include "../session/session.php";
$myPdo = \jinling\dao\MyPDO::getInstance();
$mSession = new jinling\session\Session();
$isProductUpdate = false;
if(isset($_POST['product_name'])){
    include "../fileupload/FileUpload.class.php";
    $fileUpload = new jinling\fileupload\FileUpload($_FILES['file']['name'],'./upload/');
    $result = $fileUpload->upload();
    if($result){
        $filePath = './upload/'.$result;
//        var_dump($_SESSION['userId']);die;
        if($_POST['from_type'] == 'new_product'){
            $rowCount = $myPdo->add(['products'],['type_id'=>$_POST['product_type'],'user_id'=>$mSession->get('userId'),'name'=>$_POST['product_name'],'desn'=>$_POST['product_desc'],'pic_path'=>$filePath,'add_time'=>time()]);
        }else{
            $rowCount = $myPdo->update(['products'],["id = {$_POST['product_id']}"],['type_id'=>$_POST['product_type'],'user_id'=>$mSession->get('userId'),'name'=>$_POST['product_name'],'desn'=>$_POST['product_desc'],'pic_path'=>$filePath,'add_time'=>time()]);
        }

        if($rowCount > 0){
            echo "<script> alert('操作成功');location.href='product_list.php'; location.target='main';</script>";
        }else{
            echo "<script> alert('操作失败');location.href='product_list.php'; location.target='main';</script>";
        }
    }else{
        echo "<script> alert('文件上传失败,请重试!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }
}else if(isset($_GET['product_id']) && $_GET['product_id'] != 0){
    $isProductUpdate = true;
    $resultArry = $myPdo ->select(['products'],['*'],['where'=>["id = '{$_GET['product_id']}'"]]);
    $productObj = $resultArry[0];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if($isProductUpdate && $productObj->id != 0){echo '修改产品信息';}
    else{echo '添加新产品';}?></title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="all">
    <style type="text/css">
        div p{
            text-align: left;
            border: 1px solid red;
            background-color: #FFEBEB;
        }
    </style>
    <script type="text/javascript" language="JavaScript">
        function showPrductNameErr(){
            var ui = document.getElementById("err_product_name");
            ui.style.display = 'inline';
        }
        function showProductDescErr() {
            var ui = document.getElementById("err_product_desc");
            ui.style.display = 'inline';
        }
        function showProductFileErr() {
            var ui = document.getElementById("err_product_file");
            ui.style.display = 'inline';
        }
        function dismissProductNameErr() {
            var ui = document.getElementById("err_product_name");
            ui.style.display = 'none';
        }
        function dismissProductDescErr() {
            var ui = document.getElementById("err_product_desc");
            ui.style.display = 'none';
        }
        function dismissProductFileErr() {
            var ui = document.getElementById("err_product_file");
            ui.style.display = 'none';
        }
        function check(fm) {
            var els = fm.elements;
            for(var i = 0; i < els.length;i++){

                if(els[i].type != 'text' && els[i].type != 'textarea' && els[i].type != 'file')
                    continue;

                if(els[i].type == 'file' && els[i].value == ''){
                    showProductFileErr();
                    els[i].focus();
                    return false;
                }else if(els[i].value == ''){
                    if(els[i].getAttribute("name") == "product_name"){
                        showPrductNameErr();
                    }else if(els[i].getAttribute("name") == "product_desc"){
                        showProductDescErr();
                    }
                    els[i].focus();
                    return false;
                }else{
                    dismissProductDescErr();
                    dismissProductNameErr();
                    dismissProductFileErr();
                }
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h3 class="marginbot"><?php if($isProductUpdate && $productObj->id != 0){echo '修改产品信息';}
        else{echo '添加新产品';}?><a href="product_list.php" class="sgbtn">返回产品列表</a></h3>
    <div class="mainbox">
            <form action="#" method="post" enctype="multipart/form-data" target="main" onsubmit="return check(this)">
                <input type="hidden" name = 'from_type' value="<?php if($isProductUpdate && $productObj->id != 0){echo 'update_product';}
                else{echo 'new_product';}?>"/>
                <input type="hidden" name = "product_id" value="<?php if($isProductUpdate && $productObj->id != 0){ echo $productObj->id; } ?>"/>
            <table class="opt" style="width:600px;">
                <tbody>
                    <tr>
                        <th>产品名称：</th>
                    </tr>
                    <tr>
                        <td>
                        <input name="product_name" class="txt" value="<?php if($isProductUpdate && $productObj->id != 0){echo $productObj->name;} ?>" style="width:400px;" type="text">
                        </td>
                        <td><p class="err" style="display:none" id="err_product_name">产品名称不能为空！</p></td>
                    </tr>
                    <tr>
                        <th>产品类别：
                            <select name="product_type">
                                <?php $result = $myPdo->select(['prdu_type'],['*'],[]);
                                      if(isset($result) && count($result) > 0){
                                          foreach ($result as $key => $value){
                                ?>
                                <option <?php if($isProductUpdate && $productObj->id != 0 && $productObj->type_id == $value->id ){echo "selected = 'selected'";} ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>

                                <?php   }
                                          }  ?>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>产品描述：</th>
                    </tr>
                    <tr>
                        <td><textarea style="width:400px; height:150px"  name="product_desc"><?php if($isProductUpdate && $productObj->id != 0){echo $productObj->desn;} ?></textarea>
                            </td>
                        <td><p class="err"  id = "err_product_desc" style="display: none">产品描述不能为空</p></td>
                    </tr>
                    <tr>
                        <th colspan="2">上传图片：<input type="file" name="file"></th>
                        <td><p class="err" id="err_product_file" style="display: none">请上传图片</p></td>
                    </tr>
                </tbody>
            </table>
            <div class="opt"><input name="submit" value=" 提 交 " class="btn" tabindex="3" type="submit"></div>

            </form>

    </div>
</div>
</body>
</html>