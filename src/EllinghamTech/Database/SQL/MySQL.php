<?php
namespace EllinghamTech\Database\SQL;

use EllinghamTech\Exceptions\Data\ConnectFailed;

class MySQL extends Wrapper
{
	public function __construct()
	{
		$this->database_type = 'MySQL';
	}

	/**
	 * Opens a database connection to MySQL or compatible database
	 * servers such as MariaDB.
	 *
	 * Opens a database connection to MySQL, MariaDB or compatible
	 * database servers with the given host, user, pass and databaseName.
	 *
	 * Also accepts additional PDO options as a fifth param.  No return
	 * but throws a ConnectFailed exception on failure.
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $databaseName
	 * @param array|null $pdoOptions
	 *
	 * @throws ConnectFailed If the database connection could not be opened
	 */
	public function connect(string $host, string $user, string $pass, string $databaseName, ?array $pdoOptions=null) : void
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
			throw new ConnectFailed('Failed to load database connection: '.$e->getMessage(), 0, $e);
		}
	}
}
