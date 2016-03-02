<?php

class Model {
	
	public $db;

	public function __construct() {

		$this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	private function exec($sql) {
		try {
			$sql = $this->db->prepare($sql);
			$sql->execute();

			return $sql;
		} catch (PDOException $e) {
			echo 'SQL error: ' . $e->getMessage();
		}
	}

	public function create($table, array $data) {
		ksort($data);
        
        $keys = implode('`, `', array_keys($data));
        $vals = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO `$table` (`$keys`) VALUES ($vals)";
        
        foreach ($data as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        
        $this->exec($sql);
	}

	public function read($table, $fields, $where = null) {

		$where = isset($where) ? "WHERE {$where}" : '';
		
		$fields = rtrim($fields, ',');
		
		$sql = "SELECT {$fields} FROM `{$table}` {$where}";

		$pdo = $this->exec($sql);

		//$sql->rowCount()
		return $pdo;

	}


	public function update($table, $data, $where) {

		ksort($data);

		$fields = NULL;

		foreach ($data as $key => $val) {
			$fields .= "`$key`=:$key,";
		}

		$fields = rtrim($fields, ',');

		$sql = "UPDATE `{$table}` SET {$fields} WHERE {$where}";

		foreach ($data as $key => $val) {
			$sql->bindValue(":$key", $val);
		}

		$this->exec($sql);
	}

	public function delete($table, $where, $limit = 1) {
		$sql = "DELETE FROM `{$table}` WHERE {$where} LIMIT {$limit}";
		$this->exec($sql);
	}

	public function truncate($table) {
		$sql = "TRUNCATE `{$table}`";
		$this->exec($sql);
	}

	public function dropTable($table) {
		$sql = "DROP TABLE `{$table}`";
		$this->exec($sql);
	}
}

