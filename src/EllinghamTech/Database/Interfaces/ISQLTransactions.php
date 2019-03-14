<?php
namespace EllinghamTech\Database\Interfaces;

interface ISQLTransactions
{
	/**
	 * @param string $host The MySQL Hostname
	 * @param string $user The MySQL Username
	 * @param string $pass The MySQL Password
	 * @param string $databaseName The MySQL Database Name
	 *
	 * @throws \Exception
	 */
	public function init($host, $user, $pass, $databaseName);

	/**
	 * @param string $host The MySQL Hostname
	 * @param string $user The MySQL Username
	 * @param string $pass The MySQL Password
	 * @param string $databaseName The MySQL Database Name
	 *
	 * @throws \Exception
	 */
	public function establishConnection($host, $user, $pass, $databaseName);

	/**
	 * Prepare a query and returns an \EllinghamTech\Database\QueryWrapper instance
	 *
	 * @param string $query_string The query to prepare
	 * @return ISQLQuery
	 *
	 * @throws /Exception
	 */
	public function prepare($query_string);

	/**
	 * Perform a query on the database
	 *
	 * @param string $query_string The query to perform
	 * @param mixed $inputs The inputs to safely send to database
	 * @return ISQLResult MySQLResult instance
	 *
	 * @throws \Exception
	 */
	public function performQuery($query_string, $inputs = null);

	/**
	 * Begin a transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_begin();

	/**
	 * Rollback the current transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_rollback();

	/**
	 * Commit the transaction.
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_commit();

	/**
	 * Creates a named savepoint for the transaction.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_savepointCreate($name);

	/**
	 * Rollback the savepoint.
	 *
	 * @param string $name The savepoint name/identifier
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function transaction_savepointRollback($name);
}