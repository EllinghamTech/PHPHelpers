<?php
namespace EllinghamTech\Database\SQL;

use EllinghamTech\Exceptions\Data\ConnectFailed;

class SQLite extends Wrapper
{
	public function __construct()
	{
		$this->database_type = 'SQLite';
	}

	/**
	 * Opens an SQLite connection using PDO_SQLITE.
	 *
	 * Opens an SQLite connection using PDO_SQLITE.  Accepts a file
	 * location as input or special SQLite locations, such as :memory:
	 * for in-memory databases, that are compatible with PDO_SQLITE.
	 *
	 * @param string $sqlite_file_location Path to SQLite file
	 *
	 * @throws \Exception If cannot open/create the database file
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
			throw new ConnectFailed('Failed to open/create database: '.$e->getMessage(), 0, $e);
		}
	}
}
