<?php
namespace EllinghamTech\Database\SQL;

class MySQL extends Wrapper
{
	public function __construct()
	{
		$this->database_type = 'MySQL';
	}

	public function connect($host, $user, $pass, $databaseName, $pdoOptions=null)
	{
		if($this->db_link != null) return;

		$dsn = 'mysql:dbname='.$databaseName.';host='.$host;

		try
		{
			$this->db_link = new \PDO($dsn, $user, $pass, $pdoOptions);
		}
		catch(\PDOException $e)
		{
			$this->db_link = null;
			throw new \Exception("Failed to load database connection: ".$e->getMessage());
		}
	}
}