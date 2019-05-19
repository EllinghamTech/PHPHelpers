<?php
namespace EllinghamTech\Database\SQL;

use EllinghamTech\Exceptions\Data\NoConnection;
use EllinghamTech\Exceptions\Data\QueryFailed;

class Wrapper
{
	/** @var \PDO Database Object */
	public $db_link = null;

	/** @var string Last Query Performed */
	protected $last_query = null;

	/** @var string Sets a specific identifier for the SQL Database type (such as MySQL, SQLite) */
	public $database_type = 'SQL';

	/**
	 * Uses an existing PDO connection instead of creating
	 * a new connection to the database.
	 *
	 * @param \PDO $pdoObject An existing PDO connection
	 *
	 * @return bool False if $pdoObject param is not a valid PDO object
	 */
	public function useExistingConnection($pdoObject) : bool
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
	 *
	 * @return QueryWrapper
	 *
	 * @throws NoConnection If no connection is present
	 * @throws \EllinghamTech\Exceptions\Data\QueryFailed If the query fails to prepare
	 */
	public function prepare(string $query_string) : QueryWrapper
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return new QueryWrapper($this, $query_string);
	}

	/**
	 * Perform a query on the database
	 *
	 * @param string $query_string The query to perform
	 * @param mixed $inputs The inputs to safely send to database
	 *
	 * @return ResultWrapper MySQLResult instance
	 *
	 * @throws NoConnection If no connection is present
	 * @throws \EllinghamTech\Exceptions\Data\QueryFailed If the query fails
	 */
	public function performQuery(string $query_string, $inputs = null) : ResultWrapper
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		$res = new QueryWrapper($this, $query_string);
		return $res->execute($inputs);
	}

	/**
	 * Begin a transaction.
	 *
	 * @return bool
	 *
	 * @throws NoConnection If no connection is present
	 * @throws \PDOException If there is already a transaction started or
	 * the driver does not support transactions
	 */
	public function transaction_begin() : bool
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return $this->db_link->beginTransaction();
	}

	/**
	 * Rollback the current transaction.
	 *
	 * @return bool
	 *
	 * @throws NoConnection If no connection is present
	 * @throws \PDOException if there is no active transaction
	 */
	public function transaction_rollback() : bool
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return $this->db_link->rollBack();
	}

	/**
	 * Commit the transaction.
	 *
	 * @return bool
	 *
	 * @throws NoConnection If no connection is present
	 * @throws \PDOException if there is no active transaction
	 */
	public function transaction_commit() : bool
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return $this->db_link->commit();
	}

	/**
	 * Creates a named savepoint for the transaction.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws NoConnection If no connection is present
	 * @throws QueryFailed If the Savepoint query fails
	 */
	public function transaction_savepointCreate(string $name) : bool
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return $this->performQuery('SAVEPOINT '.$name)->isSuccess();
	}

	/**
	 * Rollback the savepoint.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws NoConnection If no connection is present
	 * @throws QueryFailed If the Savepoint query fails
	 */
	public function transaction_savepointRollback(string $name) : bool
	{
		if($this->db_link == null) throw new NoConnection('Not connected to database');
		return $this->performQuery('ROLLBACK TO '.$name)->isSuccess();
	}

	/**
	 * Returns the Database Link.  Null if it has not been set.
	 *
	 * @return \PDO|null
	 */
	public function getDBLink() : ?\PDO
	{
		return $this->db_link;
	}
}
