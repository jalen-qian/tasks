<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/19
 * Time: 11:45
 */
include "regularExpre.php";
$regularExp = new \regular\expre\RegularExpre();
$result = $regularExp->findMatchEles();
echo "<pre>第一题：<br>";
print_r($result);
echo "<br>";

echo "<pre>第二题：<br>";


echo "</pre>";