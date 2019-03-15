<?php
namespace EllinghamTech\Database\Interfaces;

interface ISQLTransactions extends ISQL
{
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