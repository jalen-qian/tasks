<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/06
 * Time: 11:39
 * 遍历一个文件夹中的所有的文件
 */
namespace fileFormTask\traverseDir;
class TraverseDir
{
	/**
	 * 遍历一个文件夹
	 * @param $dir 要遍历的文件夹路径
	 * @return array 包含这个文件夹内所有的文件或文件夹的数组
	 */
	public function traverse($dir)
	{
		$result = [];
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if($file != '.' && $file != '..'){
						if (is_dir($dir . '/' . $file)) {
							$result[] = $this->traverse($dir."/".$file);
						} else{
							$result[] = $file;
						}
					}
				}
				closedir($dh);
			}
		}
		return $result;
	}
}