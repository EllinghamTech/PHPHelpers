<?php
namespace EllinghamTech\Database\Interfaces;

interface ISQL
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
}