<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/6
 * Time: 15:26
 * 练习php函数
 */

/*
 * 1. addslashes()  使用反斜线引用字符串
 */
$str = "my name is J'arry";
echo '1. '.addslashes($str).'<br/><br/>';

/*
 * 2. chunk_split 将字符串分割成小块
 */
$str = 'yaochufazhoubianyou';
$str = chunk_split($str,4,' ');
echo '2. '.$str.'<br/><br/>';

/*
 * 3. explode 将一个字符串转换为数组
 */
$str = 'php is very strong';
$arry = explode(' ',$str);
echo '3. ';
var_dump($arry);

/*
 * 4. htmlentities()       将字符串中的某些在html需要转义的字符转义 比如'<' 转义为 '&lt;'
 *    html_entity_decode() 将字符串中的html特殊字符反转为正常字符
 */
echo '<br/>4. <br/>';
$str = 'this is "jalen" <b>dog</b>';
$str = htmlentities($str);
echo '转义后：'.$str.'<br/><br/>';
$str = html_entity_decode($str);
echo '反转义：'.$str.'<br/><br/>';

/*
echo ''..'<br/><br/>';

*/