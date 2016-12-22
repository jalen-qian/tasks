<?php
/**
 * Created by PhpStorm.
 * User: jalen
 */
namespace Ycf\Task\MySqlClass;
class MysqliClass
{
	private $link = null;
	public function connect($host, $user, $pass, $dbname)
	{
		$link = mysqli_connect($host, $user, $pass, $dbname);
		if ($link == false) {
			echo 'false';
		}
		//通用变量
		$this->link = $link;
	}
	/**
	 * 插入记录的操作
	 * @param array $array
	 * @param string $table
	 * @return boolean
	 */
	public function insert($array, $table)
	{
		$keys   = join(',', array_keys($array));
		$values = "'" . join("','", array_values($array)) . "'";
		$sql    = "insert {$table}({$keys}) VALUES ({$values})";
		$query  = "insert into test (name) VALUES ('ti')";
		$result = mysqli_query($this->link, $sql) or die('fail');
		$mysqli = $this->link;
		return $mysqli->affected_rows;
	}
	/**
	 * MYSQL更新操作
	 * @param array $array
	 * @param string $table
	 * @param string $where
	 * @return number|boolean
	 */
	public function update($array, $table, $where = null)
	{
		$sets = "";
		foreach ($array as $key => $val) {
			$sets .= $key . "='" . $val . "',";
		}
		$sets   = rtrim($sets, ','); //去掉SQL里的最后一个逗号
		$where  = $where == null ? '' : ' WHERE ' . $where;
		$sql    = "UPDATE {$table} SET {$sets} {$where}";
		$res    = mysqli_query($this->link, $sql);
		$mysqli = $this->link; //得到链接
		return $mysqli->affected_rows;
	}
	/**
	 * 删除记录的操作
	 * @param string $table
	 * @param string $where
	 * @return number|boolean
	 */
	public function delete($table, $where = null)
	{
		$where  = $where == null ? '' : ' WHERE ' . $where;
		$sql    = "DELETE FROM {$table}{$where}";
		$res    = mysqli_query($this->link, $sql);
		$mysqli = $this->link;
		return $mysqli->affected_rows;
	}
	/**
	 * 查询一条记录
	 * @param string $sql
	 * @param string $result_type
	 * @return boolean
	 */
	public function fetchOne($sql)
	{
		$result = mysqli_query($this->link, $sql);
		return mysqli_fetch_array($result);
	}
	/**
	 * 得到表中的所有记录
	 * @param string $sql
	 * @param string $result_type
	 * @return boolean
	 */
	public function fetchAll($sql, $result_type = MYSQL_ASSOC)
	{
		$result = mysqli_query($this->link, $sql);
		if ($result && mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result, $result_type)) {
				$rows[] = $row;
			}
			return $rows;
		} else {
			return false;
		}
	}
	/**取得结果集中的记录的条数
	 * @param string $sql
	 * @return number|boolean
	 */
	public function getTotalRows($sql)
	{
		$result = mysqli_query($this->link, $sql);
		if ($result) {
			return mysqli_num_rows($result);
		} else {
			return false;
		}
	}
	/**释放结果集
	 * @param resource $result
	 * @return boolean
	 */
	public function freeResult($result)
	{
		return mysqli_free_result($this->link, $result);
	}
	/**断开MYSQL
	 * @param resource $link
	 * @return boolean
	 */
	public function close()
	{
		return mysqli_close($this->link);
	}
}