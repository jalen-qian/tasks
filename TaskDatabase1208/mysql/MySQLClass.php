<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/22
 * Time: 13:25
 */
namespace Ycf\Task\MySql;
class MySqlClass
{
	//数据库的基本变量
	public $lastError; // 保存最后一个错误
	public $lastQuery; // 保存最后一个查询的记录
	public $result; // 保存数据库查询的结果
	public $records; // 保存返回的记录的总数
	public $affected; // 保存受影响的记录的总数
	public $rawResults; // 未经过排列的结果集
	public $arrayedResult; // 排列后返回的结果集
	private $hostname; // MySql主机名
	private $username; // MySQL用户名
	private $password; // MySQL用户密码
	private $database; // MySQL数据库名称
	private $databaseLink; // 数据库的连接
	public function __construct($database, $username, $password, $hostname = 'localhost', $port = 3306, $persistant = false)
	{
		//$persistant设置是否持久性连接
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->hostname = $hostname . ':' . $port; //根据获取到的两个参数进行组合成为完整主机名
		$this->Connect($persistant);
	}
	public function __destruct()
	{
		//__destruct()析构函数是在对象销毁时调用的代码。当这个对象用完之后，会自动执行这个函数中的语句。
		//把数据库关闭的代码放在这里。就是在对象被销毁的时候顺便把数据库连接关闭了
		$this->closeConnection();
	}
	private function Connect($persistant = false)
	{
		$this->closeConnection();
		if ($persistant) { //如果是设定为持久性链接，则调用mysql_pconnect()函数持久性链接
			$this->databaseLink = mysql_pconnect($this->hostname, $this->username, $this->password);
		} else {
			$this->databaseLink = mysql_connect($this->hostname, $this->username, $this->password);
		}
		if (!$this->databaseLink) {
			$this->lastError = "无法连接到服务器: " . mysql_error($this->databaseLink); //提示错误信息
			return false;
		}
		if (!$this->UseDB()) {
			$this->lastError = '无法连接到数据库: ' . mysql_error($this->databaseLink);
			return false;
		}
		$this->setCharset(); // 设置数据库的字符集为utf-8
		return true;
	}
	// 选择所要操作的数据库
	private function UseDB()
	{
		//mysql_select_db用来选择数据库
		if (!mysql_select_db($this->database, $this->databaseLink)) {
			$this->lastError = '没有这个数据库: ' . mysql_error($this->databaseLink);
			return false;
		} else {
			return true;
		}
	}
	// 数组与字符串都使用mysql_real_escape_string转义 SQL 语句中使用的字符串中的特殊字符，并考虑到连接的当前字符集
	private function SecureData($data, $types = array())
	{
		if (is_array($data)) {
			$i = 0;
			foreach ($data as $key => $val) {
				if (!is_array($data[$key])) {
					$data[$key] = $this->CleanData($data[$key], $types[$i]);
					$data[$key] = mysql_real_escape_string($data[$key], $this->databaseLink);
					$i++;
				}
			}
		} else {
			$data = $this->CleanData($data, $types);
			$data = mysql_real_escape_string($data, $this->databaseLink);
		}
		return $data;
	}
	//清除指定类型的数据
	private function CleanData($data, $type = '')
	{
		switch ($type) {
			case 'none':
				break;
			case 'str':
			case 'string':
				settype($data, 'string'); //设置变量的类型
				break;
			case 'int':
			case 'integer':
				settype($data, 'integer');
				break;
			case 'float':
				settype($data, 'float');
				break;
			case 'bool':
			case 'boolean':
				settype($data, 'boolean');
				break;
			// Y-m-d H:i:s
			// 2014-01-01 12:30:30
			case 'datetime':
				$data = trim($data);
				$data = preg_replace('/[^\d\-: ]/i', '', $data);
				preg_match('/^([\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2})$/', $data, $matches);
				$data = $matches[1];
				break;
			case 'ts2dt':
				settype($data, 'integer');
				$data = date('Y-m-d H:i:s', $data);
				break;
			// bonus types
			case 'hexcolor':
				preg_match('/(#[0-9abcdef]{6})/i', $data, $matches);
				$data = $matches[1];
				break;
			case 'email':
				$data = filter_var($data, FILTER_VALIDATE_EMAIL);
				break;
			default:
				break;
		}
		return $data;
	}
	// executeSQL方法用来执行SQL语句
	public function executeSQL($query)
	{
		$this->lastQuery = $query;
		if ($this->result = mysql_query($query, $this->databaseLink)) {
			if (gettype($this->result) === 'resource') {
				$this->records = @mysql_num_rows($this->result); //取得结果集中行的数目
			} else {
				$this->records = 0;
			}
			$this->affected = @mysql_affected_rows($this->databaseLink); //取得前一次 MySQL 操作所影响的记录行数
			if ($this->records > 0) {
				$this->arrayResults();
				return $this->arrayedResult;
			} else {
				return true;
			}
		} else {
			$this->lastError = mysql_error($this->databaseLink); //返回上一个 MySQL 操作产生的文本错误信息
			return false;
		}
	}
	public function commit() //提交mysql语句
	{
		return mysql_query("COMMIT", $this->databaseLink);
	}
	public function rollback() //实现回滚操作
	{
		return mysql_query("ROLLBACK", $this->databaseLink);
	}
	public function setCharset($charset = 'UTF8') //设置字符集
	{
		return mysql_set_charset($this->SecureData($charset, 'string'), $this->databaseLink);
	}
	// 实现数据库记录插入功能
	public function insert($table, $vars, $exclude = '', $datatypes = array())
	{
		if ($exclude == '') {
			$exclude = array();
		}
		array_push($exclude, 'MAX_FILE_SIZE'); // 自动排除不符合规定的字符
		$vars = $this->SecureData($vars, $datatypes);
		$query = "INSERT INTO `{$table}` SET ";
		foreach ($vars as $key => $value) {
			if (in_array($key, $exclude)) {
				continue;
			}
			$query .= "`{$key}` = '{$value}', ";
		}
		$query = trim($query, ', ');
		return $this->executeSQL($query);
	}
	// 删除数据库表中的记录
	public function delete($table, $where = '', $limit = '', $like = false, $wheretypes = array())
	{
		$query = "DELETE FROM `{$table}` WHERE ";
		if (is_array($where) && $where != '') {
			$where = $this->SecureData($where, $wheretypes);
			foreach ($where as $key => $value) {
				if ($like) {
					$query .= "`{$key}` LIKE '%{$value}%' AND ";
				} else {
					$query .= "`{$key}` = '{$value}' AND ";
				}
			}
			$query = substr($query, 0, -5);
		}
		if (is_string($where) && $where != "") {
			$query .= $where;
		}
		if ($limit != '') {
			$query .= ' LIMIT ' . $limit;
		}
		//echo $query;
		return $this->executeSQL($query);
	}
	// 数据库中的查询操作
	public function select($from, $where = '', $limit = '', $cols = '*', $orderBy = '', $like = false, $operand = 'AND', $wheretypes = array())
	{
		if (trim($from) == '') {
			return false;
		}
		$query = "SELECT {$cols} FROM `{$from}` WHERE ";
		if (is_array($where) && $where != '') {
			$where = $this->SecureData($where, $wheretypes);
			foreach ($where as $key => $value) {
				if ($like) {
					$query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
				} else {
					$query .= "`{$key}` = '{$value}' {$operand} ";
				}
			}
			$query = substr($query, 0, -(strlen($operand) + 2));
		} else {
			$query = substr($query, 0, -6);
		}
		if (is_string($where) && $where) {
			$query .= "where " . $where;
		}
		if ($orderBy != '') {
			$query .= ' ORDER BY ' . $orderBy;
		}
		if ($limit != '') {
			$query .= ' LIMIT ' . $limit;
		}
		$result = $this->executeSQL($query);
		if (is_array($result)) {
			return $result;
		}
		//echo $query;
		return array();
	}
	// 实现数据库的更新操作
	public function update($table, $set, $where, $exclude = '', $datatypes = array(), $wheretypes = array())
	{
		if (trim($table) == '' || !is_array($set) || !is_array($where)) {
			return false;
		}
		if ($exclude == '') {
			$exclude = array();
		}
		array_push($exclude, 'MAX_FILE_SIZE'); // 自动排除这一个
		$set   = $this->SecureData($set, $datatypes);
		$where = $this->SecureData($where, $wheretypes);
		$query = "UPDATE `{$table}` SET ";
		foreach ($set as $key => $value) {
			if (in_array($key, $exclude)) {
				continue;
			}
			$query .= "`{$key}` = '{$value}', ";
		}
		$query = substr($query, 0, -2);
		$query .= ' WHERE ';
		foreach ($where as $key => $value) {
			$query .= "`{$key}` = '{$value}' AND ";
		}
		$query = substr($query, 0, -5);
		return $this->executeSQL($query);
	}
	// 返回单一的数组结果集
	public function arrayResult()
	{
		//mysql_fetch_assoc从结果集中取得一行作为关联数组
		$this->arrayedResult = mysql_fetch_assoc($this->result) or die(mysql_error($this->databaseLink));
		return $this->arrayedResult;
	}
	// 返回数组的多个结果集
	public function arrayResults()
	{
		if ($this->records == 1) {
			return $this->arrayResult();
		}
		$this->arrayedResult = array();
		while ($data = mysql_fetch_assoc($this->result)) {
			$this->arrayedResult[] = $data;
		}
		return $this->arrayedResult;
	}
	//根据键值返回数组的多个结果集
	public function arrayResultsWithKey($key = 'id')
	{
		if (isset($this->arrayedResult)) {
			unset($this->arrayedResult);
		}
		$this->arrayedResult = array();
		while ($row = mysql_fetch_assoc($this->result)) {
			foreach ($row as $theKey => $theValue) {
				$this->arrayedResult[$row[$key]][$theKey] = $theValue;
			}
		}
		return $this->arrayedResult;
	}
	// 返回最后插入的ID
	public function lastInsertID()
	{
		return mysql_insert_id($this->databaseLink);
	}
	// 返回行数
	public function countRows($from, $where = '')
	{
		$result = $this->select($from, $where, '', '', false, 'AND', 'count(*)');
		return $result["count(*)"];
	}
	// 挂壁数据库连接
	public function closeConnection()
	{
		if ($this->databaseLink) {
			$this->commit();
			mysql_close($this->databaseLink);
		}
	}
}