<?php
namespace EllinghamTech\Database\MySQL;

use EllinghamTech\Database\Interfaces\ISQLResult;

class ResultWrapper implements ISQLResult
{
	/** @var \PDOStatement Result */
	protected $result;

	/** @var bool Query Success */
	public $success;

	/** @var int After an insert query, this holds the value of the primary key using auto increment */
	public $insert_id;

	/**
	 * Set-up the instance
	 * @param \PDOStatement $pdo_result The PDO Statement object
	 */
	public function __construct($pdo_result, $success=null, $insert_id=null)
	{
		$this->result = $pdo_result;
		$this->success = $success;
		$this->insert_id = $insert_id;
	}

	/**
	 * Returns the number of rows affected
	 */
	public function numRows()
	{
		return $this->result->rowCount();
	}

	/**
	 * Returns the next row of data
	 **/
	public function fetchArray()
	{
		return $this->result->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Returns error details
	 **/
	public function errorInfo()
	{
		return $this->result->errorInfo();
	}

	public function isSuccess()
	{
		if(is_bool($this->success)) return null;
		return (bool)$this->success;
	}

	public function insertId()
	{
		return $this->insert_id;
	}
}