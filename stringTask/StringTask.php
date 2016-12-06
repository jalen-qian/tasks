<?php
/**
 * @author 钱文军
 * 字符串作业
 */
include 'SubString.php';
/*
 * 第一题：
 * 将1112223334445转换成5,444,333,222,111每3位用逗号隔开
 */
echo '<pre>第一题：<br/>';
//方式一：chunk_split()函数
$str = '1112223334445';
$str = chunk_split($str,3,',');
$str = substr($str, 0 ,strlen($str) - 1);
$str = strrev($str);
echo '方式一输出结果：'.$str.'<br/>';//方式一输出结果：5,444,333,222,111

//方式二：先拆分为数组
$str = '1112223334445';
$arry = str_split($str,3);
$str = implode(',',$arry);
$str = strrev($str);
echo '方式二输出结果：'.$str.'<br/>';//方式二输出结果：5,444,333,222,111

//方式三：遍历
$str = '1112223334445';
$result = '';
for($i = 0; $i < strlen($str); $i += 3){
	$result .= substr($str,$i, 3).',';
}
$result = substr($result, 0 ,strlen($result) - 1);
$result = strrev($result);
echo '方式三输出结果：'.$result.'<br/><br/>';//方式三输出结果：5,444,333,222,111


/*
 * 第二题：
 * 假设现在有一个字符串www.yaochufa.com 如何用php对它进行操作使字符串以 moc.afuhcoay. 输出
 */
echo '第二题：<br/>';
$str = 'www.yaochufa.com';
$str = strstr($str,'.');
$str = strrev($str);
echo $str.'<br/><br/>';


/*
 * 第三题：
 * 请写一个函数，实现以下功能 字符串“my_leader”转换成“MyLeader”、字符串“make_by_name”转换成“MakeByName”
 */
echo '第三题：<br/>';
function transfromStr(&$str){
	$tok = strtok($str,'_');
	$str = '';
	while($tok !== false){
		$tok[0] = strtoupper($tok);
		$str .= $tok;
		$tok = strtok('_');
	}
}
$str = '_my_leader_';
echo "原字符串：$str<br/>";
transfromStr($str);
echo '转换后：  '.$str.'<br><br>';


/*
 * 第四题：
 * $mail=liming@yaochufa.com;
 * 请将此邮箱的域（yaochufa.com）取出来，看最多能有几种方法
 */
echo '第四题：<br/>';
$mail= 'liming@yaochufa.com';

//方法一：
$pos = strpos($mail,'@');
echo '方法一：'.substr($mail, $pos, strlen($mail) - $pos).'<br>';

//方法二：
echo '方法二：'.strstr($mail,'@').'<br>';

//方法三：
$tok = strtok($mail,'@');
$tok = strtok('@');
$tok = '@'.$tok;
echo '方法三：'.$tok.'<br>';

//方法四：
$arry = explode('@',$mail);
$result = $arry[1];
$result = '@'.$result;
echo '方法四：'.$result.'<br>';
echo '<br/>';


/*
 * 第五题：
 * 翻转字符串中的单词，字符串仅包含大小写字母和空格，单词间使用空格分割。
 * 如输入“There is hainan”,输出“hainan is There”（不要使用php自带函数，主要是考核字符串和数组的灵活使用）
 */
echo '第五题：<br/>';
/**
 * 字符串或者长度
 */
function length($str){
	$count = 0;
	while(isset($str[$count]) && ++$count){}
	return $count;
}
/**
 * 自定义截取字符串函数
 */
function subString($str,$start,$end){
	$result = '';
	if($start > $end){
		return false;
	}
	for($i = $start; $i < $end; $i++){
		$result .= $str[$i];
	}
	return $result;
}

/**
 * 反转数组
 */
function inverseArry(&$arry){
	$len = length($arry);
	$mid = (int)($len / 2);
	for($i = 0; $i < $mid; $i++){
		$temp = $arry[$i];
		$arry[$i] = $arry[$len - $i - 1];
		$arry[$len - $i - 1] = $temp;
	}
}
/**
 * 不使用php自带函数实现第5题的需求
 * @param $str
 */
function reverStr(&$str){
	$arry = [];
	$index = 0;
	//将字符串转换为数组
	for($i = 0; $i < length($str); $i++){
		if($str[$i] === ' '){
			$arry[] = subString($str,$index,$i);
			$index = $i + 1;
		}else if($i == length($str) - 1){
			$arry[] = subString($str,$index,$i + 1);
		}
	}
	//反转数组
	inverseArry($arry);
	//重新拼接
	$str = '';
	foreach ($arry as $value) {
		$str .= $value.' ';
	}
	//删掉最后的空格
	$str = subString($str,0,strlen($str) - 1);
}
$str = 'There is hainan';
reverStr($str);
echo $str.'<br/><br/>';


/*
 * 第六题：
 * 封装一个截取字符串类，例如新闻标题过长只需截取20个汉字，多余的用...省略
 * 明确：在php中，一个汉字的长度是3 ，20个汉字则是60
 * 比如： $str = '要出发';
 *       echo strlen($str);//输出9
 */
echo '第六题：<br/>';
$str = 'PHP字符串函数在PHP网站开发中广泛使用，比如使用PHP字符串函数对字符串分割、截取、匹配、替换等处理。PHP字符串函数对于PHP入门学习者来说必不可少，本文将主要介绍PHP字符串分割函数处理心得，开启PHP字符串函数入门学习教程之旅。';
$result = SubString::mySubStr($str);
echo $result.'<br/><br/>';

echo '字符串函数练习：<br/>';
include "StringFunctions.php";