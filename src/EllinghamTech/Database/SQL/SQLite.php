<?php
namespace EllinghamTech\Database\SQL;

class SQLite extends Wrapper
{
	public function __construct()
	{
		$this->database_type = 'SQLite';
	}

	/**
	 * Opens an SQLite connection using PDO_SQLITE
	 *
	 * @param string $sqlite_file_location Path to SQLite file
	 *
	 * @throws \Exception If cannot open/create
	 */
	public function connect(string $sqlite_file_location) : void
	{
		if($this->db_link != null) return;

		$dsn = 'sqlite:'.$sqlite_file_location;

		try
		{
			$this->db_link = new \PDO($dsn);
		}
		catch(\PDOException $e)
		{
			$this->db_link = null;
			throw new \Exception("Failed to open database: ".$e->getMessage());
		}
	}
}
