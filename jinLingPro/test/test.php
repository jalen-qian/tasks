<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/15
 * Time: 9:59
 */
namespace jinling\dao;
include "../common/common.php";
include "../dao/MyPDO.class.php";

$myPdo = MyPDO::getInstance();
//var_dump($myPdo);
$result = $myPdo ->add(['user'],['name'=>'jalen','password'=>md5('123456')]);
var_dump($result);