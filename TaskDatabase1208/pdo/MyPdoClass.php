<?php
/**
 * Created by PhpStorm.
 * User: jalen
 * Date: 2016/12/15
 * Time: 9:34
 */
namespace Ycf\Task\Pdo;
class MyPDO{
	//pdo对象
	private $pdo = null;
	private $host = '172.16.50.25';
	private $dbname = 'jinLingdb';
	private $user = 'root';
	private $password = 'root';

	private static $mInstance = null;
	//单例模式
	public static function getInstance(){
		if(!self::$mInstance instanceof self){
			self::$mInstance = new self();
		}
		return self::$mInstance;
	}

	/**
	 * MyPDO constructor.私有化构造器
	 */
	private function __construct(){
		try{
			$this->pdo = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password,[\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.'utf8']);
		}catch (\PDOException $e){
			exit($e->getMessage());
		}
	}

	/**
	 * 插入一条数据
	 * @param $tables  ['user']
	 * @param array $addData eg:['id'=>'1','name'=>'jack','password'=>'123456']
	 * @return mixed
	 */
	public function add($tables, Array $addData) {
		$addFields = array();
		$addValues = array();
		foreach ($addData as $key=>$value) {
			$addFields[] = $key;
			$addValues[] = $value;
		}
		$addFields = implode(',', $addFields);
		$addValues = implode("','", $addValues);
		$sql = "INSERT INTO $tables[0] ($addFields) VALUES ('$addValues')";
		//echo $sql;
		return $this->execute($sql)->rowCount();
	}

	/**
	 * 修改
	 * @param $tables 要更新的表 
	 * @param array $param 条件参数 ['id = 1','name = rose'] -> where id = 1 and name = rose
	 * @param array $updateData 设置的数据 ['id'=>'2','name'=>'jalen']
	 * @return mixed
	 */
	public function update(Array $tables, Array $param, Array $updateData) {
		$where = $setData = '';
		foreach ($param as $key=>$value) {
			$where .= $value.' AND ';
		}
		$where = 'WHERE '.substr($where, 0, -4);
		foreach ($updateData as $key=>$value) {
			if (is_array($value)) {
				$setData .= "$key=$value[0],";
			} else {
				$setData .= "$key='$value',";
			}
		}
		$setData = substr($setData, 0, -1);
		$sql = "UPDATE $tables[0] SET $setData $where";
//		echo $sql;
		return $this->execute($sql)->rowCount();
	}

	/**
	 * 验证一条数据
	 * @param $tables
	 * @param array $param
	 * @return mixed
	 */
	public function isOne($tables, Array $param = []) {
		$where = '';
		if(!$this->isNullArray($param)){
			foreach ($param as $key=>$value) {
				$where .=$value.' AND ';
			}
			$where = 'WHERE '.substr($where, 0, -4);
		}
		$sql = "SELECT id FROM $tables[0] $where LIMIT 1";
		return $this->execute($sql)->rowCount();
	}

	/**
	 * 删除
	 * @param $tables
	 * @param array $param
	 * @return mixed
	 */
	public function delete($tables, Array $param) {
		$where = '';
		foreach ($param as $key=>$value) {
			$where .= $value.' AND ';
		}
		$where = 'WHERE '.substr($where, 0, -4);
		$sql = "DELETE FROM $tables[0] $where LIMIT 1";
		echo $sql;
		return $this->execute($sql)->rowCount();
	}

	/**
	 * 查询
	 * @param $tables
	 * @param array $fileld
	 * @param array $param
	 * @return mixed
	 */
	public function select($tables, Array $fileld, Array $param = array()) {
		$limit = $order = $where = $like = '';
		if (is_array($param) && ! $this -> isNullArray($param)) {
			$limit = isset($param['limit']) ? 'LIMIT '.$param['limit'] : '';
			$order = isset($param['order']) ? 'ORDER BY '.$param['order'] : '';
			if (isset($param['where'])) {
				foreach ($param['where'] as $key=>$value) {
					$where .= $value.' AND ';
				}
				$where = 'WHERE '.substr($where, 0, -4);
			}
			if (isset($param['like'])) {
				foreach ($param['like'] as $key=>$value) {
					$like = "WHERE $key LIKE '%$value%'";
				}
			}
		}
		$selectFields = implode(',', $fileld);
		$table = isset($tables[1]) ? $tables[0].','.$tables[1] : $tables[0];
		$sql = "SELECT $selectFields FROM $table $where $like $order $limit";
		//echo $sql;
		$stmt = $this->execute($sql);
		$result = [];
		while ($objs = $stmt->fetchObject()) {
			$result[] = $objs;
		}
		return $result;
	}

	/**
	 * @param $tables
	 * @param array $param
	 * @return mixed
	 */
	public function total($tables, Array $param = array()) {
		$where = '';
		if (isset($param['where'])) {
			foreach ($param['where'] as $key=>$value) {
				$where .= $value.' AND ';
			}
			$where = 'WHERE '.substr($where, 0, -4);
		}
		$sql = "SELECT COUNT(*) as count FROM $tables[0] $where";
		$stmt = $this->execute($sql);
		return $stmt->fetchObject()->count;
	}

	/**
	 * @param $tables
	 * @return mixed
	 */
	public function nextId($tables) {
		$sql = "SHOW TABLE STATUS LIKE '$tables[0]'";
		$stmt = $this->execute($sql);
		return $stmt->fetchObject()->Auto_increment;
	}

	/**
	 * @param $sql
	 * @return mixed
	 */
	private function execute($sql) {
		try {
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} catch (\PDOException  $e) {
			exit('SQL语句：'.$sql.'<br />错误信息：'.$e->getMessage());
		}
		//echo $sql;
		return $stmt;
	}
	

	private function isNullArray($arry){
		if(is_array($arry) && count($arry) > 0){
			return false;
		}
		return true;
	}

}