<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/06
 * Time: 11:44
 * 测试
 */
include "TraverseDir.php";
$traverse = new fileFormTask\traverseDir\TraverseDir();
$arryResult = $traverse->traverse("./test");
echo "<pre>";
print_r($arryResult);
echo "</pre>";