<?php
namespace EllinghamTech\Database\SQL;

class Wrapper
{
	/** @var \PDO Database Object */
	public $db_link = null;
	/** @var string Last Query Performed */
	protected $last_query;

	/**
	 * @param string $host Hostname
	 * @param string $user Username
	 * @param string $pass Password
	 * @param string $databaseName Database Name
	 * @param null|array $pdoOptions Array of PDO Options
	 *
	 * @throws \Exception If cannot connect
	 */
	public function MySQLConnect($host, $user, $pass, $databaseName, $pdoOptions=null)
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

	/**
	 * Opens an SQLite connection using PDO_SQLITE
	 *
	 * @param string $sqlite_file_location Path to SQLite file
	 *
	 * @throws \Exception If cannot open/create
	 */
	public function SQLiteConnect($sqlite_file_location)
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

	/**
	 * Uses an existing PDO connection instead of creating
	 * a new connection to the database.
	 *
	 * @param \PDO $pdoObject An existing PDO connection
	 *
	 * @return bool False if $pdoObject param is not a valid PDO object
	 */
	public function useExistingConnection($pdoObject)
	{
		if(is_a($pdoObject, '\PDO'))
			$this->db_link = $pdoObject;
		else
			return false;

		return true;
	}

	/**
	 * Prepare a query and returns an \EllinghamTech\Database\QueryWrapper instance
	 *
	 * @param string $query_string The query to prepare
	 * @return QueryWrapper
	 *
	 * @throws /Exception
	 */
	public function prepare($query_string)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return new QueryWrapper($this, $query_string);
	}

	/**
	 * Perform a query on the database
	 *
	 * @param string $query_string The query to perform
	 * @param mixed $inputs The inputs to safely send to database
	 * @return ResultWrapper MySQLResult instance
	 *
	 * @throws \Exception
	 */
	public function performQuery($query_string, $inputs = null)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		$res = new QueryWrapper($this, $query_string);
		return $res->execute($inputs);
	}

	/**
	 * Begin a transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_begin()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->beginTransaction();
	}

	/**
	 * Rollback the current transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_rollback()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->rollBack();
	}

	/**
	 * Commit the transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_commit()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->commit();
	}

	/**
	 * Creates a named savepoint for the transaction.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_savepointCreate($name)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->query('SAVEPOINT '.$name);
	}

	/**
	 * Rollback the savepoint.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_savepointRollback($name)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->query('ROLLBACK TO '.$name);
	}

	/**
	 * Returns the Database Link.  Null if it has not been set.
	 *
	 * @return \PDO|null
	 */
	public function getDBLink()
	{
		return $this->db_link;
	}
}