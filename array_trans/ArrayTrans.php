<?php
/**
* 数组转换练习实现类
*/
class ArrayTransform{
	/**
	* 数组转换第一题
	* 使用递归
	*/
	public function transformOne($data){
		if(!is_array($data)){
			return false;
		}
		$keys = [];
		$values = [];
		foreach($data as $key => $value){
			//将key转换为驼峰命名法，并保存
			$this -> toHump($key);
			$keys[] = $key;
			if(is_array($value)){
				$values[] = $this -> transformOne($value);//递归
			}else{
				$values[] = $value;
			}
		}
		return array_combine($keys,$values);
	}
	/**
	* 将下划线命名的字符串转换为驼峰命名法命名的字符串
	*/
	public function toHump(&$str){
		if(!is_string($str)){
			return false;
		}
		
		$tok = strtok($str,'_');
		$str = '';
		while($tok !== false){
			$tok = ucwords($tok);
			$str .= $tok;
			$tok = strtok('_');
		}
		$str[0] = strtolower($str[0]);
	}
	
	/**
	* 数组转换第二题
	*/
	public function transformTwo($data){
		if(!is_array($data)){
			return false;
		}
		$result = [];
		$ids = [];
		$index = 0;
		foreach($data as $key => $value){
			if(!in_array($value['id'],$ids)){
				$ids[] = $value['id'];
				$index = 0;
			}
			$result[array_search($value['id'],$ids)]['id'] = $value['id'];
			$result[array_search($value['id'],$ids)]['hotelName'] = $value['hotelName'];
			$result[array_search($value['id'],$ids)]['dateList'][$index]['date'] = $value['date'];
			$result[array_search($value['id'],$ids)]['dateList'][$index++]['isOpen'] = $value['isOpen'];
		}
		return $result;
	}
	
	/**
	* 数组转换第三题，和第二题是逆过程
	*/
	public function transformThree($data){
		if(!is_array($data)){return false;}
		$result = [];
		$index = 0;
		foreach($data[0]['dateList'] as $value){
			$result[$index]['id'] = $data[0]['id'];
			$result[$index]['hotelName'] = $data[0]['hotelName'];
			$result[$index]['date'] = $value['date'];
			$result[$index++]['isOpen'] = $value['isOpen'];
		}
		return $result;
	}
	
	/**
	* 数组转换第四题
	*/
	public function transformFour($data){
		if(!is_array($data)){return false;}
		$result = [];
		$index = 0;
		foreach ($data as $value){
			$arry1 = [];
			$arry1['id'] = $value['id'];
			$arry1['hotelName'] = $value['hotelName'];
			$arry2 = [];
			$arry2['styleInfo'] = "(styleId=>".$value['styleId'].")".$value['styleName'];
			$arry2['itemInfo'] = "(itemId=>".$value['itemId'].")".$value['itemName'];
			$arry2['providerInfo'] = "(providerId=>".$value['providerId'].")".$value['providerName'];
			$result[$index++] = array_merge($arry1,$arry2);
		}
		return $result;
	}
}
