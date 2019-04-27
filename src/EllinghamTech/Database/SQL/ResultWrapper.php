<?php
namespace EllinghamTech\Database\SQL;

class ResultWrapper
{
	/** @var \PDOStatement Result */
	protected $result;

	/** @var bool Query Success */
	public $success;

	/** @var int After an insert query, this holds the value of the primary key using auto increment */
	public $insert_id;

	/**
	 * Set-up the instance
	 *
	 * @param \PDOStatement $pdo_result The PDO Statement object
	 * @param bool|null $success
	 * @param mixed $insert_id
	 */
	public function __construct(\PDOStatement $pdo_result, ?bool $success=null, $insert_id=null)
	{
		$this->result = $pdo_result;
		$this->success = $success;
		$this->insert_id = $insert_id;
	}

	/**
	 * Returns the number of rows affected
	 */
	public function numRows() : int
	{
		return $this->result->rowCount();
	}

	/**
	 * Returns the next row of data
	 **/
	public function fetchArray() : ?array
	{
		$arr = $this->result->fetch(\PDO::FETCH_ASSOC);

		if(!is_array($arr)) return null;

		return $arr;
	}

	/**
	 * Returns error details
	 **/
	public function errorInfo()
	{
		return $this->result->errorInfo();
	}

	public function isSuccess() : bool
	{
		return (bool)$this->success;
	}

	public function insertId() : ?int
	{
		return $this->insert_id;
	}
}
