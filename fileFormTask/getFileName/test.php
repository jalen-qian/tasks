<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/06
 * Time: 11:32
 */
include "GetFileName.php";
$getName = new \fileFormTask\getFileTypeName\GetFileTypeName();
echo $getName->getTypeNameOne()."<br>";
echo $getName->getTypeNameTwo()."<br>";
echo $getName->getTypeNameThree()."<br>";