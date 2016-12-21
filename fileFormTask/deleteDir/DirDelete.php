<?php
/**
 * delete all files from a directory
 */
namespace fileFormTask\deleteDir;
class DeleteDir{
	/**
	 * 遍历并删除文件夹下面的所有文件
	 * @param $dir 要遍历并删除的文件夹
	 */
	public static function delete($dir){

		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					//echo $file."<br>";
					if ((is_dir($dir.'/'.$file)) && $file != '.' && $file != '..') {
						DeleteDir::delete($dir.'/'.$file.'/');
					} else {
						if ($file != '.' && $file != '..') {
							unlink($dir.'/'.$file);
							//DeleteDir::delete($dir.'/'.$file.'/');
						}
					}
				}
				closedir($dh);
				rmdir($dir.'/'.$file);
			}
		}
	}
}