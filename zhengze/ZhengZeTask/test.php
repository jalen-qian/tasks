<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/19
 * Time: 11:45
 */
include "RegularExpre.php";
$regularExp = new \regular\expre\RegularExpre();
$result = $regularExp->findMatchEles();
echo "<pre>第一题：<br>";
print_r($result);
echo "</pre><br>";

echo "<pre>第二题：<br>";
$arry = $regularExp->getMsgsFromUrl("http://www.yaochufa.com/index.php");
echo "协议：".$arry[2]."<br>";
echo "主机：".$arry[1]."<br>";
echo "域名：".$arry[3]."<br>";
echo "文件名：".$arry[7]."<br>";
echo "</pre><br>";

echo "<pre>第三题：<br>";
$arry = $regularExp->getAllUrls();
print_r($arry[0]);
echo "</pre><br>";

echo "第四题：<br>";
$str = "这个文本中有<b>粗体</b>和<u>带有下划线</u>以及<i>斜体</i>还有<font color='red' size='7'>带有颜色和字体大小</font>的标记";
echo "去除标签之前:".$str."<br>";
$str = $regularExp -> removeHtmlTags($str);
echo "去除标签之后:".$str."<br>";
